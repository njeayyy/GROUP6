<?php
// Include the session manager
require '../session/db.php';

// Check if the user ID is provided in the GET request
if (isset($_GET['user_id'])) {
    $userId = mysqli_real_escape_string($conn, $_GET['user_id']);

    // Query to fetch user information based on user ID
    $query = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch user information as an associative array
        $userInfo = mysqli_fetch_assoc($result);

        // Return user information as JSON
        header('Content-Type: application/json');
        echo json_encode($userInfo);
    } else {
        // Handle the query error
        echo json_encode(['error' => 'Error fetching user information']);
    }
} else {
    // Handle the case where user ID is not provided
    echo json_encode(['error' => 'User ID not provided']);
}

// Close the database connection
mysqli_close($conn);
?>
