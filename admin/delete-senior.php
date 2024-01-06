<?php
session_start();
require '../session/db.php';

if (isset($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    // Perform the delete operation
    $deleteQuery = "DELETE FROM users WHERE user_id= '$user_id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        die("Delete operation failed: " . mysqli_error($conn));
    }

    // Optionally, you can perform additional cleanup or update operations here

    // Send a success response
    echo "Senior deleted successfully";
} else {
    // Handle the case when senior_id is not provided in the POST request
    echo "Invalid request";
}

mysqli_close($conn);
?>
