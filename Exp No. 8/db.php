<?php
define("host", "localhost:3307");
define("user", "root");
define("password", "");
define("db", "bank");

$db = mysqli_connect(host, user, password, db);
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
