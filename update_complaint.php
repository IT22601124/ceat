<?php
// Include the file that contains your database connection code
include 'php/connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $complaintId = $_POST["complaintId"];
    $complaintTitle = $_POST["complaintTitle"];
    $complaint = $_POST["complaint"];

    // Check if a new PDF file is uploaded
    if (isset($_FILES["pdfFile"]) && $_FILES["pdfFile"]["error"] == UPLOAD_ERR_OK) {
        // Define the directory where the PDF files will be stored
        $uploadDirectory = "uploads/";

        // Generate a unique file name to prevent overwriting
        $fileName = uniqid() . "_" . basename($_FILES["pdfFile"]["name"]);

        // Define the path to save the file on the server
        $filePath = $uploadDirectory . $fileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $filePath)) {
            // Update data in the complaint table, including the new file path
            $sql = "UPDATE complaint SET ComplaintTitle = ?, Complaint = ?, pdf_file = ? WHERE ComplaintId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $complaintTitle, $complaint, $filePath, $complaintId);
            if ($stmt->execute()) {
                // Redirect to a success page with the updated complaintId
                header("Location: c_success.php?complaintId=" . $complaintId);
                exit();
            } else {
                echo "Error updating complaint: " . $conn->error;
            }
        } else {
            echo "Error uploading file";
        }
    } else {
        // If no new file is uploaded, update data without changing the PDF file
        $sql = "UPDATE complaint SET ComplaintTitle = ?, Complaint = ? WHERE ComplaintId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $complaintTitle, $complaint, $complaintId);
        if ($stmt->execute()) {
            // Redirect to a success page with the updated complaintId
            header("Location: c_success.php?complaintId=" . $complaintId);
            exit();
        } else {
            echo "Error updating complaint: " . $conn->error;
        }
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If form is not submitted, redirect to an error page
    header("Location: error.php");
    exit();
}
?>
