<?php
include('connect.php');

if (!isset($_GET['user_id'])) {
    echo json_encode(["error" => "User ID not provided"]);
    exit;
}

$user_id = intval($_GET['user_id']);

// Fetch time spent (duration) per day
$query = "SELECT DATE(login_time) AS log_date, SUM(duration) / 3600 AS total_hours 
          FROM user_activity 
          WHERE user_id = ? 
          GROUP BY log_date 
          ORDER BY log_date ASC";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$activityData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $activityData[$row['log_date']] = [
        'total_hours' => round($row['total_hours'], 2),
        'file_count' => 0 // Default 0 (to be updated later)
    ];
}

// Fetch uploaded files per day
$queryUploads = "SELECT DATE(upload_time) AS upload_date, COUNT(*) AS file_count 
                 FROM uploads 
                 WHERE user_id = ? 
                 GROUP BY upload_date 
                 ORDER BY upload_date ASC";

$stmtUploads = mysqli_prepare($con, $queryUploads);
mysqli_stmt_bind_param($stmtUploads, "i", $user_id);
mysqli_stmt_execute($stmtUploads);
$resultUploads = mysqli_stmt_get_result($stmtUploads);

while ($row = mysqli_fetch_assoc($resultUploads)) {
    $date = $row['upload_date'];
    
    // If the date exists in user activity, update file count
    if (isset($activityData[$date])) {
        $activityData[$date]['file_count'] = $row['file_count'];
    } else {
        // If no login activity on this date, add it with 0 hours
        $activityData[$date] = [
            'total_hours' => 0,
            'file_count' => $row['file_count']
        ];
    }
}

// Sort by date
ksort($activityData);

// Prepare response data
$weekDays = [];
$fullDates = [];
$timeSpent = [];
$filesUploaded = [];

foreach ($activityData as $date => $data) {
    $weekDays[] = date("D", strtotime($date)); // Short day name (Mon, Tue, etc.)
    $fullDates[] = $date;
    $timeSpent[] = $data['total_hours'];
    $filesUploaded[] = $data['file_count'];
}

// Return JSON response
echo json_encode([
    "weekDays" => $weekDays,
    "fullDates" => $fullDates,
    "timeSpent" => $timeSpent,
    "filesUploaded" => $filesUploaded
]);
?>
