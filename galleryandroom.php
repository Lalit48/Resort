<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "resort"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gallery-images'])) {
    $uploadsDir = 'uploads/';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    foreach ($_FILES['gallery-images']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['gallery-images']['name'][$key]);
        $targetFilePath = $uploadsDir . $fileName;

        if (move_uploaded_file($tmpName, $targetFilePath)) {
            // Insert image URL into database
            $stmt = $conn->prepare("INSERT INTO gallery (image_urls) VALUES (?)");
            $stmt->bind_param("s", $targetFilePath);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fetch images from the database
$sql = "SELECT * FROM gallery";
$result = $conn->query($sql);
?>
<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "resort"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_room') {
        $title = $_POST['room-title'];
        $description = $_POST['room-description'];
        $price = $_POST['room-price'];
        $conditions = $_POST['room-conditions'];
        
        // Handle image upload
        if (isset($_FILES['room-image']) && $_FILES['room-image']['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($_FILES['room-image']['name']);
            $targetDir = "uploads/";
            $targetFile = $targetDir . $imageName;

            if (move_uploaded_file($_FILES['room-image']['tmp_name'], $targetFile)) {
                $imageUrl = $targetFile;

                // Insert into database
                $stmt = $conn->prepare("INSERT INTO rooms (title, description, price, image_url) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssds", $title, $description, $price, $imageUrl);
                
                if ($stmt->execute()) {
                    echo "Room added successfully!";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Image is required.";
        }
    }
}

// Fetch room details
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$conn->close();
?>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "resort"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_room') {
    $title = $conn->real_escape_string($_POST['room-title']);
    $description = $conn->real_escape_string($_POST['room-description']);
    $price = $conn->real_escape_string($_POST['room-price']);
    $conditions = $conn->real_escape_string($_POST['room-conditions']);

    // Handle file upload
    if (isset($_FILES['room-image']) && $_FILES['room-image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['room-image']['tmp_name'];
        $image_name = basename($_FILES['room-image']['name']);
        $upload_dir = "uploads/"; // Ensure this directory exists and is writable
        $image_path = $upload_dir . uniqid() . "_" . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Insert into database
            $sql = "INSERT INTO rooms (title, description, price, image_url) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssds", $title, $description, $price, $image_path);

            if ($stmt->execute()) {
                echo "<p>Room added successfully!</p>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Failed to upload image.</p>";
        }
    } else {
        echo "<p>Image upload error: " . $_FILES['room-image']['error'] . "</p>";
    }
}

// Fetch rooms from database
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Gallery and Rooms</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 100%;
        }

        .left-panel {
            width: 40%;
            background-color: #f0f0f0;
            padding: 10px;
            overflow-y: auto;
            border-right: 2px solid #ccc;
        }

        .right-panel {
            width: 60%;
            background-color: #ffffff;
            padding: 20px;
            overflow-y: auto;
        }

        .gallery, .room {
            margin-bottom: 20px;
        }

        button {
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .room {
            margin-bottom: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .input-field {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        .image-preview {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .form-row .input-group {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .form-row .input-group label {
            margin-bottom: 5px;
        }

        .form-row .input-group input,
        .form-row .input-group textarea {
            width: 100%;
        }

        .gallery-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .gallery-images img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Panel -->
        <div class="left-panel">
            <h2>Resort Gallery</h2>
            <div class="gallery">
                <form id="gallery-form" method="POST" enctype="multipart/form-data">
                    <label for="gallery-images">Gallery Images:</label>
                    <input type="file" id="gallery-images" name="gallery-images[]" accept="image/*" multiple>
                    <button type="submit" id="upload-gallery">Upload</button>
                </form>
                <div class="gallery-images" id="gallery-display">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="image-container">';
                            echo '<img src="' . htmlspecialchars($row['image_urls']) . '" alt="Gallery Image" width="200">';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No images found.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <h2>Room Details</h2>
            <div class="room">
                <form id="room-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_room">
                    <div class="form-row">
                        <div class="input-group">
                            <label for="room-id">Room ID:</label>
                            <input type="text" id="room-id" name="room-id" class="input-field" readonly>
                        </div>
                        <div class="input-group">
                            <label for="room-image">Room Image:</label>
                            <input type="file" id="room-image" name="room-image" accept="image/*" class="input-field">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label for="room-title">Room Title:</label>
                            <input type="text" id="room-title" name="room-title" class="input-field">
                        </div>
                        <div class="input-group">
                            <label for="room-description">Room Description:</label>
                            <textarea id="room-description" name="room-description" class="input-field"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label for="room-price">Room Price:</label>
                            <input type="text" id="room-price" name="room-price" class="input-field">
                        </div>
                        <div class="input-group">
                            <label for="room-conditions">Room Conditions:</label>
                            <input type="text" id="room-conditions" name="room-conditions" class="input-field">
                        </div>
                    </div>

                    <button type="submit">Add Room</button>
                </form>

                <!-- Room Details Table -->
                <table id="room-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Conditions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Room Image" width="100"></td>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                                    <td><?php echo htmlspecialchars($row['conditions']); ?></td>
                                    <td><button>Delete</button></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No rooms found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const galleryDisplay = document.getElementById('gallery-display');
        document.getElementById('upload-gallery').addEventListener('click', function() {
            const files = document.getElementById('gallery-images').files;
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    galleryDisplay.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });

        const roomForm = document.getElementById('room-form');
        const roomTable = document.getElementById('room-table').querySelector('tbody');
        const imagePreview = document.getElementById('image-preview');

        document.getElementById('room-image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        });

        document.getElementById('add-room').addEventListener('click', function() {
            const id = document.getElementById('room-id').value;
            const imageSrc = imagePreview.src !== '#' ? imagePreview.src : '';
            const title = document.getElementById('room-title').value;
            const description = document.getElementById('room-description').value;
            const price = document.getElementById('room-price').value;
            const conditions = document.getElementById('room-conditions').value;

            if (id && title && description && price && conditions) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${id}</td>
                    <td>${imageSrc ? `<img src="${imageSrc}" alt="Room Image" width="50">` : ''}</td>
                    <td>${title}</td>
                    <td>${description}</td>
                    <td>${price}</td>
                    <td>${conditions}</td>
                    <td><button class="delete-room">Delete</button></td>
                `;
                roomTable.appendChild(row);

                roomForm.reset();
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            } else {
                alert('Please fill in all fields before adding the room.');
            }
        });

        roomTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-room')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>