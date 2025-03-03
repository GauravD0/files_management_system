<?php
session_start();
include('connect.php');

if(isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $login_time = $_SESSION['login_time'];
    $logout_time = time();
    $duration = $logout_time - $login_time; // Calculate time spent in seconds

    // Update logout time and duration in the database
    $updateQuery = "UPDATE user_activity SET logout_time = NOW(), duration = '$duration' WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
    mysqli_query($con, $updateQuery);
}

session_destroy();
echo "<script>window.location.href='login.php';</script>";
?>
