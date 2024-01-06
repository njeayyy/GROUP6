<?php
session_start();
require '../session/db.php';

if (isset($_POST['senior_id'])) {
    $seniorId = mysqli_real_escape_string($conn, $_POST['senior_id']);

    // Perform the delete operation
    $deleteQuery = "DELETE FROM senior_table WHERE Senior_ID = '$seniorId'";
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
