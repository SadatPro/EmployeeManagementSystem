<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EmployeeManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the record
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "No record found.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}

// Handle form submission for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    $update_sql = "UPDATE employees SET first_name = ?, last_name = ?, email = ?, position = ?, salary = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssdi", $first_name, $last_name, $email, $position, $salary, $id);

    if ($update_stmt->execute()) {
        echo "Record updated successfully. <a href='index.php'>Go back</a>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .container h1 {
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="number"], button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        Edit Employee
    </header>
    
    <div class="container">
        <h1>Edit Employee</h1>
        
        <form method="POST">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($employee['first_name']); ?>" required>
            
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($employee['last_name']); ?>" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
            
            <label for="position">Position</label>
            <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>">
            
            <label for="salary">Salary</label>
            <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($employee['salary']); ?>">
            
            <button type="submit">Update Employee</button>
        </form>
        
        <div class="back-link">
            <a href="index.php">Back to Employee List</a>
        </div>
    </div>
</body>
</html>
