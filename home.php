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
    bottom: 90px;
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
    background-size: 600px;
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
    position: relative; /* Added position property */
    bottom: 55px; /* Adjusted top spacing */
    margin-left: 10px;
    padding: 10px 15px; /* Adjusted padding */
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
        <li><a href="transactions_history.php">Transactions</a></li>
        <li><a href="balance_check.php">Check Balance</a></li>
        

    </ul>
    </div>
    </div>
</body>
</html>
