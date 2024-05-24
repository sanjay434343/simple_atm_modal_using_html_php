<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATM System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }

        .login-container {
            display: flex;
            background-image: url(atm/machine.jpg);
            align-items: center;
            background-position: center;
            background-repeat: no-repeat;
            background-size: 600px;
            justify-content: center;
            height: 100vh;
        }

        .form-container {
            position: absolute;
            top: 180px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #E8DDDD;
        }

        form {
            margin-top: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #262626;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #dbdbdb;
            background-color: #FFFFFF44;
            border-radius: 3px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3897F06B;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #38A9FF49;
        }

        .message {
            color: #ed4956;
            margin-top: 10px;
            font-size: 14px;
        }

        .register{
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <form id="loginForm">
                <h1>ATM Login</h1>
                <div class="input-group">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>  
                <div class="input-group">
                    <input type="password" id="pin" name="pin" placeholder="PIN" required>
                </div>
                <button type="button" id="loginButton">Login</button><br>
                <a href="register_home.php" class="register">Register here</a>
                <audio id="clickSound" src="atm/beep2.mp3" preload="auto"></audio>
                <p id="message" class="message"></p>
            </form>
        </div>
    </div>

    <script>
        // Function to authenticate user
        function authenticateUser() {
            var username = document.getElementById("username").value;
            var pin = document.getElementById("pin").value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    if (response == "success") {
                        // Redirect to home.php or any other authenticated page
                        window.location.href = "home.php";
                    } else {
                        document.getElementById("message").innerHTML = "Invalid username or PIN.";
                    }
                }
            };
            xhr.open("POST", "authenticate.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("username=" + username + "&pin=" + pin);
        }

        // Add event listener to the button to play sound on each click
        document.getElementById('loginButton').addEventListener('click', function() {
            // Play the click sound
            var clickSound = document.getElementById('clickSound');
            clickSound.currentTime = 0; // Rewind to the start
            clickSound.play();

            // Authenticate user
            authenticateUser();
        });
    </script>
</body>
</html>
