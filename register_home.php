<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            top: 190px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #727171;
        }

        form {
            margin-top: 20px;
            text-align: center;
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
            width: 280px;
            padding: 10px;
            border: 1px solid #dbdbdb;
            background-color: #FFFFFF44;
            border-radius: 3px;
        }

        button {
            width: 300px;
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <h2>Register</h2>
            <form action="register.php" method="POST">
                <div class="input-group">
                    <input type="text" id="newUsername" name="newUsername" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" id="newPin" name="newPin" placeholder="Pin" required>
                </div>
                <button type="submit">Register</button>
                <div class="message"></div>
            </form>
        </div>
    </div>
</body>
</html>
