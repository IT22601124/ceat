<?php
// Include the database connection file
include 'php/connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $document_no = $_POST['document_no'];
    $category = $_POST['category'];
    $vendor_comment = $_POST['vendor_comment'];
    $date = date('y-m-d');

    // Update QPRS Form if a new file is uploaded
    if ($_FILES['qprs_form']['size'] > 0) {
        $qprsFileName = $_FILES['qprs_form']['name'];
        $qprsFileTmpName = $_FILES['qprs_form']['tmp_name'];
        $qprsFileDestination = 'uploads/' . $qprsFileName;
        move_uploaded_file($qprsFileTmpName, $qprsFileDestination);

        // Update QPRS Form in the database
        $updateQprsFormSql = "UPDATE qprs SET QPRSform = ? WHERE DocumentNo = ?";
        $stmt = $conn->prepare($updateQprsFormSql);
        $stmt->bind_param("ss", $qprsFileDestination, $document_no);
        $stmt->execute();
        $stmt->close();
    }

    // Update Other Document if a new file is uploaded
    if ($_FILES['other_document']['size'] > 0) {
        $otherDocumentFileName = $_FILES['other_document']['name'];
        $otherDocumentTmpName = $_FILES['other_document']['tmp_name'];
        $otherDocumentDestination = 'uploads/' . $otherDocumentFileName;
        move_uploaded_file($otherDocumentTmpName, $otherDocumentDestination);

        // Update Other Document in the database
        $updateOtherDocumentSql = "UPDATE qprs SET OtherDocument = ? WHERE DocumentNo = ?";
        $stmt = $conn->prepare($updateOtherDocumentSql);
        $stmt->bind_param("ss", $otherDocumentDestination, $document_no);
        $stmt->execute();
        $stmt->close();
    }

    // Update Category and Vendor Comment in the database
    $updateQprsSql = "UPDATE qprs SET Category = ?, VendorComment = ?, Date = ? WHERE DocumentNo = ?";
    $stmt = $conn->prepare($updateQprsSql);
    $stmt->bind_param("ssss", $category, $vendor_comment, $date, $document_no);
    $stmt->execute();
    $stmt->close();

    // Redirect to success page
    header("Location: success.php?document_no=" . urlencode($document_no));
    exit();
} else {
    // Redirect to error page if form is not submitted
    header("Location: error.php");
    exit();
}
?>
