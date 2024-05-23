<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atm_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to authenticate the user and return the username if authentication is successful
function authenticate($conn, $username, $password) {
    // SQL query to check user credentials
    $sql = "SELECT username FROM users WHERE username='$username' AND pin='$password'";
    $result = $conn->query($sql);

    // Check if a user with the provided credentials exists
    if ($result->num_rows > 0) {
        // Fetch the username and return it
        $row = $result->fetch_assoc();
        return $row['username']; // Return the username
    } else {
        return false; // Authentication failed
    }
}
?>
