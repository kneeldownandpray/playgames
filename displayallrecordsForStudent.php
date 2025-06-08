<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - All Questions</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="adminstyle.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

</head>
<body>
    <header class="drawer-header">
        <div class="drawer-toggle">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 11h16v2H4zm0-4h16v2H4zm0 8h16v2H4zm0 4h16v2H4z"/>
            </svg> -->
        </div>
        <div style="
        width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
        ">
            <div class="drawer-logo">Questionaire Management </div>
            <div style="display:flex;">
           <a href="/" style="text-decoration:none;"><div class="drawer-logo">Back to Game </div></a>
            </div>
        </div>
        </div>
    </header>
    <div class="container">

<body>
    <h2>Admin Panel - All Questions</h2>
    <table>
        <tr>
            <!-- <th>ID</th> -->
            <th>Player 1 name</th>
            <th>Player 1 Score</th>
            <th>Player 2 name</th>
            <th >Winner</th>
        </tr>

        <?php
// Database connection code...
require_once 'database/db_connection.php';

// Fetch all records from the t1 table
$sql = "SELECT * FROM t1 ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["player1name"] . "</td>"; // Displaying 'player1score'
        echo "<td>" . $row["player1score"] . "</td>"; // Displaying 'player1score'
        echo "<td>" . $row["player2name"] . "</td>"; // Displaying 'player2score'
        echo "<td class=winners>" . $row["winner"] . "</td>"; // Displaying 'player2score'
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No records found.</td></tr>";
}
?>
    </table>

    <style>
        .winners{
       color:#007bff; font-weight:900;
        }
    </style>

    
</div><!-- .container -->
<footer class="drawer-footer">
    <p>This is the footer</p>
    <p>&copy; 2024 Your Company. All rights reserved.</p>
</footer>
</body>
</html>
