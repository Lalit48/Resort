<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resort";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM booking";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['customer_name']}</td>
            <td>{$row['room_id']}</td>
            <td>{$row['check_in']}</td>
            <td>{$row['check_out']}</td>
            <td>{$row['status']}</td>
            <td><button class='btn btn-primary btn-sm'>View</button></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No bookings found</td></tr>";
}

$conn->close();
?>
