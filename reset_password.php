<?php
session_start();
include('connect.php');

if (!isset($_SESSION['reset_email'])) {
    echo "<script>alert('Session expired! Please request a new password reset.'); window.location.href='forgot_password.php';</script>";
    exit();
}

if (isset($_POST['reset_password'])) {
    $email = $_SESSION['reset_email'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Update the password in the database (WITHOUT HASHING)
        $update_query = mysqli_query($con, "UPDATE register SET pass = '$new_password' WHERE email = '$email'");

        if ($update_query) {
            echo "<script>alert('Password updated successfully! Please log in.'); window.location.href='login.php';</script>";
            session_destroy(); // Destroy session after reset
        } else {
            echo "<script>alert('Error updating password! Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="card w-full max-w-sm bg-white shadow-xl p-8 rounded-lg">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">Reset Password</h2>
        
        <form method="post" class="space-y-4">
            <!-- New Password Input -->
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold text-gray-700">New Password</span>
                </div>
                <input type="password" name="password" class="input input-bordered w-full py-3 rounded-lg shadow-sm" placeholder="Enter new password" required />
            </label>

            <!-- Confirm Password Input -->
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-semibold text-gray-700">Confirm Password</span>
                </div>
                <input type="password" name="confirm_password" class="input input-bordered w-full py-3 rounded-lg shadow-sm" placeholder="Re-enter new password" required />
            </label>

            <button type="submit" name="reset_password" class="btn btn-primary w-full py-3 rounded-lg text-lg">Reset Password</button>
        </form>
    </div>
</body>
</html>
