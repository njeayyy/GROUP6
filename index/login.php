<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include your database connection file
include('../session/db.php');
require '../vendor/autoload.php';
require '../session/config.php';




if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] == "Admin") {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../user/userdashboard.php");
    }
    exit;
}




// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetch user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    /// Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT user_id, Email, password, Last_Name, First_Name, Role, OTP, OTP_Expiration, OTP_activated, Status FROM users WHERE Email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();


    // Check if a user with the given username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $dbUsername, $dbPassword, $lastName, $firstName, $userRole, $otpFromDb, $otpExpiration, $otpActivated, $userStatus);


        $stmt->fetch();
        if ($userStatus == 'Verified') {
        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $dbPassword)) {
            // Password is correct, set up a session or redirect based on the role
            session_start();
      
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $dbUsername;
            $_SESSION['Last_name'] = $lastName;
            $_SESSION['First_name'] = $firstName;
                

            if ($otpExpiration > date('Y-m-d H:i:s')) {
                // OTP is still valid, proceed with the login
                if ($otpActivated == 0) {
                    // Generate a random OTP
                    $otp = mt_rand(100000, 999999);

                    // Set OTP, its expiration time, and mark OTP as not activated in the database
                    $otpExpiration = date('Y-m-d H:i:s', strtotime('+7 days')); // Change the expiration time as needed

                    $updateStmt = $conn->prepare("UPDATE users SET OTP = ?, OTP_Expiration = ?, OTP_activated = 0 WHERE user_id = ?");
                    $updateStmt->bind_param("ssi", $otp, $otpExpiration, $userId);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // Send OTP to the user's email using PHPMailer
                    $mail = new PHPMailer(true);

                    try {

                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        $mail->Username = SMTP_USERNAME; // Use the constant
                        $mail->Password = SMTP_PASSWORD; // Use the constant
    
                            $mail->setFrom(SMTP_USERNAME,  'OTP VERIFICATION');
                            $mail->addAddress($dbUsername); // User's email address
    
                            $mail->isHTML(true);
                            $mail->Subject = 'OTP for Login';
                            $mail->Body    = 'Your OTP is: ' . $otp;
    
                            $mail->send();
                        // ... (your existing email sending code)

                        // Redirect the user to OTP.php
                        header("Location: otp.php");
                        exit();
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            } else {
                // OTP has expired, send a new OTP
                echo "<script>alert('OTP has expired. Sending a new OTP.');</script>";

                // Generate a random OTP
                $otp = mt_rand(100000, 999999);

                // Set OTP, its expiration time, and mark OTP as not activated in the database
                $otpExpiration = date('Y-m-d H:i:s', strtotime('+7 days'));

                $updateStmt = $conn->prepare("UPDATE users SET OTP = ?, OTP_Expiration = ?, OTP_activated = 0 WHERE user_id = ?");
                $updateStmt->bind_param("ssi", $otp, $otpExpiration, $userId);
                $updateStmt->execute();
                $updateStmt->close();

                // Send OTP to the user's email using PHPMailer
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->Username = SMTP_USERNAME; // Use the constant
                    $mail->Password = SMTP_PASSWORD; // Use the constant

                        $mail->setFrom(SMTP_USERNAME,  'OTP VERIFICATION');
                        $mail->addAddress($dbUsername); // User's email address

                        $mail->isHTML(true);
                        $mail->Subject = 'OTP for Login';
                        $mail->Body    = 'Your OTP is: ' . $otp;

                        $mail->send();

                    // ... (your existing email sending code)

                    // Redirect the user to OTP.php
                    header("Location: otp.php");
                    exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }

            if ($userRole == 'Admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/userdashboard.php");
            }
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }

    } else {
        // User is not verified
        // User is not verified, redirect to notverifiy.php
        header("Location: notyetverified.php");
        exit();

    }
    
    } else {
        // User with the given username does not exist
        echo "<script>alert('User not found. Please check your username.');</script>";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENIOR CITIZEN INFORMATION SYSTEM</title>
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
              <h2>Login</h2>
            </div>
            <div class="auth-form">
            <form id="login-form" method="post" action="">
                <div class="form-group">
                  <label for="username">Username:</label>
                  <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                  <button type="submit">Login</button>
                </div>
              </form>
           
            </div>
            <div class="switch-form">
            <a href="signup.php"> <button>Switch to Sign Up</button> </a>
            </div>
          </div>

    </section>


</body>
</html>