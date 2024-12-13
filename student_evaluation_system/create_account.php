<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to landing page if not logged in
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    if ($role === 'student') {
        $query = "INSERT INTO students (username, password) VALUES ('$username', '$password')";
    } elseif ($role === 'teacher') {
        $query = "INSERT INTO teachers (username, password) VALUES ('$username', '$password')";
    }

    if ($conn->query($query) === TRUE) {
        echo "Account created successfully!";
    } else {
        echo "Error creating account: " . $conn->error;
    }
}
?>
