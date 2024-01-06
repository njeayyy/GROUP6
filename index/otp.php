<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include your database connection file
include('../session/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetch user input
    $enteredOTP = $_POST['otp'];

    // Retrieve user information from the database based on the session or any other identifier
    session_start();

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        echo "User ID: " . $userId;

    // Fetch OTP and OTP expiration from the database
    $stmt = $conn->prepare("SELECT OTP, OTP_Expiration, Role, OTP_activated FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($otpFromDb, $otpExpiration, $userRole, $otpActivated);
    $stmt->fetch();
    $stmt->close();





        // Verify the entered OTP
        if (!empty($otpFromDb) && time() <= strtotime($otpExpiration) && $enteredOTP == $otpFromDb) {
            // OTP is correct and not expired
            // You can update the user status, clear the OTP, or perform other actions as needed
            echo "<script>alert('OTP verification successful.');</script>";

            // Update OTP_activated to 1 in the database
            $updateStmt = $conn->prepare("UPDATE users SET OTP_activated = 1 WHERE user_id = ?");
            $updateStmt->bind_param("i", $userId);
            $updateStmt->execute();
            $updateStmt->close();

            // Redirect based on the user's role
            if ($userRole == 'Admin') {
                header("Location: ../admin/dashboard.php");
            } elseif ($userRole == 'User') {
                header("Location: ../user/userdashboard.php");
            } else {
                // Handle other roles as needed
                echo "<script>alert('Unknown role.');</script>";
            }
            exit();
        } else {
            // OTP verification failed
            echo "<script>alert('Invalid OTP. Please try again.');</script>";
        }
    } else {
        // User is not logged in, redirect to the login page
        header("Location: login.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <link rel="stylesheet" href="login.css">


    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
<!----icon------>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
<!---font--->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    
</head>
<body>
   


    <section class="first-section">


        <div class="auth-container">
            <div class="auth-header">
              <h2>OTP Code Verification</h2>
            </div>
            <div class="auth-form">
            <form id="login-form" method="post" action="">
                <div class="form-group">
                  <label for="otp">Enter the OTP sent into your email:</label>
                  <input type="text" id="otp" name="otp" required>
                </div>
               
                <div class="form-group">
                  <button type="submit">Verify OTP code</button>
                </div>
              </form>
           
            </div>
            <div class="switch-form">
            <a href="login.php"> <button>Back to Login</button> </a>
            </div>
        </div>

    </section>


</body>
</html>