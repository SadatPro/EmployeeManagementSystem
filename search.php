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

$search = $_GET['search'];

// Query to search records
$sql = "SELECT * FROM employees WHERE first_name LIKE ? OR last_name LIKE ? OR position LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Display search results in a table
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Search Results - Employee Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
        }
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        td a {
            text-decoration: none;
            color: #007bff;
        }
        td a:hover {
            text-decoration: underline;
        }
        td a.delete {
            color: #dc3545;
        }
        td a.delete:hover {
            color: #a71d2a;
        }
        .no-records {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        Employee Search Results
    </header>";

echo "<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['position'] . "</td>
                <td>" . $row['salary'] . "</td>
                <td>
                    <a href='edit.php?id=" . $row['id'] . "'>Edit</a> |
                    <a href='delete.php?id=" . $row['id'] . "' class='delete' onclick=\"return confirm('Are you sure?');\">Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='no-records'>No records found for your search.</td></tr>";
}

echo "</tbody></table>
</body>
</html>";

$conn->close();
?>
