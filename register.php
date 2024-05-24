<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["newUsername"]) && isset($_POST["newPin"])) {
        $newUsername = $_POST["newUsername"];
        $newPin = $_POST["newPin"];

        // Database connection
        $servername = "localhost";
        $username_db = "root";
        $password_db = "";
        $dbname = "atm_database";

        // Create connection
        $conn = new mysqli($servername, $username_db, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if a user already exists
        $sql_check = "SELECT * FROM users WHERE username = '$newUsername'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            echo "User already exists.";
        } else {
            // Register the new user
            $sql_register = "INSERT INTO users (username, pin) VALUES ('$newUsername', '$newPin')";
            if ($conn->query($sql_register) === TRUE) {
                echo "success";
            } else {
                echo "Error: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "Please provide a username and PIN.";
    }
} else {
    echo "Invalid request method.";
}
?>
