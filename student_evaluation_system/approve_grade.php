<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in as a teacher
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (isset($_POST['grade_id']) && isset($_POST['action'])) {
    $grade_id = $_POST['grade_id'];
    $action = $_POST['action'];

    // Check if the action is either 'approve' or 'reject'
    if ($action !== 'approve' && $action !== 'reject') {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit;
    }

    // Use prepared statement to prevent SQL injection
    if ($action == 'approve') {
        $new_status = 'approved';
    } elseif ($action == 'reject') {
        $new_status = 'rejected';
    }

    // Prepare the SQL query to update the grade status
    $stmt = $conn->prepare("UPDATE grades SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $grade_id); // "si" means string and integer type

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => ucfirst($action) . 'd successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update grade']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
