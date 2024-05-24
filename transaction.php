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

        .message-container {
            width: 100%;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Transaction</h2>
        <form id="transactionForm">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="PIN" required>
            </div>
            <div class="form-group">
                <input type="text" id="recipient_username" name="recipient_username" placeholder="Recipient Name" required>
            </div>
            <div class="form-group">
                <input type="number" id="amount" name="amount" placeholder="Amount" required>
            </div>
            <div class="form-group">
                <input type="text" id="description" name="description" placeholder="Purpose of sending money (optional)">
            </div>
            <button type="submit">Submit</button>
        </form>
        <div class="message-container">
            <div class="error-message" style="display: none;"></div>
            <div class="success-message" style="display: none;"></div>
        </div>
    </div>  

    <audio id="clickSound" src="atm/beep2.mp3" preload="auto"></audio>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const clickSound = document.getElementById('clickSound');
            const transactionForm = document.getElementById('transactionForm');
            const submitButton = transactionForm.querySelector('button[type="submit"]');

            function playSound(event) {
                event.preventDefault(); // Prevent the form from submitting immediately
                clickSound.currentTime = 0; // Rewind to the start
                clickSound.play().catch(function(error) {
                    console.log('Playback prevented: ' + error);
                });

                // Delay form submission to allow sound to play
                setTimeout(function() {
                    transactionForm.submit();
                }, 500); // 500 milliseconds = 0.5 seconds delay
            }

            submitButton.addEventListener('click', playSound);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const transactionForm = document.getElementById("transactionForm");

            transactionForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the form from submitting traditionally

                const formData = new FormData(transactionForm);
                const xhr = new XMLHttpRequest();

                xhr.onload = function() {
                    const errorMessage = document.querySelector('.error-message');
                    const successMessage = document.querySelector('.success-message');

                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);

                        if (response.success) {
                            successMessage.textContent = response.message;
                            successMessage.style.display = 'block';
                            errorMessage.style.display = 'none';
                        } else {
                            errorMessage.textContent = response.message;
                            errorMessage.style.display = 'block';
                            successMessage.style.display = 'none';
                        }
                    } else {
                        alert("Error: " + xhr.statusText);
                    }
                };

                xhr.onerror = function() {
                    alert("Request failed.");
                };

                xhr.open("POST", "process_transaction.php");
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>
