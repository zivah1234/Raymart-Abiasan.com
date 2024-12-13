<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'teacher') {
        header("Location: index.php");
        exit;
    }

    $id = $_POST['id'];
    $grade = $_POST['grade'];

    // Update grade in the database
    $query = "UPDATE students SET grade = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $grade, $id);

    if ($stmt->execute()) {
        echo "Grade updated successfully!";
    } else {
        echo "Error updating grade: " . $conn->error;
    }

    echo "<a href='view_students.php'>Back to Student List</a>";
}
?>
