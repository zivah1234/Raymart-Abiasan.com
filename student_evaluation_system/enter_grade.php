<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    http_response_code(401); // Unauthorized
    echo "Unauthorized access.";
    exit;
}

include 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize POST data
    $subject_id = isset($_POST['subject_id']) ? intval($_POST['subject_id']) : 0;
    $grade = isset($_POST['grade']) ? floatval($_POST['grade']) : null;
    $student_id = intval($_SESSION['user']['id']); // Access student ID from session

    // Check for valid inputs
    if ($subject_id <= 0 || $grade === null || $grade < 0 || $grade > 100) {
        http_response_code(400); // Bad Request
        echo "Invalid data provided.";
        exit;
    }

    // Insert grade into the grades table or update if the grade already exists
    $query = "INSERT INTO grades (student_id, subject_id, grade) 
              VALUES ('$student_id', '$subject_id', '$grade')
              ON DUPLICATE KEY UPDATE grade = '$grade'"; // Update if grade already exists

    if ($conn->query($query) === TRUE) {
        echo "success"; // Return 'success' for JavaScript to process
    } else {
        http_response_code(500); // Internal Server Error
        echo "Error entering grade: " . $conn->error;
    }
}
?>
