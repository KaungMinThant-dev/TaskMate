<?php
// test_db.php
include 'db_connect.php'; 

// Check if the connection variable is set
if ($conn) {
    echo "<h1>Database connection successful!</h1>";
} else {
    echo "<h1>Database connection failed.</h1>";
}
?>