<?php
    include "db.php";
    $cid = "";
    if(isset($_GET["cid"]))
        $cid = $db->real_escape_string($_GET["cid"]);
    elseif(isset($_POST["cid"]))
        $cid = $db->real_escape_string($_POST["cid"]);

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $cid = $db->real_escape_string($_POST["cid"]);
        if(isset($_POST["createaccount"])) {
            $checkCustomer = "SELECT cid FROM customer WHERE cid = '$cid'";
            $customerResult = $db->query($checkCustomer);
            
            if($customerResult->num_rows > 0) {
                $atype = $db->real_escape_string($_POST["atype"]);
                $sql = "INSERT INTO account(cid, atype) VALUES('$cid', '$atype')";
                if($db->query($sql) === False) {
                    echo "Error creating account: " . $db->error;
                } else {
                    echo "Account created successfully!";
                }
            } else {
                echo "Error: Customer ID does not exist. Please create a customer first.";
            }
        }
    }
?>

<html>
<head>
    <title>Profile</title>
</head>
<body>
    <?php
        $sql = "SELECT * FROM account WHERE cid = '$cid'";
        $result = $db->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<a href='transaction.php?ano=" . htmlspecialchars($row['ano']) . 
                     "'>Account No:" . htmlspecialchars($row['ano']) . 
                     " Account Type:" . htmlspecialchars($row['atype']) . 
                     " Balance:" . htmlspecialchars($row['balance']) . "</a><br>";
            }
        } else {
            echo "No Account Found";
        }
    ?>
    <form action="home.php" method="post">
        <input type="hidden" name="cid" value="<?php echo htmlspecialchars($cid); ?>">
        Account Type: <select name="atype">
            <option value="S">Savings</option>
            <option value="C">Current</option>
        </select><br>
        <input type="submit" name="createaccount" value="Create Account"><br>
    </form>
</body>
</html>