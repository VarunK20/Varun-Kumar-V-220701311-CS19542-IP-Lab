<?php
    define("host","localhost:3307");
    define("user","root");
    define("password","");
    define("db","empdetails");
    $db = mysqli_connect(host, user, password, db);
    if(!$db) {
        die("Connection failed: " . mysqli_connect_error());  // Displays the error
    } else {
        echo "Connection Successful";  // Optional message for debugging
    }
?>