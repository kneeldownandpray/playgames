<?php
// Database connection code...
require_once 'database/db_connection.php';

// Fetch all questions from the database
$sql = "SELECT * FROM questionaire";
$result = $conn->query($sql);
$questions = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

// Output the questions as JSON
header('Content-Type: application/json');
echo json_encode($questions);
?>
