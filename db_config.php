<?php
// Database connection configuration
$servername = "localhost"; // Change this if your DB server is different
$username = "root"; // Change this with your database username
$password = ""; // Change this with your database password
$dbname = "resort"; // The name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
