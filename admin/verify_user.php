<?php
// verify_user.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../session/db.php';
require '../vendor/autoload.php';
require '../session/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Perform the update query to change the user status to "Verified"
    $updateQuery = "UPDATE users SET Status = 'Verified' WHERE user_id = $userId";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // User successfully verified

        // Send verification email
        $selectEmailQuery = "SELECT Email FROM users WHERE user_id = $userId";
        $emailResult = mysqli_query($conn, $selectEmailQuery);
        $userData = mysqli_fetch_assoc($emailResult);
        $userEmail = $userData['Email'];

        // Create a new PHPMailer instance
        $mail = new PHPMailer;

        // Set up the SMTP server
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Username = SMTP_USERNAME; // Use the constant
        $mail->Password = SMTP_PASSWORD; // Use the constant

        $mail->setFrom(SMTP_USERNAME,  'Verified ID/Account');
        $mail->addAddress($userEmail);
        $mail->Subject = 'Verification for Senior ID';
        $mail->Body = 'Dear User,

        Your uploaded ID has been successfully verified. Thank you for choosing our service.

        You can now login to your account.
        
        Best regards,
        GoldenCareHub Team';

        // Send the email
        if ($mail->send()) {
            // Successful email sending, show an alert and redirect
            echo "<script>alert('User successfully verified! Verification email sent.');</script>";
            header('Location: citizens-list.php'); // Redirect to the page with the table
            exit();
        } else {
            // Handle the error, e.g., display an error message
            echo "Error sending verification email: " . $mail->ErrorInfo;
        }
    } else {
        // Handle the error, e.g., display an error message
        echo "Error updating user status: " . mysqli_error($conn);
    }
}
?>
