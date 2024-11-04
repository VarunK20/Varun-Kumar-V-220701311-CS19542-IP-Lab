<?php
    include "db.php";
    $ano = "";
    if(isset($_GET["ano"]))
        $ano = $db->real_escape_string($_GET["ano"]);
    elseif(isset($_POST["ano"]))
        $ano = $db->real_escape_string($_POST["ano"]);

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["transfer"])) {
            $ttype = $db->real_escape_string($_POST["ttype"]);
            $amount = floatval($_POST["amount"]);

            if($amount <= 0) {
                echo "Please enter a valid amount greater than 0<br>";
            } else {
                $db->begin_transaction();

                try {
                    $sql = "SELECT * FROM account WHERE ano = ? FOR UPDATE";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("s", $ano);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    if(!$row) {
                        throw new Exception("Account not found");
                    }

                    $balance = floatval($row["balance"]);
                    $newBalance = $balance + ($ttype == "D" ? $amount : -$amount);

                    if($ttype == "W" && $balance < $amount) {
                        throw new Exception("Insufficient Balance");
                    }

                    $sql = "UPDATE account SET balance = ? WHERE ano = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("ds", $newBalance, $ano);
                    if(!$stmt->execute()) {
                        throw new Exception("Error updating balance: " . $db->error);
                    }

                    $sql = "INSERT INTO transaction (ano, ttype, tamount) VALUES (?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("ssd", $ano, $ttype, $amount);
                    if(!$stmt->execute()) {
                        throw new Exception("Error recording transaction: " . $db->error);
                    }

                    $db->commit();
                    echo "Transaction successful!<br>";

                } catch (Exception $e) {

                    $db->rollback();
                    echo "Error: " . $e->getMessage() . "<br>";
                }
            }
        }
    }
?>

<html>
<head>
    <title>Transaction</title>
    <style>
        .balance {
            margin: 20px 0;
            padding: 10px;
            background-color: #f0f0f0;
        }
        .transaction-form {
            margin: 20px 0;
        }
        .form-group {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="balance">
        <?php
            $sql = "SELECT * FROM account WHERE ano = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("s", $ano);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if($row) {
                echo "Account No: " . htmlspecialchars($row['ano']) . 
                     " | Account Type: " . htmlspecialchars($row['atype']) . 
                     " | Balance: $" . htmlspecialchars(number_format($row['balance'], 2));
            } else {
                echo "Account not found";
            }
        ?>
    </div>

    <div class="transaction-form">
        <form action="transaction.php" method="post">
            <input type="hidden" name="ano" value="<?php echo htmlspecialchars($ano); ?>">
            <div class="form-group">
                <label for="ttype">Transaction Type:</label>
                <select name="ttype" id="ttype">
                    <option value="D">Deposit</option>
                    <option value="W">Withdraw</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" step="0.01" min="0" name="amount" id="amount" required>
            </div>
            <div class="form-group">
                <input type="submit" name="transfer" value="Process Transaction">
            </div>
        </form>
    </div>

    <?php
        $sql = "SELECT * FROM transaction WHERE ano = ? ORDER BY tdate DESC LIMIT 5";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $ano);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            echo "<h3>Recent Transactions</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Date</th><th>Type</th><th>Amount</th></tr>";
            while($trow = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($trow['tdate']) . "</td>";
                echo "<td>" . ($trow['ttype'] == 'D' ? 'Deposit' : 'Withdrawal') . "</td>";
                echo "<td>$" . htmlspecialchars(number_format($trow['tamount'], 2)) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    ?>
</body>
</html>