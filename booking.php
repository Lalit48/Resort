<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "resort");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if room_id is set in POST or SESSION
if (isset($_POST['room_id'])) {
    $_SESSION['selected_room_id'] = $_POST['room_id'];
} elseif (!isset($_SESSION['selected_room_id'])) {
    echo "No room selected. Please go back and choose a room.";
    exit;
}

$selectedRoomId = $_SESSION['selected_room_id'];

// Fetch all rooms from the database
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
$rooms = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

// Get selected room details
$selectedRoom = null;
foreach ($rooms as $room) {
    if ($room['id'] == $selectedRoomId) {
        $selectedRoom = $room;
        break;
    }
}

if (!$selectedRoom) {
    echo "No room found with the selected ID.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_now'])) {
    if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) &&
        !empty($_POST['phone_number']) && !empty($_POST['check_in_date']) && !empty($_POST['check_out_date'])) {

        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']);
        $special_requests = !empty($_POST['special_requests']) ? $conn->real_escape_string($_POST['special_requests']) : NULL;
        $check_in_date = $conn->real_escape_string($_POST['check_in_date']);
        $check_out_date = $conn->real_escape_string($_POST['check_out_date']);

        // Insert data into the booking table
        $sql = "INSERT INTO booking (first_name, last_name, email, phone_number, special_requests, room_id, check_in_date, check_out_date, status) 
                VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$special_requests', '$selectedRoomId', '$check_in_date', '$check_out_date', 'pending')";

        if ($conn->query($sql) === TRUE) {
            echo "Booking successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: All required fields must be filled out.";
    }
}

$conn->close();
?>


<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "resort");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch rooms from the database
$sql = "SELECT title, id FROM rooms";
$result = $conn->query($sql);
?>

<!-- Continue with displaying booking details... -->




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Page</title>
  <style>
    /* General Styles */
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #eef2f3, #8e9eab);
      color: #333;
    }

    header {
      background: linear-gradient(to right, #0073e6, #005bb5);
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    header .logo {
      font-size: 1.8rem;
      font-weight: bold;
      color: white;
    }

    header .top-right button {
      background-color: white;
      color: #0073e6;
      border: none;
      padding: 8px 15px;
      margin-left: 10px;
      border-radius: 20px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s, color 0.3s;
    }

    header .top-right button:hover {
      background-color: #005bb5;
      color: white;
    }

    main {
      display: flex;
      flex-wrap: wrap;
      padding: 20px;
      gap: 20px;
    }

    .left-panel,
    .right-panel {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 20px;
      margin: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .left-panel {
      flex: 2;
    }

    .right-panel {
      flex: 3;
    }

    h2 {
      color: #005bb5;
      font-size: 1.8rem;
      border-bottom: 2px solid #eef2f3;
      padding-bottom: 8px;
      margin-bottom: 20px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    ul li {
      margin: 8px 0;
      font-size: 1rem;
      color: #555;
    }

    .form-section label {
      margin-top: 10px;
      color: #333;
      font-weight: bold;
      display: block;
      font-size: 0.95rem;
    }

    .form-section input[type="text"],
    .form-section input[type="date"],
    .form-section input[type="number"],
    .form-section input[type="email"],
    .form-section input[type="tel"],
    .form-section select,
    .form-section textarea {
      padding: 12px;
      margin-top: 8px;
      border: 1px solid #ddd;
      border-radius: 8px;
      width: 95%;
      font-size: 1rem;
      box-shadow: inset 0px 2px 5px rgba(0, 0, 0, 0.1);
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-section input:focus,
    .form-section select:focus,
    .form-section textarea:focus {
      border-color: #0073e6;
      box-shadow: 0px 0px 8px rgba(0, 115, 230, 0.4);
      outline: none;
    }

    .form-section button {
      background-color: #0073e6;
      color: white;
      font-weight: bold;
      padding: 10px 20px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 20px;
      transition: background 0.3s;
    }

    .form-section button:hover {
      background-color: #005bb5;
    }

    .info-box,
    .price-info,
    .cancel-info {
      margin-top: 20px;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .info-box {
      background-color: #f9f9f9;
    }

    .price-info {
      background-color: #f1faff;
      border: 2px dashed #0073e6;
    }

    .cancel-info {
      background-color: #ffe9e9;
      color: #d9534f;
      font-weight: bold;
    }

    .final-details-button button {
      display: block;
      width: 100%;
      margin-top: 20px;
      background: linear-gradient(to right, #0073e6, #005bb5);
      border: none;
      color: white;
      padding: 15px;
      border-radius: 50px;
      font-size: 1.2rem;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .final-details-button button:hover {
      transform: scale(1.05);
    }

    
  </style>
</head>
<body>
  <header>
    <div class="logo"> <img src="images/logo.png"  style="width:100px;"> </div>
  </header>

  <main>
    <div class="left-panel">
        <h2>Your Selection</h2>
        <div id="your-selection">
            <h3><?= htmlspecialchars($selectedRoom['title']); ?></h3>
            <div class="selection-container">
                <img src="<?= htmlspecialchars($selectedRoom['image_url']); ?>" alt="<?= htmlspecialchars($selectedRoom['title']); ?>">
            </div>
        </div>

        <section class="house-rules-section">
            <h2>Conditions/Rules</h2>
            <ul>
                <?php
                $conditions = explode(',', $selectedRoom['conditions']);
                foreach ($conditions as $condition) {
                    echo '<li>' . htmlspecialchars(trim($condition)) . '</li>';
                }
                ?>
            </ul>
            <p>By continuing to the next step, you are agreeing to these house rules.</p>
        </section>

        <div class="price-info">
            <h2>Total</h2>
            <p><strong>Price:</strong> ₹<?= htmlspecialchars($selectedRoom['price']); ?></p>
            <p>Includes all taxes and charges.</p>
        </div>

        <div class="cancel-info">
            <p>How much will it cost to cancel?</p>
            <p>If you cancel, you'll pay ₹<?= htmlspecialchars($selectedRoom['price']); ?>.</p>
        </div>
    </div>


    <div class="right-panel">
      <!-- Booking Form -->
        <form method="POST" action="booking.php">
        <section class="form-section">
          <h2>Enter Your Details</h2>
            <label>First Name:</label>
            <input type="text" name="first_name" placeholder="First Name" required><br>

            <label>Last Name:</label>
            <input type="text" name="last_name" placeholder="Last Name" required><br>

            <label>Email Address:</label>
            <input type="email" name="email" placeholder="Email Address" required><br>

            <label>Phone Number:</label>
            <input type="tel" name="phone_number" placeholder="+91" required><br>

            <label>Check-in Date:</label>
            <input type="date" name="check_in_date" required><br>

            <label>Check-out Date:</label>
            <input type="date" name="check_out_date" required><br>

            <label>Room Number:</label>
            <select name="room_id" required>
                <option value="">Select a room</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['title'] == $selectedRoom['title']) {
                            echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                        }
                    }
                }
                ?>
            </select><br>

            <label>Special Requests (Optional):</label>
            <textarea name="special_requests" placeholder="Please write your requests in English."></textarea><br>

            <button type="submit" name="book_now">Book Now</button>
            </section>

        </form>
    </div>

  </main>

</body>
</html>
<?php $conn->close(); ?>