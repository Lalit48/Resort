<?php
header('Content-Type: application/json');
require 'db_config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $roomId = intval($_POST['id']); // Sanitize input

    // Database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    // Fetch room details and latest confirmed booking dates
    $stmt = $conn->prepare("
        SELECT r.id, r.title, r.description, r.price, r.image_url, 
               b.check_in_date AS check_in, b.check_out_date AS check_out
        FROM rooms r
        LEFT JOIN booking b ON r.id = b.room_id AND b.status = 'confirmed'
        WHERE r.id = ?
        ORDER BY b.created_at DESC LIMIT 1
    ");
    
    $stmt->bind_param('i', $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $roomDetails = $result->fetch_assoc();
        
        // Check if check_in and check_out are null and format if needed
        if (!$roomDetails['check_in']) {
            $roomDetails['check_in'] = 'N/A';
        } else {
            $roomDetails['check_in'] = date('Y-m-d', strtotime($roomDetails['check_in']));
        }

        if (!$roomDetails['check_out']) {
            $roomDetails['check_out'] = 'N/A';
        } else {
            $roomDetails['check_out'] = date('Y-m-d', strtotime($roomDetails['check_out']));
        }

        echo json_encode(['success' => true, 'roomDetails' => $roomDetails]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Room not found or no confirmed bookings']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
