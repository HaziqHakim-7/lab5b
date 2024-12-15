<?php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_5b";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the matric from the URL parameter
$matric = $_GET['matric'];

// Fetch user details before deletion
$stmt = $conn->prepare("SELECT name, role FROM users WHERE matric = ?");
$stmt->bind_param("s", $matric);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
$stmt->bind_param("s", $matric);

$deletion_successful = false;
$error_message = "";

if ($stmt->execute()) {
    $deletion_successful = true;
} else {
    $error_message = "Error deleting user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Deletion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 30px;
            text-align: center;
        }

        .success-icon, .error-icon {
            font-size: 72px;
            margin-bottom: 20px;
        }

        .success-icon {
            color: #28a745;
        }

        .error-icon {
            color: #dc3545;
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .user-details {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }

        .user-details p {
            margin: 5px 0;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        @media screen and (max-width: 480px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($deletion_successful): ?>
            <div class="success-icon">✓</div>
            <h2>User Deleted Successfully</h2>
            <div class="user-details">
                <p><strong>Matric:</strong> <?php echo htmlspecialchars($matric); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
            </div>
            <div class="actions">
                <a href="display.php" class="btn btn-primary">View User List</a>
            </div>
        <?php else: ?>
            <div class="error-icon">✗</div>
            <h2>Deletion Failed</h2>
            <p><?php echo htmlspecialchars($error_message); ?></p>
            <div class="actions">
                <a href="display.php" class="btn btn-secondary">Back to User List</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>