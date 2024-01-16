<?php
require '../session/db.php';

// Fetch events from the database (adjust the query based on your table structure)
$getEventsQuery = "SELECT event_id, title, start_time as start, end_time as end, place, author FROM events";
$getEventsResult = mysqli_query($conn, $getEventsQuery);

if (!$getEventsResult) {
    die("Error in query: " . mysqli_error($conn));
}

// Fetch events as an associative array
$events = array();
while ($row = mysqli_fetch_assoc($getEventsResult)) {
    $events[] = $row;
}

// Return events in JSON format
echo json_encode($events);
?>
