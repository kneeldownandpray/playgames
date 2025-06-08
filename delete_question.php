<?php
// Database connection code...
require_once 'database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $question_id = $_GET['id'];
    
    // Delete the question from the database
    $sql = "DELETE FROM questionaire WHERE id = $question_id";

    if ($conn->query($sql) === TRUE) {
        // Alert for successful deletion
        echo "<script>alert('Question deleted successfully!');</script>";
        // Redirect back to the page where the user came from
        echo "<script>window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        exit();
    } else {
        echo "Error deleting question: " . $conn->error;
    }
}
?>
