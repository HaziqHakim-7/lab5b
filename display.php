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

// Fetch data from the users table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            transition: all 0.3s ease;
            display: inline-block;
            text-align: center;
        }

        .action-buttons a.update {
            background-color: #28a745;
            color: white;
        }

        .action-buttons a.delete {
            background-color: #dc3545;
            color: white;
        }

        .action-buttons a:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }

        .no-users {
            text-align: center;
            color: #6c757d;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 15px;
            }

            table {
                font-size: 0.9em;
            }

            th, td {
                padding: 8px 10px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Management System</h1>
        <table>
            <thead>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["matric"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["password"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
                        echo "<td class='action-buttons'>";
                        echo "<a href='update.php?matric=" . urlencode($row["matric"]) . "' class='update'>Update</a>";
                        echo "<a href='delete.php?matric=" . urlencode($row["matric"]) . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='no-users'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>