<?php include 'header.php'; ?>
</head>
<body>
    <h2>Student Records and Score</h2>
    <table>
        <tr>
            <!-- <th>ID</th> -->
            <!-- <th>Questionnaire ID</th> -->
            <th>Type of Question</th>
            <th>Question</th>
            <th>Choice A</th>
            <th>Choice B</th>
            <th>Choice C</th>
            <th>Choice D</th>
            <th>Correct Answer</th>
            <th>Edit</th>
            <th>Remove</th>
        </tr>

        <?php
// Database connection code...
require_once 'database/db_connection.php';

// Fetch all questions from the database
$sql = "SELECT * FROM questionaire";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        // echo "<td>" . $row["id"] . "</td>";
        // echo "<td>" . $row["IdOfQuestionaire"] . "</td>";
        echo "<td>" . $row["TypeOfquestion"] . "</td>";
        echo "<td>" . $row["question"] . "</td>";
        echo "<td>" . $row["choiceA"] . "</td>";
        echo "<td>" . $row["choiceB"] . "</td>";
        echo "<td>" . $row["choiceC"] . "</td>";
        echo "<td>" . $row["choiceD"] . "</td>";
        echo "<td>" . $row["correctAnswer"] . "</td>";
        echo "<td><a class='edit' href='edit_question.php?id=" . $row["id"] . "'>Edit</a></td>"; // Edit button
        echo "<td><a  class='delete' href='delete_question.php?id=" . $row["id"] . "'>Delete</a></td>"; // Delete button
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='11'>No questions found.</td></tr>";
}
?>

    </table>
    <?php include 'footer.php'; ?>
