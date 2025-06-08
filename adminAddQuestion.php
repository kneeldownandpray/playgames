<?php include 'header.php'; ?>
    <h2>Add Question</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="idOfQuestionaire">Questionnaire ID:</label>

        <input type="text" name="idOfQuestionaire" id="idOfQuestionaire"><br><br>
        <label for="correctAnswer">Type Of Question:</label>
        <select name="typeOfQuestion" id="typeOfQuestion">
        <option value="True/False">True Or False</option>
        <option value="Multiple Choice">Multiple Choice</option>
        </select>

        <br><br>
        <label for="question">Question:</label>
        <input type="text" name="question" id="question"><br><br>
        
        <label for="choiceA">Choice A:</label>
        <input type="text" name="choiceA" id="choiceA"><br><br>
        
        <label for="choiceB">Choice B:</label>
        <input type="text" name="choiceB" id="choiceB"><br><br>
        
        <label for="choiceC">Choice C:</label>
        <input type="text" name="choiceC" id="choiceC"><br><br>
        
        <label for="choiceD">Choice D:</label>
        <input type="text" name="choiceD" id="choiceD"><br><br>
        
        <label for="correctAnswer">Correct Answer:</label>

            <select name="correctAnswer" id="correctAnswer">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select><br><br>

        
        <input  class="edit" type="submit" name="submit" value="Submit">
    </form>

    <?php
    // Database connection code...
    require_once 'database/db_connection.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form data
        $idOfQuestionaire = $_POST["idOfQuestionaire"];
        $typeOfQuestion = $_POST["typeOfQuestion"];
        $question = $_POST["question"];
        $choiceA = $_POST["choiceA"];
        $choiceB = $_POST["choiceB"];
        $choiceC = $_POST["choiceC"];
        $choiceD = $_POST["choiceD"];
        $correctAnswer = $_POST["correctAnswer"];

        // Insert the question into the database
        $sql = "INSERT INTO questionaire (IdOfQuestionaire, TypeOfquestion, question, choiceA, choiceB, choiceC, choiceD, correctAnswer) VALUES ('$idOfQuestionaire', '$typeOfQuestion', '$question', '$choiceA', '$choiceB', '$choiceC', '$choiceD', '$correctAnswer')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Question Added successfully!');</script>";
            // Redirect to displayallquestion.php on success
            echo "<script>window.location.href='displayallquestion.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>
  <?php include 'footer.php'; ?>