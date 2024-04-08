<?php
// Include the database connection file
include 'php/connect.php';

// Check if the document number is provided via POST
if (isset($_POST['documentNo'])) {
    // Sanitize the input to prevent SQL injection
    $documentNo = mysqli_real_escape_string($conn, $_POST['documentNo']);

    // Prepare a DELETE statement
    $sql = "DELETE FROM qprs WHERE DocumentNo = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $documentNo);

    // Execute the statement
    if ($stmt->execute()) {
        // Deletion successful
        echo "Data deleted successfully.";
    } else {
        // Error in deletion
        echo "Error deleting data: " . $conn->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If document number is not provided, return an error message
    echo "Document number not provided.";
}
?>
