<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background-color: #f8f9fa;
        }
        #sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            transition: transform 0.3s ease;
            padding: 15px;
        }
        #sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            border-radius: 5px;
            transition: 0.3s;
        }
        #sidebar a:hover {
            background-color: #495057;
            transform: scale(1.05);
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            width: 150px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <h4 class="text-center py-3">Dashboard</h4>
        <a href="Dashbord.php">🏠 Home</a>
        <a href="roomdashbord.php">🛏️ Rooms</a>
        <a href="bookingsdashbord.php">📅 Bookings</a>
        <a href="report.php">📊 Reports</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <button class="btn btn-outline-light me-2" id="toggleSidebar">☰</button>
                <a class="navbar-brand" href="#">Booking Management</a>
            </div>
        </nav>

        <!-- Form Card -->
        <div class="container">
            <div class="card p-4">
                <h2 class="text-center mb-4">Manage Records</h2>
                <form id="dataForm">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="booking" name="data" value="booking">
                        <label class="form-check-label" for="booking">📅 Booking</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="contact" name="data" value="contact">
                        <label class="form-check-label" for="contact">📞 Contact</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rooms" name="data" value="rooms">
                        <label class="form-check-label" for="rooms">🛏️ Rooms</label>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="btn btn-primary btn-custom" onclick="generatePDF()">📄 Generate PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Functions -->
    <script>
        function generatePDF() {
            let selectedData = [];
            document.querySelectorAll('input[name="data"]:checked').forEach(checkbox => {
                selectedData.push(checkbox.value);
            });

            if (selectedData.length === 0) {
                alert("Please select at least one option.");
                return;
            }

            // Convert selected checkboxes to a query string
            let queryString = selectedData.map(value => `data[]=${value}`).join('&');

            // Redirect to generate_report.php with selected checkboxes as parameters
            window.open(`generate_report.php?${queryString}`, '_blank');
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
