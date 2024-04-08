<?php
// Include the database connection file
include 'php/connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $category = $_POST['category'];
    $comment = $_POST['comment'];
    $complaint_id = $_POST['complaint_id']; // Corrected variable name
    $date = date('y-m-d');
    
    // Upload QPRS file
    $qprsFileName = $_FILES['qprsFile']['name'];
    $qprsFileTmpName = $_FILES['qprsFile']['tmp_name'];
    $qprsFileDestination = 'uploads/' . $qprsFileName;
    move_uploaded_file($qprsFileTmpName, $qprsFileDestination);

    // Upload other attachments
    $otherAttachments = [];
    if (!empty($_FILES['otherAttachments']['name'][0])) {
        $otherAttachmentsFiles = $_FILES['otherAttachments'];
        foreach ($otherAttachmentsFiles['name'] as $key => $fileName) {
            $fileTmpName = $otherAttachmentsFiles['tmp_name'][$key];
            $fileDestination = 'uploads/' . $fileName;
            move_uploaded_file($fileTmpName, $fileDestination);
            $otherAttachments[] = $fileName;
        }
    }
   
    // Insert data into database
    $sql = "INSERT INTO qprs (CompaintId, Category, QPRSform, OtherDocument, VendorComment, Date)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Handle preparation error
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    $stmt->bind_param("ssssss", $complaint_id, $category, $qprsFileDestination, json_encode($otherAttachments), $comment, $date);

    // Execute the statement
    if ($stmt->execute()) {
        // Retrieve the document number of the last inserted data
        $document_no = mysqli_insert_id($conn);

        // Redirect to success page with complaint_id and document_no parameters
        header("Location: success.php?complaint_id=" . urlencode($complaint_id) . "&document_no=" . urlencode($document_no));
        exit();
    } else {
        // Handle insertion error
        echo "Error executing statement: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to error page if form is not submitted
    header("Location: error.php");
    exit();
}
?>
