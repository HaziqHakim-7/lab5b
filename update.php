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

// Fetch the user details
$stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
$stmt->bind_param("s", $matric);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Update the user details
    $stmt = $conn->prepare("UPDATE users SET name = ?, role = ? WHERE matric = ?");
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        // Redirect to the display.php page
        header("Location: display.php");
        exit;
    } else {
        $error = "Error updating user: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"], 
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="text"][readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
        input[type="submit"], 
        button {
            width: 48%;
            padding: 10px;
            margin: 10px 1%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        button {
            background-color: #dc3545;
            color: white;
        }
        button:hover {
            background-color: #c82333;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Update User</h1>
    <?php if (isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?matric=" . $matric; ?>">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo $user['matric']; ?>" readonly><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="student" <?php echo ($user['role'] == 'student') ? 'selected' : ''; ?>>Student</option>
            <option value="lecturer" <?php echo ($user['role'] == 'lecturer') ? 'selected' : ''; ?>>Lecturer</option>
        </select><br>

        <input type="submit" value="Update">
        <button type="button" onclick="window.location.href='display.php'">Cancel</button>
    </form>
</body>
</html>