<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
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
            border-radius: 5px;
            max-width: 300px;
            text-align: center;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            position: relative;
            bottom: 30px;
            color: #707070;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        textarea {
            width: 300px;
            padding: 3px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            background-color: #FFFFFF71;
            border-radius: 4px;
            position: relative;
            bottom: 45px;
        }

        button {
            background-color: #007BFF6A;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            display: block;
            margin: 0 auto;
            position: relative;
            bottom: 50px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Transaction</h2>
        <form id="transactionForm">
            <div>
              
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div>
             
                <input type="password" id="password" name="password" placeholder="PIN" required>
            </div>
            <div>
               
                <input type="text" id="recipient_username" name="recipient_username" placeholder="Recipient Name" required>
            </div>
            <div>
            
                <input type="number" id="amount" name="amount" placeholder="Amount" required>
            </div>
            <div>

                <input  type="text"    id="description" name="description" rows="3" placeholder="Purpos Of sending Money (optional)">
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const transactionForm = document.getElementById("transactionForm");

            transactionForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the form from submitting traditionally

                const formData = new FormData(transactionForm);
                const xhr = new XMLHttpRequest();

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert("Transaction successful!");
                    } else {
                        alert("Error: " + xhr.statusText);
                    }
                };

                xhr.onerror = function() {
                    alert("Request failed.");
                };

                xhr.open("POST", "process_transaction.php"); // Replace "process_transaction.php" with the URL of your PHP script
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>
