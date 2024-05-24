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

                $success_message = "Withdraw successful and balance $new_balance.";
            } else {
                $error_message = "Insufficient funds.";
            }
        } else {
            $error_message = "Invalid username or PIN.";
        }
    }

    $conn->close();
    ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATM Withdrawal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(atm/machine.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: 600px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 300px;
            position: relative;
            bottom: 80px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"] {
            width: 100%;
            background-color: #FFFFFF57;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF57;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0057B36C;
        }

        h1 {
            position: relative;
            bottom: -20px;
            margin-left: 25px;
            color: #656262;
        }

        .message-container {
            width: 300px;
            padding: 5px;
            text-align: center;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .success-message {
            color: green;
            margin-bottom: 10px;
        }

        .balance-message {
            color: blue;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Withdrawal form -->
    <div class="container">
        <h1>ATM Withdrawal</h1>
        <form id="withdrawalForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- Error message -->
            <?php if (!empty($error_message)): ?>
                <div class="message-container">
                    <div class="error-message"><?php echo $error_message; ?></div>
                </div>
            <?php endif; ?>

            <!-- Success message -->
            <?php if (!empty($success_message)): ?>
                <div class="message-container">
                    <div class="success-message"><?php echo $success_message; ?></div>
                </div>
            <?php endif; ?>

            <!-- Balance message -->
            <?php if (!empty($balance_message)): ?>
                <div class="message-container">
                    <div class="balance-message"><?php echo $balance_message; ?></div>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="pin" name="pin" placeholder="Pin" required>
            </div>
            <div class="form-group">
                <input type="number" id="amount" name="amount" placeholder="Amount" required>
            </div>
            <button type="submit">Withdraw</button>
        </form>
    </div>

    <audio id="clickSound" src="atm/beep2.mp3" preload="auto"></audio>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const clickSound = document.getElementById('clickSound');
            const withdrawalForm = document.getElementById('withdrawalForm');
            const submitButton = withdrawalForm.querySelector('button[type="submit"]');

            function playSound(event) {
                event.preventDefault(); // Prevent the form from submitting immediately
                clickSound.currentTime = 0; // Rewind to the start
                clickSound.play().catch(function(error) {
                    console.log('Playback prevented: ' + error);
                });

                // Delay form submission to allow sound to play
                setTimeout(function() {
                    withdrawalForm.submit();
                }, 500); // 500 milliseconds = 0.5 seconds delay
            }

            // Add click event listener to the submit button
            submitButton.addEventListener('click', playSound);
        });
    </script>
</body>
</html>
