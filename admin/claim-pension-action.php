<?php
// Include the session manager
require '../session/db.php';

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or another page as needed
    header("Location: ../index/login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user ID and amount from the form
    $userId = $_POST['user'];
    $amount = $_POST['amount'];

    // Validate user input (you may want to add more validation)
    if (empty($userId) || empty($amount)) {
        // Handle validation error, redirect or show an error message
        header("Location: claim-pension.php?error=InvalidInput");
        exit();
    }

    // Get the current date
    $claimDate = date('Y-m-d');

    // Insert the claim into the pensionhistory table
    $insertClaimQuery = "INSERT INTO pension_history (claim_Date, Amount, Senior_ID) VALUES ('$claimDate', '$amount', '$userId')";
    $insertClaimResult = mysqli_query($conn, $insertClaimQuery);

    if ($insertClaimResult) {
        // Claim successful, you may want to redirect or show a success message
        header("Location: claim-pension.php?success=ClaimSuccess");
        exit();
    } else {
        // Claim failed, handle the error (redirect or show an error message)
        header("Location: claim-pension.php?error=ClaimFailed");
        exit();
    }
} else {
    // If the form is not submitted, redirect to the claim-pension.php page
    header("Location: claim-pension.php");
    exit();
}
?>
