<!DOCTYPE html>
<html>
<head>
    <title>Lan Communications System (LCS)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #36393f;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: #2f3136;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: #7289da;
            margin-bottom: 30px;
        }

        form {
            margin-bottom: 20px;
        }

        button {
            background-color: #7289da;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #677bc4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lan Communications System (LCS)</h1>
        <form action="login.php" method="GET">
            <button type="submit" name="submit1">Login</button>
        </form>
        <form action="register.php" method="GET">
            <button type="submit" name="submit2">Register</button>
        </form>
    </div>
</body>
</html>
