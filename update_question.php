<?php
// Database connection code...
require_once 'database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST["id"];
    $questionnaireId = $_POST["idOfQuestionaire"]; // Update to match form field name
   // Retrieve form data
    $id = $_POST["id"];
    $questionnaireId = $_POST["idOfQuestionaire"];
    $typeOfQuestion = $_POST["typeOfQuestion"];
    $question = $_POST["question"];
    $choiceA = $_POST["choiceA"];
    $choiceB = $_POST["choiceB"];
    $choiceC = $_POST["choiceC"];
    $choiceD = $_POST["choiceD"];
    $correctAnswer = $_POST["correctAnswer"];


    // Update the question in the database
    $sql = "UPDATE questionaire 
            SET IdOfQuestionaire='$questionnaireId', 
                TypeOfquestion='$typeOfQuestion', 
                question='$question', 
                choiceA='$choiceA', 
                choiceB='$choiceB', 
                choiceC='$choiceC', 
                choiceD='$choiceD', 
                correctAnswer='$correctAnswer' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Question updated successfully!');</script>";
        echo "<script>window.location.href='displayallquestion.php';</script>";
        exit();
    } else {
        echo "Error updating question: " . $conn->error;
    }
}
?>
