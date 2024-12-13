<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Get the student ID from the URL
if (!isset($_GET['student_id'])) {
    echo "Student ID not provided!";
    exit;
}

$student_id = intval($_GET['student_id']);

// Handle grade update (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new grade and subject
    $grade = $_POST['grade'];
    $subject_id = intval($_POST['subject_id']);
    
    // Update grade in the database
    $update_query = "UPDATE grades SET grade = ? WHERE student_id = ? AND subject_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sii", $grade, $student_id, $subject_id);
    
    if ($stmt->execute()) {
        echo "<div class='alert success'>Grade updated successfully!</div>";
    } else {
        echo "<div class='alert error'>Error updating grade: " . $conn->error . "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grades</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            background-image: url('jaah.jpg');
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .actions form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .actions input[type="text"] {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .actions button {
            padding: 8px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .actions button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #28a745;
            color: white;
        }

        .error {
            background-color: #dc3545;
            color: white;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
            text-align: center;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Grades for Student ID: <?php echo htmlspecialchars($student_id); ?></h1>

        <?php
        // Fetch grades for the specific student
        $query = "SELECT g.subject_id, sub.subject_name, g.grade 
                  FROM grades g
                  JOIN subjects sub ON g.subject_id = sub.id
                  WHERE g.student_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Subject</th><th>Grade</th><th>Actions</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['subject_name']) . "</td>
                        <td>" . htmlspecialchars($row['grade']) . "</td>
                        <td class='actions'>
                            <form method='POST'>
                                <input type='hidden' name='subject_id' value='" . htmlspecialchars($row['subject_id']) . "'>
                                <input type='text' name='grade' value='" . htmlspecialchars($row['grade']) . "' required>
                                <button type='submit'>
                                    <i class='fas fa-edit'></i> Update Grade
                                </button>
                            </form>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No grades found for this student.</p>";
        }

        $stmt->close();
        ?>

        <a href="admin.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>
    </div>

</body>
</html>
