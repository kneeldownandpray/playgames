<?php
// Database connection code...
require_once 'database/db_connection.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $player1score = $_POST["player1score"];
    $player2score = $_POST["player2score"];
    $player1name = $_POST["player1name"];
    $player2name = $_POST["player2name"];
    
    // Determine the winner
    if ($player1score > $player2score) {
        $winner = $player1name;
        $winningScore =  $player1score;
    } else if ($player2score > $player1score) {
        $winner = $player2name;
        $winningScore =  $player2score;
    } else {
        $winner = "It's a draw";
    }
    
    // SQL query to insert data into a table, including the winner
    $sql = "INSERT INTO t1 (player1score, player2score, player2name, player1name, winner) VALUES ('$player1score', '$player2score', '$player2name', '$player1name', '$winner')";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        // Success message
        $message = "Your game is working successfully. Do you want to play a game again?";
    } else {
        // Error message
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            margin-bottom: 15px;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Game Result</h1>
        <p><?php echo $message; ?></p>
        <?php if(isset($winner)): ?>
            <p>The winner is <span style="color:#007bff; font-size:30px; font-weight:600;"> <?php echo $winner; ?> </span> with a score of <span style="color:red; font-size:20px; font-weight:600;"> <?php echo $winningScore; ?></span></p>
        <?php endif; ?>
        <a href="/"> Play Again</a>   <a href="/displayallrecordsForStudent.php">Check Scores</a>
    </div>
</body>
</html>

