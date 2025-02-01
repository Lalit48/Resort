<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'resort');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch room data based on date
if (isset($_GET['action']) && $_GET['action'] == 'getStatuses' && isset($_GET['date'])) {
    $selectedDate = $_GET['date'];

    $sql = "SELECT id, status FROM rooms WHERE status_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }

    echo json_encode($rooms);
    exit;
}

// Fetch room details
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    $sql = "SELECT title, description, price, image_url FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $roomDetails = $stmt->get_result()->fetch_assoc();

    echo json_encode($roomDetails);
    exit;
}

// Fetch room availability for a range of dates
if (isset($_GET['action']) && $_GET['action'] == 'getAllDatesStatuses') {
    $sql = "SELECT status_date, status FROM rooms";
    $result = $conn->query($sql);

    $dateStatuses = [];
    while ($row = $result->fetch_assoc()) {
        $dateStatuses[$row['status_date']] = $row['status'];
    }

    echo json_encode($dateStatuses);
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Status Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-free {
            background-color: #d4edda;
            color: green;
            font-weight: bold;
        }

        .status-engaged {
            background-color: #f8d7da;
            color: red;
            font-weight: bold;
        }

        .bg-light {
            background-color: #f1f1f1;
        }

        .date-cell {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Room Status Overview</h2>
        <div class="mb-4 text-center">
            <label for="datePicker" class="form-label">Select Date:</label>
            <input type="date" id="datePicker" class="form-control w-25 d-inline" onchange="updateRoomStatuses()">
        </div>

        <!-- Date Status Table -->
        <h3 class="text-center">Room Availability by Date</h3>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="dateStatusTable">
                    <!-- Date statuses dynamically populated -->
                </tbody>
            </table>
        </div>

        <!-- Room Status Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tbody id="roomTable">
                    <!-- Room cells dynamically populated -->
                </tbody>
            </table>
        </div>

        <!-- Room Details Section -->
        <div id="roomDetails" class="d-none">
            <h3>Room Details</h3>
            <p><strong>Title:</strong> <span id="roomTitle"></span></p>
            <p><strong>Description:</strong> <span id="roomDescription"></span></p>
            <p><strong>Price:</strong> $<span id="roomPrice"></span></p>
            <img id="roomImage" src="" alt="Room Image" style="width: 300px;">
        </div>
    </div>

    <script>
        // Function to update room status for the selected date
        function updateRoomStatuses() {
            const date = document.getElementById('datePicker').value;
            if (!date) return;

            fetch(`?action=getStatuses&date=${date}`)
                .then(response => response.json())
                .then(rooms => {
                    const roomTable = document.getElementById('roomTable');
                    roomTable.innerHTML = '';

                    let index = 0;
                    for (let i = 0; i < 5; i++) {
                        const row = document.createElement('tr');
                        for (let j = 0; j < 10; j++) {
                            const cell = document.createElement('td');
                            if (rooms[index]) {
                                const room = rooms[index];
                                cell.textContent = room.id;
                                cell.className = room.status === 'free' ? 'status-free' : 'status-engaged';
                                cell.setAttribute('data-id', room.id);
                                cell.onclick = () => fetchRoomDetails(room.id);
                                index++;
                            } else {
                                cell.className = 'bg-light';
                            }
                            row.appendChild(cell);
                        }
                        roomTable.appendChild(row);
                    }
                })
                .catch(error => console.error('Error fetching room statuses:', error));
        }

        // Function to fetch room details when a room is clicked
        function fetchRoomDetails(roomId) {
            document.getElementById('roomDetails').classList.remove('d-none');
            fetch(`?id=${roomId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('roomTitle').textContent = data.title;
                    document.getElementById('roomDescription').textContent = data.description;
                    document.getElementById('roomPrice').textContent = data.price;
                    document.getElementById('roomImage').src = data.image_url;
                })
                .catch(error => console.error('Error fetching room details:', error));
        }

        // Fetch all date statuses and display them
        function loadDateStatuses() {
            fetch('?action=getAllDatesStatuses')
                .then(response => response.json())
                .then(dateStatuses => {
                    const dateStatusTable = document.getElementById('dateStatusTable');
                    dateStatusTable.innerHTML = '';

                    for (const date in dateStatuses) {
                        const row = document.createElement('tr');
                        const dateCell = document.createElement('td');
                        const statusCell = document.createElement('td');

                        dateCell.textContent = date;
                        const statusClass = dateStatuses[date] === 'free' ? 'status-free' : 'status-engaged';
                        statusCell.textContent = dateStatuses[date];
                        statusCell.className = statusClass;

                        row.appendChild(dateCell);
                        row.appendChild(statusCell);
                        dateStatusTable.appendChild(row);
                    }
                })
                .catch(error => console.error('Error fetching date statuses:', error));
        }

        // Call to load date statuses when the page is loaded
        loadDateStatuses();
    </script>
</body>
</html>

