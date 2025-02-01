<?php
require_once('tcpdf/tcpdf.php');
require_once('db_connect.php'); // Include DB connection

// Get selected data from the GET request
$selectedData = isset($_GET['data']) ? $_GET['data'] : [];

if (empty($selectedData)) {
    die("No data selected.");
}

// Create PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Selected Report');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Selected Report', 0, 1, 'C');

$pdf->SetFont('helvetica', 'B', 12);

// Fetch and add data based on selected checkboxes
if (in_array('booking', $selectedData)) {
    $pdf->Cell(0, 10, '📅 Booking Report', 0, 1, 'L');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Cell(35, 10, 'Name', 1);
    $pdf->Cell(50, 10, 'Email', 1);
    $pdf->Cell(25, 10, 'Phone', 1);
    $pdf->Cell(25, 10, 'Check-in', 1);
    $pdf->Cell(25, 10, 'Check-out', 1);
    $pdf->Cell(20, 10, 'Status', 1);
    $pdf->Ln();

    $sql = "SELECT id, first_name, last_name, email, phone_number, check_in_date, check_out_date, status FROM booking";
    $result = $conn->query($sql);
    $pdf->SetFont('helvetica', '', 10);

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(35, 10, $row['first_name'] . ' ' . $row['last_name'], 1);
        $pdf->Cell(50, 10, $row['email'], 1);
        $pdf->Cell(25, 10, $row['phone_number'], 1);
        $pdf->Cell(25, 10, $row['check_in_date'], 1);
        $pdf->Cell(25, 10, $row['check_out_date'], 1);
        $pdf->Cell(20, 10, $row['status'], 1);
        $pdf->Ln();
    }
}

if (in_array('contact', $selectedData)) {
    $pdf->Ln();
    $pdf->Cell(0, 10, '📞 Contact Messages', 0, 1, 'L');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Cell(35, 10, 'Name', 1);
    $pdf->Cell(50, 10, 'Email', 1);
    $pdf->Cell(25, 10, 'Phone', 1);
    $pdf->Cell(75, 10, 'Message', 1);
    $pdf->Ln();

    $sql = "SELECT id, name, email, phone_number, message FROM contact";
    $result = $conn->query($sql);
    $pdf->SetFont('helvetica', '', 10);

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(35, 10, $row['name'], 1);
        $pdf->Cell(50, 10, $row['email'], 1);
        $pdf->Cell(25, 10, $row['phone_number'], 1);
        $pdf->Cell(75, 10, substr($row['message'], 0, 30) . '...', 1);
        $pdf->Ln();
    }
}

if (in_array('rooms', $selectedData)) {
    $pdf->Ln();
    $pdf->Cell(0, 10, '🛏️ Rooms Information', 0, 1, 'L');
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Cell(50, 10, 'Title', 1);
    $pdf->Cell(85, 10, 'Description', 1);
    $pdf->Cell(25, 10, 'Price', 1);
    $pdf->Ln();

    $sql = "SELECT id, title, description, price FROM rooms";
    $result = $conn->query($sql);
    $pdf->SetFont('helvetica', '', 10);

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $row['id'], 1);
        $pdf->Cell(50, 10, $row['title'], 1);
        $pdf->Cell(85, 10, substr($row['description'], 0, 40) . '...', 1);
        $pdf->Cell(25, 10, $row['price'], 1);
        $pdf->Ln();
    }
}

// Close DB Connection
$conn->close();

// Output PDF
$pdf->Output('Selected_Report.pdf', 'I'); // 'I' for inline view
?>
