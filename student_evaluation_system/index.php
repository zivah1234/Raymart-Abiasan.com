<!DOCTYPE html>
<html>
<head>
    <title>Student Online Evaluation System</title>
    <header>
    <p>Quirino State University</a></p>
    </header>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 140vh;
            flex-direction: column;
            background-image: url('jaah.jpg');
            background-position: center;
            background-size: cover;
            min-height: 100vh; 
            color:white ;
        }

        h1 {
            text-align: center;
            color: white;
        }

        .container {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            text-align: center;
           
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(15px);
            
        }

        header {
            display: flex;
            justify-content: space-around;
            background-color: #4CAF50;
            padding: 5px;
            width: 100%;
            font-size: 300%;
            
        }
        

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input, select {
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

        hr {
            margin-top: 20px;
        }

        .section {
            margin-top: 40px;
            text-align: center;
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
        <h1>Welcome to Student Online Evaluation System</h1>
        
        <!-- Login Form -->
        <form method="POST" action="login.php">
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

        <hr>

        <!-- Sign Up Section -->
        <h2>Don't have an account?</h2>
        <button onclick="window.location.href='signup_student.php?role=student'">Sign Up as Student</button>
        <button onclick="window.location.href='signup_teacher.php?role=teacher'">Sign Up as Teacher</button>

        <hr>

        <!-- About Us Section -->
        <div id="about-us" class="section">
            <h2>About Us</h2>
            <p>
                The Student Online Evaluation System aims to provide a seamless and efficient platform for evaluating students' performance. The system helps students, teachers, and administrators manage the evaluation process effectively.
            </p>
        </div>

        <!-- Contact Me Section -->
        <div id="contact-me" class="section">
            <h2>Contact Me</h2>
            <p>If you have any questions or need support, feel free to contact us:</p>
            <p>Email: <a href="mailto:support@evaluation.com">martmartrayray@gmail.com</a></p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
    <p>&copy; 2024 Abiasan Raymart | <a href="https://qsu.edu.ph/info/">Quirino State University</a></p>
    </footer>
</body>
</html>
