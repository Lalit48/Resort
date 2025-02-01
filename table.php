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

$conn->close();
?>

<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'resort');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch room data
$sql = "SELECT id, status FROM rooms";
$result = $conn->query($sql);

// Fetch all rows
$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

// Check if a room ID is passed to fetch details
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    // Query to fetch room details
    $sql = "SELECT title, description, price, image_url FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $roomDetails = $stmt->get_result()->fetch_assoc();

    // Return room details as JSON response
    echo json_encode($roomDetails);
    exit;
}

// Return room statuses as JSON for periodic updates
if (isset($_GET['action']) && $_GET['action'] == 'getStatuses') {
    echo json_encode($rooms);
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            color: #fff;
            height: 100vh;
            position: fixed;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }

        .status-free {
            background-color: #d4edda !important;
            color: green !important;
            font-weight: bold;
        }

        .status-engaged {
            background-color: #f8d7da !important;
            color: red !important;
            font-weight: bold;
        }

        .room-details {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
        }

        .room-details img {
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <h5 class="text-center py-3 border-bottom">Menu</h5>
            <a href="#">Dashboard</a>
            <a href="#">Room Management</a>
            <a href="#">Customer Records</a>
            <a href="#">Reports</a>
            <a href="#">Settings</a>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Room Table Section -->
            <div class="container">
                <h2 class="text-center mb-4">Room Status Overview</h2>
                    <div class="mb-4 text-center">
                        <label for="datePicker" class="form-label">Select Date:</label>
                        <input type="date" id="datePicker" class="form-control w-25 d-inline" onchange="updateRoomStatuses()">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <tbody id="roomTable">
                                <?php
                                // Assuming $rooms is already fetched from the database in your PHP script
                                $index = 0;
                                for ($i = 0; $i < 5; $i++) {
                                    echo "<tr>";
                                    for ($j = 0; $j < 10; $j++) {
                                        if (isset($rooms[$index])) {
                                            $room = $rooms[$index];
                                            $id = $room['id'];
                                            $status = $room['status'];
                                            $statusClass = ($status === 'free') ? 'status-free' : 'status-engaged';
                                            echo "<td class='$statusClass' data-id='$id' onclick='fetchRoomDetails($id)'>$id</td>";
                                            $index++;
                                        } else {
                                            echo "<td class='bg-light'></td>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
            </div>

            <!-- Room Details Section -->
            <div id="roomDetails" class="room-details d-none container">
                <h3 class="text-center">Room Details</h3>
                <p><strong>Title:</strong> <span id="roomTitle"></span></p>
                <p><strong>Description:</strong> <span id="roomDescription"></span></p>
                <p><strong>Price:</strong> $<span id="roomPrice"></span></p>

                <img id="roomImage" src="" alt="Room Image">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to update the room statuses when the date is selected
    function updateRoomStatuses() {
        const date = document.getElementById('datePicker').value;
        if (!date) return;

        fetch(`?action=getStatuses&date=${date}`)
            .then(response => response.json())
            .then(rooms => {
                const roomTable = document.getElementById('roomTable');
                roomTable.innerHTML = '';  // Clear existing content

                let index = 0;
                for (let i = 0; i < 5; i++) {
                    const row = document.createElement('tr');
                    for (let j = 0; j < 10; j++) {
                        const cell = document.createElement('td');
                        if (rooms[index]) {
                            const room = rooms[index];
                            const statusClass = room.status === 'free' ? 'status-free' : 'status-engaged';
                            cell.textContent = room.id;
                            cell.className = statusClass;
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
        // Function to fetch and update room statuses
        function updateRoomStatuses() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?action=getStatuses', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var rooms = JSON.parse(xhr.responseText);
                    var index = 0;

                    // Loop through the rooms and update the table
                    for (var i = 0; i < 5; i++) {
                        for (var j = 0; j < 10; j++) {
                            if (rooms[index]) {
                                var room = rooms[index];
                                var id = room.id;
                                var status = room.status;
                                var statusClass = (status === 'free') ? 'status-free' : 'status-engaged';
                                
                                // Update the room status cell
                                var cell = document.querySelector('td[data-id="'+ id +'"]');
                                if (cell) {
                                    cell.className = statusClass;
                                }
                                index++;
                            }
                        }
                    }
                }
            };
            xhr.send();
        }

        // Call the update function every 3 seconds (3000ms)
        setInterval(updateRoomStatuses, 3000);

        // Function to fetch and display room details when clicked
        function fetchRoomDetails(roomId) {
            document.getElementById('roomDetails').classList.remove('d-none');

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?id=' + roomId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    if (data) {
                        document.getElementById('roomTitle').textContent = data.title;
                        document.getElementById('roomDescription').textContent = data.description;
                        document.getElementById('roomPrice').textContent = data.price;
                        document.getElementById('roomImage').src = data.image_url;
                        
                    } else {
                        alert("Room details not found");
                    }
                }
            };
            xhr.send();
        }
    </script>
</body>

</html>
