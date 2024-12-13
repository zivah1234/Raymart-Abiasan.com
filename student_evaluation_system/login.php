<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // 'student', 'teacher', or 'admin'

    // Initialize query and check based on user role
    if ($role === 'teacher') {
        // Query to check if the teacher is approved
        $stmt = $conn->prepare("
            SELECT * 
            FROM teachers 
            WHERE username = ? AND status = 'approved'
        ");
    } elseif ($role === 'student') {
        // Regular login for students
        $stmt = $conn->prepare("SELECT * FROM students WHERE username = ?");
    } elseif ($role === 'admin') {
        // Regular login for admin
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    }

    // Bind parameters (username)
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and verify the password
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if password matches
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $role;

            // Redirect based on user role
            if ($role === 'student') {
                header("Location: student.php"); // Student dashboard
            } elseif ($role === 'teacher') {
                header("Location: teacher.php"); // Teacher dashboard
            } elseif ($role === 'admin') {
                header("Location: admin.php"); // Admin dashboard
            }
            exit;
        } else {
            echo "<p style='color: red;'>Invalid username or password!</p>";
        }
    } else {
        echo "<p style='color: red;'>Invalid username or password!</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            font-size: 14px;
            margin-top: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 14px;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>

            <label for="role">Login As:</label>
            <select name="role" id="role" required>
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                <option value="admin">Admin</option>
            </select><br>

            <button type="submit">Login</button>
        </form>

        <div class="footer">
            <a href="signup.php">Create an account</a> | <a href="forgot-password.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
