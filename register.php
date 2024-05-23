<?php
$newUsername = $_POST["newUsername"];
$newPin = $_POST["newPin"];

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "atm_database";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a user already exists
$sql_check = "SELECT * FROM users";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "error";
} else {
    // Register the new user
    $sql_register = "INSERT INTO users (username, pin) VALUES ('$newUsername', '$newPin')";
    if ($conn->query($sql_register) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}

$conn->close();
?>
