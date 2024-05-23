<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Check</title>
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
            max-width: 400px;
            margin: 50px auto;
            position: relative;
            bottom: 80px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #767676;
        }

        .form-group {
            margin-bottom: 6px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="password"],
        input[type="text"] {
            width: 96%;
background-color: #FFFFFF7B;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 105%;
            padding: 10px;
            background-color: #007BFF81;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2877CC5C;
        }

        #balanceResult {
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
        }

        .balance {
     
            padding: 1px;
            background-color:transparent; /* Light gray background */
          
            
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Balance Check</h1>
        <div id="balanceResult" class="balance"></div>
        <form id="balanceForm">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Pin" required>
            </div>
            <button type="button" onclick="checkBalance()">Check Balance</button>
        </form>
        <div id="balanceResult" class="balance"></div>
    </div>

    <script>
        function checkBalance() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("balanceResult").innerHTML = xhr.responseText;
                }
            };
            xhr.open("POST", "balance_checker.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("username=" + username + "&password=" + password);
        }
    </script>
</body>
</html>
