<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resort";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $id = $_POST['booking_id'];
    $status = $_POST['status'];
    $sql = "UPDATE booking SET status='$status' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Status updated successfully');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$sql = "SELECT * FROM booking";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

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
    
<body class="bg-light">
    <!-- Sidebar -->
    <div id="sidebar">
        <h4 class="text-center py-3">Dashboard</h4>
        <a href="#">Home</a>
        <a href="#">Rooms</a>
        <a href="#">Bookings</a>
        <a href="#">Reports</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="btn btn-outline-light me-2" id="toggleSidebar">☰</button>
                <a class="navbar-brand" href="#">Booking Management</a>
            </div>
        </nav>
        <div class="container mt-4">
            <h2 class="mb-4 text-center">Booking Management</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>special req</th>
                            <th>room no</th>
                            <th>check in</th>
                            <th>check out</th>
                            <th>create at</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo $row['last_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['phone_number']; ?></td>
                                <td><?php echo $row['special_requests']; ?></td>
                                <td><?php echo $row['room_id']; ?></td>
                                <td><?php echo $row['check_in_date']; ?></td>
                                <td><?php echo $row['check_out_date']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td>
                                    <form method="post" class="d-flex align-items-center">
                                        <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                        <select name="status" class="form-select me-2">
                                            <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                            <option value="confirmed" <?php if ($row['status'] == 'confirmed') echo 'selected'; ?>>Confirmed</option>
                                            <option value="canceled" <?php if ($row['status'] == 'canceled') echo 'selected'; ?>>Canceled</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarButton = document.getElementById('toggleSidebar');

        toggleSidebarButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        // Function to load booking data via AJAX
        function loadBookings() {
            fetch('fetch_bookings.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('bookingTable').innerHTML = data;
                })
                .catch(error => console.error('Error fetching booking data:', error));
        }

        // Load booking data initially and refresh every 2 seconds
        loadBookings();
        setInterval(loadBookings, 2000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>