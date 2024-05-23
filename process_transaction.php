<?php
include 'db_connection.php';

// Function to redirect to a specific URL
function redirect($url) {
    header("Location: $url");
    exit();
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $sender_username = $_POST["username"]; // Sender's username
    $sender_password = $_POST["password"]; // Sender's password
    $recipient_username = $_POST["recipient_username"]; // Recipient's username

    // Authenticate the sender and get the sender's user_id and balance
    $sql_sender = "SELECT user_id, balance FROM users WHERE username = '$sender_username' AND pin = '$sender_password'";
    $result_sender = $conn->query($sql_sender);

    if ($result_sender->num_rows > 0) {
        $row_sender = $result_sender->fetch_assoc();
        $sender_user_id = $row_sender["user_id"];
        $sender_balance_before = $row_sender["balance"];

        // Check if the sender has sufficient balance
        if ($sender_balance_before >= $amount) {
            // Deduct the amount from the sender's balance
            $sender_balance_after = $sender_balance_before - $amount;

            // Update sender's balance in the database
            $sql_update_sender = "UPDATE users SET balance = $sender_balance_after WHERE user_id = $sender_user_id";
            $conn->query($sql_update_sender);

            // Get recipient's user_id and balance
            $sql_recipient = "SELECT user_id, balance FROM users WHERE username = '$recipient_username'";
            $result_recipient = $conn->query($sql_recipient);

            if ($result_recipient->num_rows > 0) {
                $row_recipient = $result_recipient->fetch_assoc();
                $recipient_user_id = $row_recipient["user_id"];
                $recipient_balance_before = $row_recipient["balance"];

                // Add the amount to the recipient's balance
                $recipient_balance_after = $recipient_balance_before + $amount;

                // Update recipient's balance in the database
                $sql_update_recipient = "UPDATE users SET balance = $recipient_balance_after WHERE user_id = $recipient_user_id";
                $conn->query($sql_update_recipient);

                // Insert transaction record into atm_transactions table
                $transfer_date = date("Y-m-d H:i:s");
                $sql_insert_transaction = "INSERT INTO atm_transactions (sender_id, receiver_id, amount, transfer_date) VALUES ($sender_user_id, $recipient_user_id, $amount, '$transfer_date')";
                $conn->query($sql_insert_transaction);

                // Get the last inserted transaction ID
                $transfer_id = $conn->insert_id;

                // Transaction processed successfully message
                $response = "Transaction processed successfully.\nTransaction ID: $transfer_id\nAmount: $" . $amount . "\nDescription: " . $description;

                // Redirect to loading_success.php for 8 seconds
                redirect('loading_success.php');
            } else {
                $response = "Recipient username not found.";
            }
        } else {
            $response = "Insufficient balance.";
        }
    } else {
        $response = "Authentication failed. Please check your username and password.";
    }

    // Remove unwanted HTML symbols
    $response = strip_tags($response);

    echo $response;

    // Close database connection
    $conn->close();
}
?>
