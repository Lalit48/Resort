<?php
// Database connection details
$host = 'localhost';
$dbname = 'resort';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $name = $_POST['Name'] ?? '';
        $email = $_POST['Email'] ?? '';
        $phone_number = $_POST['Phone_Number'] ?? '';
        $message = $_POST['Message'] ?? '';

        // Validate form data
        if (!empty($name) && !empty($email) && !empty($message)) {
            // Prepare the SQL query
            $stmt = $conn->prepare("INSERT INTO contact (name, email, phone_number, message) VALUES (:name, :email, :phone_number, :message)");

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':message', $message);

            // Execute the query
            $stmt->execute();

            // Success message
            echo "Your message has been submitted successfully! Redirecting to the homepage...";
            
            // Redirect to index.html after 2 seconds
            echo '<meta http-equiv="refresh" content="2;url=index.html">';
        } else {
            echo "Please fill in all required fields (Name, Email, and Message).";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
