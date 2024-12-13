<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in as a student
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php"); // Redirect to landing page if not logged in
    exit;
}

$user = $_SESSION['user']; // Get student data from session

// Get the student's year level and semester
$year_level = $user['year_level'];
$semester = $user['semester'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            background-image: url('jaah.jpg');

        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: ;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(30px);
            
        }
        h1 {
            text-align: center;
            color: white;
            
        }
        .logout {
            float: right;
            margin-top: -10px;
            text-decoration: none;
            color: #ff4d4d;
            font-size: 14px;
            font-weight: bold;
        }
        .logout:hover {
            text-decoration: underline;
        }
        .grades-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            background-color: whitesmoke;
            
        }
        .grades-table th, .grades-table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
            
        }
        .grades-table th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            
        }
        .grades-table td {
            font-size: 14px;
            color: #555;
            
        }
        .grades-table tr:hover {
            background-color: #f1f1f1;
            
            
        }
        .enter-grade-form {
            display: flex;
            align-items: center;
            gap: 10px;
            
            
        }
        .enter-grade-form input {
            padding: 5px;
            width: 80px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            
        }
        .enter-grade-form button {
            padding: 6px 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        .enter-grade-form button:hover {
            background-color: #45a049;
        }
        .success-message {
            text-align: center;
            color: #28a745;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
    <script>
        // Function to submit grade without page refresh
        function submitGrade(form, subjectId) {
            const gradeInput = form.querySelector('input[name="grade"]');
            const grade = gradeInput.value;

            if (!grade) {
                alert("Please enter a grade.");
                return false;
            }

            // AJAX Request
            fetch('enter_grade.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `subject_id=${subjectId}&grade=${grade}`
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    const gradeCell = form.closest('tr').querySelector('td:nth-child(3)');
                    gradeCell.textContent = grade;
                    form.remove();
                    alert('Grade entered successfully!');
                } else {
                    alert('Error entering grade.');
                }
            });

            return false;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $user['name']; ?>!</h1>
        <a href="logout.php" class="logout">Logout</a>

        <!-- Grades Table -->
        <div class="grades">
            <h2>Your Subjects</h2>
            <table class="grades-table">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch subjects for the student's year and semester
                    $query = "SELECT * FROM subjects WHERE year_level = '$year_level' AND semester = '$semester'";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($subject = $result->fetch_assoc()) {
                            $subject_id = $subject['id'];
                            $student_id = $user['id'];

                            // Fetch grade if already entered
                            $grade_query = "SELECT * FROM grades WHERE student_id = '$student_id' AND subject_id = '$subject_id'";
                            $grade_result = $conn->query($grade_query);
                            $grade = $grade_result->num_rows > 0 ? $grade_result->fetch_assoc()['grade'] : null;
                            
                            echo "<tr>
                                    <td>" . htmlspecialchars($subject['subject_code']) . "</td>
                                    <td>" . htmlspecialchars($subject['subject_name']) . "</td>
                                    <td>" . ($grade ? htmlspecialchars($grade) : 'Not yet entered') . "</td>
                                    <td>";
                            if (!$grade) {
                                // Show grade entry form if no grade is entered
                                echo "<form onsubmit='return submitGrade(this, $subject_id)' class='enter-grade-form'>
                                        <input type='number' name='grade' placeholder='Enter Grade' step='0.01' required>
                                        <button type='submit'>Submit</button>
                                      </form>";
                            }
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No subjects found for this year and semester.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
