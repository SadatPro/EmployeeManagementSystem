<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            font-size: 14px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .edit {
            background-color: #4CAF50;
        }
        .delete {
            background-color: #f44336;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>Employee Records</h1>

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

    // Query to get all records from employees table
    $sql = "SELECT * FROM employees";
    $result = $conn->query($sql);

    // Check if records exist
    if ($result->num_rows > 0) {
        // Display table
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Hire Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["first_name"] . "</td>
                    <td>" . $row["last_name"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["position"] . "</td>
                    <td>" . $row["salary"] . "</td>
                    <td>" . $row["hire_date"] . "</td>
                    <td>
                        <a href='edit.php?id=" . $row["id"] . "'><button class='edit'>Edit</button></a>
                        <a href='delete.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\"><button class='delete'>Delete</button></a>
                    </td>
                  </tr>";
        }
        echo "  </tbody>
              </table>";
    } else {
        echo "<p>No records found.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
