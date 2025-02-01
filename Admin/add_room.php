<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resort";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $conditions = $_POST['conditions'];
    $price = $_POST['price'];
    
    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $image_url = $target_file;

    $sql = "INSERT INTO rooms (title, description, conditions, price, image_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $title, $description, $conditions, $price, $image_url);
    
    if ($stmt->execute()) {
        echo "<script>alert('Room added successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
