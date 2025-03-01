<?php
session_start();
include('connect.php');
include('send_otpmail.php'); // Include OTP sending function

if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];

    // Check if email exists in database
    $query = mysqli_query($con, "SELECT * FROM register WHERE email = '$email'");
    if (mysqli_num_rows($query) > 0) {
        $_SESSION['reset_email'] = $email; // Store email in session

        $otp_sent = sendOTPEmail($email); // Call function to send OTP

        if ($otp_sent === true) {
            echo "<script>alert('OTP sent successfully!'); window.location.href='verify_otp.php';</script>";
        } else {
            echo "<script>alert('Error: $otp_sent');</script>";
        }
    } else {
        echo "<script>alert('Email not found! Please enter a registered email.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="card w-full max-w-sm bg-white shadow-xl p-8 rounded-lg">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">Forgot Password</h2>
        
        <form method="post" class="space-y-4">
            <label class="form-control w-full">
                <div class="label">
                <span class="label-text font-semibold text-gray-700">Enter your email</span>
                </div>
                <input type="email" name="email" class="input input-bordered w-full" placeholder="Enter your registered email" required />
            </label>

            <button type="submit" name="send_otp" class="btn btn-primary w-full">Send OTP</button>
        </form>
    </div>
</body>
</html>
