<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'teacher') {
    header('Location: index.php');
    exit();
}

include 'db.php';

// Get student ID
$student_id = $_GET['student_id'];
$query = "UPDATE grades SET status = 'rejected' WHERE student_id = '$student_id'";
if ($conn->query($query) === TRUE) {
    echo "Grade rejected!";
} else {
    echo "Error: " . $conn->error;
}
?>

<a href="teacher.php">Back to Teacher Dashboard</a>
