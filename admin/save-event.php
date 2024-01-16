<?php
require '../session/db.php';

// Assuming you have a table named 'events'
$title = mysqli_real_escape_string($conn, $_POST['title']);
$start = mysqli_real_escape_string($conn, $_POST['start']);
$end = mysqli_real_escape_string($conn, $_POST['end']);
$place = mysqli_real_escape_string($conn, $_POST['place']);
$author = mysqli_real_escape_string($conn, $_POST['author']);

$insertQuery = "INSERT INTO events (title, start_time, end_time, place, author) VALUES ('$title', '$start', '$end', '$place', '$author')";
$insertResult = mysqli_query($conn, $insertQuery);

if ($insertResult) {
    echo "Event saved successfully";
} else {
    echo "Error saving event: " . mysqli_error($conn);
}
?>
