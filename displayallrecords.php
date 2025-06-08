<?php include 'header.php'; ?>
</head>

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
    <?php include 'footer.php'; ?>
    <style>
        .winners{
       color:#007bff; font-weight:900;
        }
    </style>