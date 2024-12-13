<?php
session_start();
include 'db.php'; // Include the database connection

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'teacher') {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle AJAX request for fetching student grades
if (isset($_POST['action']) && $_POST['action'] === 'view_student_grades') {
    $student_id = intval($_POST['student_id']);

    $query = "SELECT g.id AS grade_id, sub.subject_name, g.grade, g.status
              FROM grades g
              JOIN subjects sub ON g.subject_id = sub.id
              WHERE g.student_id = '$student_id'";
    $result = $conn->query($query);

    $grades = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $grades[] = $row;
        }
    }

    echo json_encode($grades);
    exit;
}

// Handle Accept/Reject for individual grades
if (isset($_POST['grade_action'])) {
    $grade_id = intval($_POST['grade_id']);
    $new_status = $_POST['grade_action'] === 'accept' ? 'approved' : 'rejected';

    // Prepared statement to avoid SQL injection
    $stmt = $conn->prepare("UPDATE grades SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $grade_id);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit;
}

// Handle student deletion
if (isset($_GET['delete_student'])) {
    $student_id = intval($_GET['delete_student']);
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    header("Location: teacher.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; box-sizing: border-box;background-image: url('jaah.jpg'); }
        .container { max-width: 1000px; margin: 30px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h1 { font-size: 24px; color: #333; margin-bottom: 20px; }
        .logout { float: right; font-size: 14px; color: #007BFF; text-decoration: none; }
        .logout:hover { text-decoration: underline; }
        .logout i { margin-right: 5px; }
        .students table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .students th, .students td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .students th { background-color: #007BFF; color: #fff; }
        .students tr:hover { background-color: #f1f1f1; }
        .view-button { padding: 8px 12px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px; font-size: 14px; }
        .view-button:hover { background-color: #218838; }
        .delete-button { padding: 8px 12px; background-color: #dc3545; color: #fff; text-decoration: none; border-radius: 5px; font-size: 14px; }
        .delete-button:hover { background-color: #c82333; }
        .student-details { margin-top: 30px; padding: 20px; background-color: #f9f9f9; border-radius: 8px; display: none; }
        .student-details h3 { font-size: 20px; margin-bottom: 20px; }
        .student-details table { width: 100%; border-collapse: collapse; }
        .student-details th, .student-details td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .student-details th { background-color: #007BFF; color: white; }
        .year-filter button { padding: 10px; margin: 5px; border-radius: 5px; border: none; background-color: #007BFF; color: white; font-size: 14px; cursor: pointer; }
        .year-filter button:hover { background-color: #0056b3; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function viewStudentDetails(studentId) {
            $.ajax({
                url: 'teacher.php',
                type: 'POST',
                data: { action: 'view_student_grades', student_id: studentId },
                dataType: 'json',
                success: function (grades) {
                    const studentDetailsSection = document.getElementById('student-details');
                    const gradesBody = document.getElementById('student-grades-body');

                    gradesBody.innerHTML = ''; // Clear previous content

                    if (grades.length > 0) {
                        grades.forEach((grade) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${grade.subject_name}</td>
                                <td>${grade.grade}</td>
                                <td>${grade.status}</td>
                                <td>
                                    <button onclick="updateGradeStatus(${grade.grade_id}, 'accept')" style="background-color: #28a745; color: #fff;">Accept</button>
                                    <button onclick="updateGradeStatus(${grade.grade_id}, 'reject')" style="background-color: #dc3545; color: #fff;">Reject</button>
                                </td>
                            `;
                            gradesBody.appendChild(row);
                        });
                    } else {
                        gradesBody.innerHTML = '<tr><td colspan="4">No grades available for this student.</td></tr>';
                    }

                    studentDetailsSection.style.display = 'block'; // Show the section
                    $('#student-details').data('student-id', studentId); // Store student ID
                },
                error: function () {
                    alert('Failed to fetch student details. Please try again.');
                }
            });
        }

        function updateGradeStatus(gradeId, action) {
            $.ajax({
                url: 'teacher.php',
                type: 'POST',
                data: { grade_id: gradeId, grade_action: action },
                success: function () {
                    alert(`Grade ${action === 'accept' ? 'approved' : 'rejected'} successfully!`);
                    const studentId = $('#student-details').data('student-id');
                    if (studentId) {
                        viewStudentDetails(studentId); // Refresh grades
                    }
                },
                error: function () {
                    alert('Failed to update grade status. Please try again.');
                }
            });
        }

        function filterByYear(year) {
            window.location.href = `teacher.php?year=${year}`;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>

        <!-- Year Filter Buttons -->
        <div class="year-filter">
            <button onclick="filterByYear(1)">1st Year</button>
            <button onclick="filterByYear(2)">2nd Year</button>
            <button onclick="filterByYear(3)">3rd Year</button>
            <button onclick="filterByYear(4)">4th Year</button>
        </div>

        <div class="students">
            <h2>Students</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Year Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Filter students by year if selected, default is 1st year
                $selected_year = isset($_GET['year']) ? intval($_GET['year']) : 1; 
                $query = "SELECT s.id AS student_id, s.name AS student_name, s.year_level
                          FROM students s
                          WHERE s.year_level = '$selected_year'";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['student_name']) . "</td>
                                <td>" . htmlspecialchars($row['year_level']) . "</td>
                                <td><button class='view-button' onclick='viewStudentDetails(" . $row['student_id'] . ")'>View Grades</button> 
                                    <a href='teacher.php?delete_student=" . $row['student_id'] . "' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No students found for the selected year.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Student Details Section -->
        <div id="student-details" class="student-details">
            <h3>Grades for Student: <span id="student-name"></span></h3>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="student-grades-body">
                    <!-- Dynamic grades content will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
