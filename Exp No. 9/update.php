<?php
    include 'db.php';
    $eid = "";

    if (isset($_GET["eid"])) {
        $eid = $_GET["eid"];
    } elseif (isset($_POST["eid"])) {
        $eid = $_POST["eid"];
    }

    // Query from empdetail instead of employee
    $sql = "SELECT * FROM empdetail WHERE empid='$eid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Fetch employee details
    $name = $row["ename"];
    $desig = $row["desig"];
    $dept = $row["dept"];
    $salary = $row["salary"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["update"])) {
            $name = $_POST["name"];
            $designation = $_POST["designation"];
            $department = $_POST["department"];
            $salary = $_POST["salary"];

            // Update empdetail instead of employee
            $sql = "UPDATE empdetail SET ename='$name', desig='$designation', dept='$department', salary='$salary' WHERE empid='$eid'";
            
            if ($db->query($sql) === TRUE) {
                echo "Employee updated successfully<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }
    }
?>
<html>
<head>
    <title>Update</title>
</head>
<body>
    <form action="\update.php" method="POST">
        <input type="hidden" name="eid" value="<?php echo $eid ?>">
        Name: <input type="text" name="name" value="<?php echo $name ?>"><br>
        Designation: <input type="text" name="designation" value="<?php echo $desig ?>"><br>
        Department: <input type="text" name="department" value="<?php echo $dept ?>"><br>
        Salary: <input type="text" name="salary" value="<?php echo $salary ?>"><br>
        <input type="submit" name="update" value="Update"><br>
    </form>
    <a href="insert.php">Back</a>
</body>
</html>
