<?php
// Database connection settings
$servername = "localhost";
$username = "vgangavaram1";
$password = "vgangavaram1";
$dbname = "vgangavaram1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
