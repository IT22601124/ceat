<?php
// Include the database connection file
include 'php/connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $documentNo = $_POST['documentNo'];
    $comment = $_POST['comment'];

    // Check if a comment for the specified document number already exists
    $checkStmt = $conn->prepare("SELECT * FROM qprs WHERE DocumentNo = ?");
    $checkStmt->bind_param("i", $documentNo);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        // If a comment exists, update the existing comment
        $updateStmt = $conn->prepare("UPDATE qprs SET Comment = ? WHERE DocumentNo = ?");
        $updateStmt->bind_param("si", $comment, $documentNo);
        if ($updateStmt->execute()) {
            echo "Comment updated successfully!";
        } else {
            echo "Error updating comment: " . $conn->error;
        }
        $updateStmt->close();
    } else {
        // If no comment exists, insert a new comment
        $insertStmt = $conn->prepare("INSERT INTO qprs (DocumentNo, Comment) VALUES (?, ?)");
        $insertStmt->bind_param("is", $documentNo, $comment);
        if ($insertStmt->execute()) {
            echo "Comment added successfully!";
        } else {
            echo "Error inserting comment: " . $conn->error;
        }
        $insertStmt->close();
    }

    // Close the statement and database connection
    $checkStmt->close();
    $conn->close();
} else {
    // Redirect to error page if form is not submitted
    header("Location: error.php");
    exit();
}
?>
