<?php
include 'db_connection.php'; // Include the database connection file

// Query to fetch transaction history
$sql = "SELECT * FROM atm_transactions";
$result = $conn->query($sql);

// Store transaction history in an array
$transactions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(atm/machine.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: 550px;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width:300px;
            border-radius: 30px;
            padding: 20px;
            overflow-y: auto; /* Enable vertical scrolling */
            background-color: #FFFFFF00;
            color: #706E6E;
            max-height: 30%;
            border: none;
            position: relative;
            bottom: 55px;
        }

        .transaction {
            margin-bottom: 10px;
            padding: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Transaction History</h3>
        <?php if (!empty($transactions)): ?>
            <?php foreach ($transactions as $transaction): ?>
                <div class="transaction">
                    <p><strong>Transaction ID:</strong> <?php echo $transaction['transaction_id']; ?></p>
                    <p><strong>Sender ID:</strong> <?php echo $transaction['sender_id']; ?></p>
                    <p><strong>Receiver ID:</strong> <?php echo $transaction['receiver_id']; ?></p>
                    <p><strong>Amount:</strong> <?php echo $transaction['amount']; ?></p>
                    <p><strong>Transfer Date:</strong> <?php echo $transaction['transfer_date']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No transactions found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
