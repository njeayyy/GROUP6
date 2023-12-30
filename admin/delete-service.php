<?php
session_start();
require '../session/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['service_id'])) {
        $serviceId = mysqli_real_escape_string($conn, $_POST['service_id']);

        $deleteQuery = "DELETE FROM services WHERE service_id = '$serviceId'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

      // At the end of delete-service.php
if ($deleteResult) {
    echo json_encode(['status' => 'success', 'message' => 'Service deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error deleting service: ' . mysqli_error($conn)]);
}

    } else {
        echo "Invalid request. Service ID not provided.";
    }
}
?>
