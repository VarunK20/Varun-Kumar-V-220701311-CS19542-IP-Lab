<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);

    if (isset($_POST["createuser"])) {
        $stmt = $db->prepare("INSERT INTO customer (cname, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $pass);
        
        if ($stmt->execute()) {
            echo "<script>alert('User created successfully')</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "')</script>";
        }
        $stmt->close();
    } elseif (isset($_POST["login"])) {
        $stmt = $db->prepare("SELECT * FROM customer WHERE cname = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($_POST["pass"], $row['password'])) {
                header("Location: home.php?cid=" . $row['cid']);
                exit();
            } else {
                echo "<script>alert('Password mismatch')</script>";
            }
        } else {
            echo "<script>alert('User not found')</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Login System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            flex: 1;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="loginName">Username:</label>
                    <input type="text" id="loginName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="loginPass">Password:</label>
                    <input type="password" id="loginPass" name="pass" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" value="Login">
                </div>
            </form>
        </div>

        <div class="form-container">
            <h2>Register</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="regName">Username:</label>
                    <input type="text" id="regName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="regPass">Password:</label>
                    <input type="password" id="regPass" name="pass" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="createuser" value="Register">
                </div>
            </form>
        </div>
    </div>
</body>
</html>