<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

include 'db.php';

// Fetch all teachers
$query = "SELECT * FROM teachers";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers List</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
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
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        .teacher-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .teacher-item:last-child {
            border-bottom: none;
        }

        .teacher-item .teacher-info {
            font-size: 16px;
            color: #555;
        }

        .teacher-item .teacher-info i {
            margin-right: 8px;
            color: #007BFF;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Teachers List</h1>

        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="teacher-item">
                <div class="teacher-info">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?>
                    <strong>- Name:</strong> <?php echo htmlspecialchars($row['name']); ?>
                </div>
            </div>
        <?php endwhile; ?>

        <a href="admin.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
        </a>
    </div>

</body>
</html>
