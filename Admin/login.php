<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "";     // Replace with your DB password
$dbname = "resort"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$password_hash = $_POST['password'];

// Query to validate user credentials
$sql = "SELECT * FROM adminlogin WHERE username = ? AND password_hash = ?";
$stmt = $conn->prepare($sql);

// Check if the prepare statement was successful
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("ss", $username, $password_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Successful login
    $_SESSION['authenticated'] = true;
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit();
} else {
    // Invalid credentials
    echo "<h1>Invalid username or password. Please try again.</h1>";
}

// Close connection
$stmt->close();
$conn->close();
?>
