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

        // Add deposited amount to user balance
        $new_balance = $balance + $amount;
        $update_balance_sql = "UPDATE users SET balance = $new_balance WHERE user_id = $user_id";
        $conn->query($update_balance_sql);

        // Insert deposit transaction into transactions table
        $insert_transaction_sql = "INSERT INTO transactions (user_id, amount, transaction_type, transaction_date) VALUES ('$user_id', '$amount', 'Deposit', NOW())";
        $conn->query($insert_transaction_sql);

        $success_message = "Deposit successful. Your new balance is $new_balance.";
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
    <title>ATM Deposit</title>
    <link rel="stylesheet" href="styles.css">
    <style>
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(atm/machine.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: 550px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

.container {
    width: 300px;
  position: relative;
  bottom: 70px;
    text-align: center;
}

.form-group {
    margin-bottom: 8px;
}

input[type="text"],
input[type="password"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    background-color: #FFFFFF6D;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007BFF5F;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.message-container {
    margin-bottom: 20px;
    text-align: center;
}

.error-message {
    color: red;
}

.success-message {
    color: green;
}

.balance-message {
    color: blue;
}
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #898989FD;">ATM Deposit</h2>
        
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

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="pin" name="pin" placeholder="Pin" required>
            </div>
            <div class="form-group">
                <input type="number" id="amount" name="amount" placeholder="Amount" required>
            </div>
            <button type="submit">Deposit</button>
        </form>
    </div>
</body>
</html>
