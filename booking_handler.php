<?php
require_once 'db_config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $country = $_POST['country'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $paperless_confirmation = isset($_POST['paperless_confirmation']) ? 1 : 0;
    $booking_for = $_POST['booking_for'] ?? null;
    $work_travel = ($_POST['work_travel'] ?? 'no') === 'yes' ? 1 : 0;

    // Validate required fields
    if (!$first_name || !$last_name || !$email || !$phone_number || !$booking_for) {
        die("Error: All required fields must be filled out.");
    }

    // Optional: Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format.");
    }

    // Insert the form data into the database
    $sql = "INSERT INTO booking (first_name, last_name, email, country, phone_number, paperless_confirmation, booking_for, work_travel)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the statement
        $stmt->bind_param("ssssssii", $first_name, $last_name, $email, $country, $phone_number, $paperless_confirmation, $booking_for, $work_travel);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Booking successfully submitted!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
