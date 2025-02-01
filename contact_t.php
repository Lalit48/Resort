<?php
// Database connection
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "resort"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch contact data
$sql = "SELECT * FROM contact";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 1rem;
        }

        .add-button {
            display: block;
            margin: 1rem 0;
            padding: 0.75rem 1.5rem;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
            width: fit-content;
        }

        .add-button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .action-buttons button {
            margin-right: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
        }

        .delete-button:hover {
            background-color: #e53935;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>Contact Information</h1>
    </header>

    <div class="container">
    <form method="POST">
        <button type="submit" name="export" class="add-button">Export to PDF</button>
    </form>
        <table>
            <thead>
                <tr>
                    <th>Sl. No</th>
                    
                    <th>Customer Name</th>
                    <th>Customer Number</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Subbmitted at</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are results
                if ($result->num_rows > 0) {
                    // Output data of each row
                    $sl_no = 1; // Start counting rows from 1
                    while($row = $result->fetch_assoc()) {
                        // Displaying the fetched data in the table
                        echo "<tr>
                                <td>" . $sl_no . "</td>
                                
                                <td>" . $row['name'] . "</td>
                                <td>" . $row['phone_number'] . "</td>
                                <td>" . $row['email'] . "</td> <!-- Add actual check-out date if needed -->
                                <td>" . $row['message'] . "</td> <!-- Add actual prize here if needed -->
                                <td>" . $row['submitted_at'] . "</td> <!-- Add actual check-in date if needed -->
                            </tr>";
                        $sl_no++; // Increment the serial number
                    }
                } else {
                    echo "<tr><td colspan='7'>No contacts found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <?php
        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
