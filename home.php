<?php
include 'db_connection.php'; // Include database connection file

$error_message = "";
$success_message = "";
$balance_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pin = $_POST["pin"];
    $amount = $_POST["amount"];

    // Check if user exists and PIN is correct
    $check_user_sql = "SELECT user_id, balance FROM users WHERE username = '$username' AND pin = '$pin'";
    $user_result = $conn->query($check_user_sql);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row["user_id"];
        $balance = $user_row["balance"];

        if ($balance >= $amount) {
            // Deduct withdrawal amount from user balance
            $new_balance = $balance - $amount;
            $update_balance_sql = "UPDATE users SET balance = $new_balance WHERE user_id = $user_id";
            $conn->query($update_balance_sql);

            // Insert withdrawal transaction into atm_transactions table
            $insert_transaction_sql = "INSERT INTO atm_transactions (sender_id, receiver_id, amount, transfer_date) VALUES ('$user_id', NULL, '$amount', NOW())";
            $conn->query($insert_transaction_sql);

            $success_message = "Withdrawal successful. Your new balance is $new_balance.";
        } else {
            $error_message = "Insufficient funds.";
        }
    } else {
        $error_message = "Invalid username or PIN.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATM System Options</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 40px;
            color: #333;
            position: relative;
            bottom: 80px;
        }
        .form-container {
            border-radius: 5px;
            padding: 20px;
            width: 400px;
        }
        .login-container {
            background-image: url(atm/machine.jpg);
            align-items: center;
            background-position: center;
            background-repeat: no-repeat;
            background-size: 550px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 10px;
            width: 300px;
        }
        a {
            display: block;
            position: relative;
            bottom: 50px;
            border: 1px solid #ccc;
            margin-left: 10px;
            padding: 8px 15px;
            background-color: #F9FAFB46;
            color: #7F7F7F;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="form_container">
            <ul>
                <li><a href="transaction.php">Transactions</a></li>
                <li><a href="withdraw.php">Instant Withdrawals</a></li>
                <li><a href="deposit.php">ATM Deposits</a></li>
                <li><a href="transactions_history.php">Transactions History</a></li>
                <li><a href="balance_check.php">Check Balance</a></li>
            </ul>
            <audio id="clickSound" src="atm/beep2.mp3" preload="auto"></audio>
        </div>
    </div>

    <script>
        document.querySelectorAll('a').forEach(anchor => {
            anchor.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                // Play the click sound
                var clickSound = document.getElementById('clickSound');
                clickSound.currentTime = 0; // Rewind to the start
                clickSound.play().catch(function(error) {
                    console.log('Playback prevented: ' + error);
                });
                
                // Get the href attribute
                var href = this.getAttribute('href');
                
                // Wait for 2 seconds before navigating
                setTimeout(function() {
                    window.location.href = href;
                }, 1000); // 2000 milliseconds = 2 seconds
            });
        });
    </script>
</body>
</html>
