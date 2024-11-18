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

// Fetch all employee records
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

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
                    <a href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No records found</td></tr>";
}

$conn->close();
?>
