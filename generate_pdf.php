<?php
require_once('tcpdf.php'); 
require_once('php/connect.php'); 
require_once('tcpdf_autoconfig.php'); // Include TCPDF library

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Complaints Table');
$pdf->SetSubject('Complaints Table');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// HTML content
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complaints Table</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Complaints Table</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Complaint ID</th>
                <th>Delivery ID</th>
                <th>Complaint Title</th>
                <th>Complaint</th>
                <th>Complaint Date</th>
               
                
            </tr>
        </thead>
        <tbody>';

// Fetch data from the database and add it to the table
include 'php/connect.php';
$sql = "SELECT ComplaintID, DeliveryID, ComplaintTitle, Complaint, CompaintDate  FROM complaint";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row["ComplaintID"] . '</td>';
        $html .= '<td>' . $row["DeliveryID"] . '</td>';
        $html .= '<td>' . $row["ComplaintTitle"] . '</td>';
        $html .= '<td>' . $row["Complaint"] . '</td>';
        $html .= '<td>' . $row["CompaintDate"] . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="6">No complaints found</td></tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Output HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('complaints_table.pdf', 'D'); // Download the PDF as "complaints_table.pdf"
?>