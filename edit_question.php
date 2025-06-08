<?php include 'header.php'; ?>

<h2>Edit Question</h2>

<?php
// Database connection code...
require_once 'database/db_connection.php';

// Check if question ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Retrieve the question ID from the URL
    $question_id = $_GET['id'];

    // Fetch the existing question details from the database
    $sql = "SELECT * FROM questionaire WHERE id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Retrieve the question details
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $questionnaireId = $row["IdOfQuestionaire"];
        $typeOfQuestion = $row["TypeOfquestion"];
        $question = $row["question"];
        $choiceA = $row["choiceA"];
        $choiceB = $row["choiceB"];
        $choiceC = $row["choiceC"];
        $choiceD = $row["choiceD"];
        $correctAnswer = $row["correctAnswer"];
?>

        <form method="post" action="update_question.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="idOfQuestionaire">Questionnaire ID:</label>
            <input type="text" name="idOfQuestionaire" id="idOfQuestionaire" value="<?php echo $questionnaireId; ?>"><br><br>

            <label for="typeOfQuestion">Type of Question:</label>
            <input type="text" name="typeOfQuestion" id="typeOfQuestion" value="<?php echo $typeOfQuestion; ?>"><br><br>

            <label for="question">Question:</label>
            <input type="text" name="question" id="question" value="<?php echo $question; ?>"><br><br>

            <label for="choiceA">Choice A:</label>
            <input type="text" name="choiceA" id="choiceA" value="<?php echo $choiceA; ?>"><br><br>

            <label for="choiceB">Choice B:</label>
            <input type="text" name="choiceB" id="choiceB" value="<?php echo $choiceB; ?>"><br><br>

            <label for="choiceC">Choice C:</label>
            <input type="text" name="choiceC" id="choiceC" value="<?php echo $choiceC; ?>"><br><br>

            <label for="choiceD">Choice D:</label>
            <input type="text" name="choiceD" id="choiceD" value="<?php echo $choiceD; ?>"><br><br>

            <label for="correctAnswer">Correct Answer:</label>
            <select name="correctAnswer" id="correctAnswer">
                <option value="A" <?php if ($correctAnswer == "A") echo "selected"; ?>>A</option>
                <option value="B" <?php if ($correctAnswer == "B") echo "selected"; ?>>B</option>
                <option value="C" <?php if ($correctAnswer == "C") echo "selected"; ?>>C</option>
                <option value="D" <?php if ($correctAnswer == "D") echo "selected"; ?>>D</option>
            </select>

            <input class="edit" type="submit" name="submit" value="Update">
        </form>

<?php
    } else {
        echo "Question not found.";
    }
} else {
    echo "Invalid request.";
}
?>

<?php include 'footer.php'; ?>
