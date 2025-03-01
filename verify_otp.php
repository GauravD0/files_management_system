<?php
session_start();
include('connect.php');

if (!isset($_SESSION['reset_email'])) {
    echo "<script>alert('Unauthorized access!'); window.location.href='forgot_password.php';</script>";
    exit();
}

if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    $stored_otp = $_SESSION['otp']; // Retrieve OTP from session

    if ($entered_otp == $stored_otp) {
        unset($_SESSION['otp']); // Remove OTP from session
        echo "<script>alert('OTP verified successfully!'); window.location.href='reset_password.php';</script>";
        exit();
    } else {
        echo "<script>alert('Invalid OTP! Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="card w-full max-w-sm bg-white shadow-xl p-8 rounded-lg">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">Verify OTP</h2>
        
        <form method="post" class="space-y-4">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Enter OTP</span>
                </div>
                <input type="text" name="otp" class="input input-bordered w-full" placeholder="Enter OTP" required />
            </label>

            <button type="submit" name="verify_otp" class="btn btn-primary w-full">Verify OTP</button>
        </form>
    </div>
</body>
</html>
