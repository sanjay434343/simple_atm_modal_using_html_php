<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connection.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Authenticate the user based on username and password
    $sql = "SELECT username, balance FROM users WHERE username = '$username' AND pin = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User authenticated successfully, fetch username and balance
        $row = $result->fetch_assoc();
        $fetched_username = $row["username"]; // Assigning the fetched username to a different variable
        $balance = $row["balance"];
        echo "<div>Your balance is: $balance</div>";
    } else {
        echo "<div style='color: red;'>Authentication failed. Please check your username and password.</div>";
    }

    $conn->close();
}
?>
