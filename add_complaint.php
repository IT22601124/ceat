<?php
// Include the file that contains your database connection code
include 'php/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vendorCode = $_POST["vendorCode"];
    $deliveryId = $_POST["deliveryId"];
    $complaintTitle = $_POST["complaintTitle"];
    $complaint = $_POST["complaint"];
    $complaintDate = $_POST["complaintDate"];

    // Check if a file was uploaded
    if (isset($_FILES["pdfFile"]) && $_FILES["pdfFile"]["error"] == UPLOAD_ERR_OK) {
        // Define the directory where the PDF files will be stored
        $uploadDirectory = "uploads/";

        // Generate a unique file name to prevent overwriting
        $fileName = uniqid() . "_" . basename($_FILES["pdfFile"]["name"]);
        
        // Define the path to save the file on the server
        $filePath = $uploadDirectory . $fileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $filePath)) {
            // Insert data into the complaint table, including the file path
            $sql = "INSERT INTO complaint (VendorCode, DeliveryID, ComplaintTitle, Complaint, CompaintDate, pdf_file)
                    VALUES ('$vendorCode', '$deliveryId', '$complaintTitle', '$complaint', '$complaintDate', '$filePath')";
            
            if ($conn->query($sql) === TRUE) {
                $complaintId = $conn->insert_id;
                header("Location: c_success.php?complaintId=$complaintId");
                exit(); 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file";
        }
    } else {
        echo "No file uploaded";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
