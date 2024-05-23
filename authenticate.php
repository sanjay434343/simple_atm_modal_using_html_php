<?php
include 'db_connection.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pin = $_POST["pin"];

    // Check if user exists and PIN is correct
    $check_user_sql = "SELECT * FROM users WHERE username = '$username' AND pin = '$pin'";
    $user_result = $conn->query($check_user_sql);

    if ($user_result->num_rows > 0) {
        // Authentication successful
        echo "success";
    } else {
        // Authentication failed
        echo "error";
    }
} else {
    // Invalid request method
    echo "error";
}

$conn->close();
?>
