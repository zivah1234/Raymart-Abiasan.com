<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to landing page if not logged in
    exit;
}

// Initialize search term and results
$search_query = '';
$students = [];
$pending_teachers = [];

// Handle student search
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_students'])) {
    $search_query = $_POST['search_students'];
    $stmt = $conn->prepare("SELECT id, name FROM students WHERE LOWER(TRIM(name)) LIKE LOWER(?)");
    $search_term = '%' . $search_query . '%';
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $students = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

// Fetch teachers with 'pending' status
$query = "SELECT id, name, username FROM teachers WHERE status = 'pending'";
$stmt = $conn->prepare($query);
$stmt->execute();
$pending_result = $stmt->get_result();

if ($pending_result->num_rows > 0) {
    $pending_teachers = $pending_result->fetch_all(MYSQLI_ASSOC);
}
$stmt->close();

// Handle teacher approval/rejection
if (isset($_GET['action']) && isset($_GET['teacher_id'])) {
    $action = $_GET['action'];
    $teacher_id = $_GET['teacher_id'];

    if ($action === 'approve') {
        // Approve the teacher by updating the status
        $update_query = "UPDATE teachers SET status = 'approved' WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("i", $teacher_id);
        if ($stmt->execute()) {
            echo "Teacher has been approved.";
        } else {
            echo "Error updating teacher status: " . $conn->error;
        }
        $stmt->close();
    } elseif ($action === 'reject') {
        // Reject the teacher by deleting from the database
        $delete_query = "DELETE FROM teachers WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $teacher_id);
        if ($stmt->execute()) {
            echo "Teacher has been rejected and deleted.";
        } else {
            echo "Error deleting teacher: " . $conn->error;
        }
        $stmt->close();
    }

    // After approval or rejection, refresh the page to reflect changes
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            background-image: url('jaah.jpg');
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .logout {
            font-size: 14px;
            color: #007BFF;
            text-decoration: none;
            float: right;
            margin-top: -10px;
        }

        .logout:hover {
            text-decoration: underline;
        }

        h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 12px 18px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .search-container {
            margin-top: 20px;
        }

        .search-container form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            width: 70%;
            border: 1px solid #ddd;
            outline: none;
        }

        .search-container button {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 6px;
            background-color: #28a745;
            border: none;
            color: white;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #218838;
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
        }

        th {
            background-color: #007BFF;
            color: white;
            font-size: 16px;
        }

        td {
            font-size: 15px;
            color: #555;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions button {
            background-color: #17a2b8;
            padding: 6px 12px;
            color: white;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .actions button:hover {
            background-color: #138496;
        }

        .no-results {
            font-size: 16px;
            color: #888;
            margin-top: 20px;
            text-align: center;
        }

        .no-results i {
            color: #007BFF;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome, Admin!</h1>
        <a href="logout.php" class="logout">Logout</a>

        <div>
            <button onclick="window.location.href='view_teachers.php'">View Teachers</button>
            <button onclick="window.location.href='view_students.php'">View Students</button>
        </div>

        <!-- Search Students -->
        <div class="search-container">
            <h2>Search Students</h2>
            <form method="POST">
                <input type="text" name="search_students" placeholder="Enter student name" value="<?php echo htmlspecialchars($search_query); ?>" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <!-- Display Search Results for Students -->
        <?php if (!empty($students)): ?>
            <h2>Search Results</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['id']); ?></td>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td class="actions">
                                <form method="GET" action="view_grades.php" style="display:inline;">
                                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                    <button type="submit">View Grades</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($students)): ?>
            <p class="no-results">No students found matching "<?php echo htmlspecialchars($search_query); ?>" <i class="fas fa-sad-tear"></i></p>
        <?php endif; ?>

        <!-- Display Pending Teachers for Approval -->
        <h2>Pending Teacher Approvals</h2>
        <?php if (!empty($pending_teachers)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Teacher ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_teachers as $teacher): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($teacher['id']); ?></td>
                            <td><?php echo htmlspecialchars($teacher['name']); ?></td>
                            <td class="actions">
                                <a href="admin.php?action=approve&teacher_id=<?php echo $teacher['id']; ?>"><button>Approve</button></a>
                                <a href="admin.php?action=reject&teacher_id=<?php echo $teacher['id']; ?>"><button>Reject</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-results">No teachers are pending approval at the moment.</p>
        <?php endif; ?>
    </div>

</body>
</html>
