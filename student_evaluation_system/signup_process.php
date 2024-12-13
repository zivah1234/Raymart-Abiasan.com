<?php
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // We'll hash it later
    $name = trim($_POST['name']);
    $role = $_POST['role']; // 'student' or 'teacher'

    // Input validation: Ensure all fields are filled
    if (empty($username) || empty($password) || empty($name) || empty($role)) {
        echo "All fields are required!";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Process student sign up
    if ($role === 'student') {
        $year_level = $_POST['year_level'];
        $semester = $_POST['semester'];

        // Validate student data
        if (empty($year_level) || empty($semester)) {
            echo "Year level and semester are required for student registration!";
            exit;
        }

        // Use prepared statement to insert student details
        $stmt = $conn->prepare("INSERT INTO students (username, password, name, year_level, semester) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $hashed_password, $name, $year_level, $semester);
        
        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect to the index page after successful registration
            exit;
        } else {
            echo "Error creating student account: " . $conn->error;
        }

        $stmt->close();
    }
    // Process teacher sign up
    elseif ($role === 'teacher') {
        // Insert teacher details into the database with 'pending' status
        $status = 'pending'; // Teacher status is set to 'pending' by default
        $stmt = $conn->prepare("INSERT INTO teachers (username, password, name, status) 
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $name, $status);

        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect to the index page after successful registration
            exit;
        } else {
            echo "Error creating teacher account: " . $conn->error;
        }

        $stmt->close();
    }
}
?>
