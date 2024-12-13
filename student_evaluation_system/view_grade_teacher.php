<?php
session_start();
include 'db.php'; // Include the database connection

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'teacher') {
    header("Location: index.php");
    exit;
}

// Check if a student ID was passed
if (isset($_POST['student_id'])) {
    $student_id = intval($_POST['student_id']);
    
    // Fetch grades for this student
    $query = "SELECT s.subject_name, g.grade, 
                     CASE 
                         WHEN g.grade >= 1.0 AND g.grade <= 3.0 THEN 'Passed' 
                         WHEN g.grade > 3.0 AND g.grade <= 5.0 THEN 'Failed' 
                         ELSE 'Unknown' -- Handle any other cases
                     END AS status
              FROM grades g
              JOIN subjects s ON g.subject_id = s.id
              WHERE g.student_id = ?";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement']);
        exit;
    }
    
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $grades = [];
    while ($row = $result->fetch_assoc()) {
        $grades[] = [
            'subject_name' => $row['subject_name'],
            'grade' => $row['grade'],
            'status' => $row['status']
        ];
    }
    
    if (!empty($grades)) {
        echo json_encode(['success' => true, 'grades' => $grades]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No grades found for this student']);
    }
    
    $stmt->close();
}
?>
