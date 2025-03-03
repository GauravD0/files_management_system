<?php
include('connect.php');

$userId = $_GET['user_id'];

$today = date('Y-m-d');
$weekStart = date('Y-m-d', strtotime('last monday', strtotime($today)));
$weekDays = [];
$fullDates = []; // Store full dates for tooltips

// Generate short names for weekdays & full dates
for ($i = 0; $i < 7; $i++) {
    $date = date('Y-m-d', strtotime($weekStart . " +$i days"));
    $shortDayName = date('D', strtotime($date)); // "Mon", "Tue"
    $fullDate = date('d M Y', strtotime($date)); // "04 Mar 2025"
    
    $weekDays[$date] = $shortDayName;
    $fullDates[$date] = $fullDate;
}

$query = "SELECT 
            DATE(login_time) AS activity_date,
            SUM(TIMESTAMPDIFF(SECOND, login_time, logout_time)) AS total_seconds
          FROM user_activity
          WHERE user_id = '$userId' AND logout_time IS NOT NULL 
            AND DATE(login_time) BETWEEN '$weekStart' AND '$today'
          GROUP BY DATE(login_time)
          ORDER BY activity_date ASC";

$result = mysqli_query($con, $query);
$timeSpent = array_fill_keys(array_keys($weekDays), 0);

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['activity_date'];
    $total_seconds = $row['total_seconds'];

    // Convert time to hours (numeric format for Chart.js)
    $timeSpent[$date] = round($total_seconds / 3600, 2);
}

// Send short weekdays, time spent, and full dates
echo json_encode([
    'weekDays' => array_values($weekDays),
    'timeSpent' => array_values($timeSpent),
    'fullDates' => array_values($fullDates)
]);
?>
