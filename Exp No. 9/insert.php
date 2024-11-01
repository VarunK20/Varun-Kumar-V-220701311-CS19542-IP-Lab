<html>
<head>
    <title>Register</title>
</head>
<body>
    <form action="insert.php" method="POST">  <!-- Changed action to use forward slash -->
        Name: <input type="text" name="name" required><br>  <!-- Added required for input validation -->
        Designation: <input type="text" name="designation" required><br>
        Department: <input type="text" name="department" required><br>
        Salary: <input type="number" name="salary" required><br>  <!-- Changed type to number for salary -->
        <input type="submit" name="insert" value="Insert"><br>
        Employee Id: <input type="text" name="eid">
        <input type="submit" name="search" value="Search">
    </form>
</body>
</html>

<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the connection is established
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST["insert"])) {
        // Collect data from the form
        $name = $_POST["name"];
        $designation = $_POST["designation"];
        $department = $_POST["department"];
        $salary = $_POST["salary"];

        // Prepare and execute the insert statement
        $stmt = $db->prepare("INSERT INTO empdetail (ename, desig, dept, salary) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $name, $designation, $department, $salary); // Bind parameters

        if ($stmt->execute()) {
            echo "Employee inserted successfully<br>";
            $eid = $stmt->insert_id;  // Get the last inserted ID
            $stmt->close(); // Close the statement

            // Retrieve and display the inserted employee details
            $sql = "SELECT * FROM empdetail WHERE empid=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $eid);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "Employee Id: " . $row["empid"] . "<br>";
                echo "Employee Name: " . $row["ename"] . "<br>";
                echo "Employee Designation: " . $row["desig"] . "<br>";
                echo "Employee Department: " . $row["dept"] . "<br>";
                echo "Employee Date Of Joining: " . $row["doj"] . "<br>"; // Ensure doj exists
                echo "Employee Salary: " . $row["salary"] . "<br>";
            }
        } else {
            echo "Error: " . $stmt->error; // Show the error message from the prepared statement
        }
        $stmt->close(); // Close the statement
    } elseif (isset($_POST["search"])) {
        $eid = $_POST["eid"];
        // Prepare and execute the search statement
        $stmt = $db->prepare("SELECT * FROM empdetail WHERE empid=?");
        $stmt->bind_param("i", $eid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            header("location:update.php?eid=" . $eid); // Redirect to update.php with the employee ID
            exit; // Exit to ensure no further code is executed
        } else {
            echo "User not found";
        }
        $stmt->close(); // Close the statement
    }
}

// Close the database connection
$db->close();
?>
