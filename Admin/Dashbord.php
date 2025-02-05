<?php
    // Handle AJAX request for room details
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $roomId = intval($_POST['id']);

        $conn = new mysqli('localhost', 'root', '', 'resort');
        if ($conn->connect_error) {
            die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
        }

        $stmt = $conn->prepare("SELECT id, title, description, price, image_url FROM rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $roomDetails = $result->fetch_assoc();
            echo json_encode(['success' => true, 'roomDetails' => $roomDetails]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Room not found.']);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        #sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            transition: transform 0.3s ease;
        }
        #sidebar.hidden {
            transform: translateX(-250px);
        }
        #sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        #sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            flex-grow: 1;
            overflow-y: auto;
        }
        .navbar {
            z-index: 1030;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <h4 class="text-center py-3">Dashboard</h4>
        <a href="Dashbord.php">Home</a>
        <a href="roomdashbord.php">Rooms</a>
        <a href="bookingsdashbord.php">Bookings</a>
        <a href="report.php">Reports</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="btn btn-outline-light me-2" id="toggleSidebar">☰</button>
                <a class="navbar-brand" href="#">Room Management</a>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container mt-4">
            <h2 class="text-center mb-4">Room Management System</h2>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th colspan="10">Room IDs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new mysqli('localhost', 'root', '', 'resort');
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $bookedRooms = [];
                        $bookingResult = $conn->query("SELECT room_id FROM booking");
                        while ($row = $bookingResult->fetch_assoc()) {
                            $bookedRooms[] = $row['room_id'];
                        }

                        $result = $conn->query("SELECT id FROM rooms");
                        $rooms = $result->fetch_all(MYSQLI_ASSOC);
                        $index = 0;
                        for ($i = 0; $i < 5; $i++) {
                            echo "<tr>";
                            for ($j = 0; $j < 10; $j++) {
                                if (isset($rooms[$index])) {
                                    $id = $rooms[$index]['id'];
                                    $class = in_array($id, $bookedRooms) ? 'bg-danger text-white' : 'bg-light';
                                    echo "<td data-id='$id' class='$class' onclick='fetchRoomDetails($id)'>$id</td>";
                                    $index++;
                                } else {
                                    echo "<td class='bg-light-gray'></td>";
                                }
                            }
                            echo "</tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Room Details Modal -->
            <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="roomDetailsLabel">Room Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="roomImage" src="" alt="Room Image">
                            <table class="table table-bordered">
                                <tbody id="roomDetailsBody"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarButton = document.getElementById('toggleSidebar');
        const checkInDate = roomDetails.check_in ? new Date(roomDetails.check_in).toLocaleDateString() : 'N/A';
        const checkOutDate = roomDetails.check_out ? new Date(roomDetails.check_out).toLocaleDateString() : 'N/A';
       


        toggleSidebarButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        function fetchRoomDetails(roomId) {
            // Fetch room details along with check-in and check-out dates using AJAX
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + roomId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const roomDetails = data.roomDetails;

                    // Update modal content
                    document.getElementById('roomImage').src = roomDetails.image_url;
                    const roomDetailsBody = document.getElementById('roomDetailsBody');
                    roomDetailsBody.innerHTML = `
                        <tr>
                            <th>Room ID</th>
                            <td>${roomDetails.id}</td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>${roomDetails.title}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>${roomDetails.description}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>$${roomDetails.price}</td>
                        </tr>
                       

                        
                    `;

                    // Show the modal
                    const roomDetailsModal = new bootstrap.Modal(document.getElementById('roomDetailsModal'));
                    roomDetailsModal.show();
                } else {
                    alert('Room details not found.');
                }
            })
            .catch(error => {
                console.error('Error fetching room details:', error);
                alert('An error occurred while fetching room details.');
            });
        }

    </script>


    <?php
    // Handle AJAX request for room details
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $roomId = intval($_POST['id']);

        $conn = new mysqli('localhost', 'root', '', 'resort');
        if ($conn->connect_error) {
            die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
        }

        $stmt = $conn->prepare("SELECT id, title, description, price, image_url FROM rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $roomDetails = $result->fetch_assoc();
            echo json_encode(['success' => true, 'roomDetails' => $roomDetails]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Room not found.']);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
    ?>
</body>
</html>
