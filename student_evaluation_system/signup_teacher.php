<!DOCTYPE html>
<html>
<head>
    <title>Sign Up as Teacher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            background-image: url('jaah.jpg');
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            text-align: center;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input {
            padding: 10px;
            margin: 10px;
            width: 80%;
            max-width: 400px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            padding: 15px 30px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 80%;
            max-width: 400px;
            margin-top: 20px;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign Up as Teacher</h1>

        <form method="POST" action="signup_process.php">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>

            <input type="hidden" name="role" value="teacher">
            
            <button type="submit">Sign Up</button>
        </form>

        <div class="back-link">
            <a href="index.php">Back to Login</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Student Online Evaluation System | All Rights Reserved</p>
    </footer>
</body>
</html>
