<?php
// Include the file that contains your database connection code
include 'php/connect.php';

// Check if the complaintId is provided via POST method
if(isset($_POST['complaintId'])) {
    $complaintId = $_POST['complaintId'];

    // Prepare SQL statement to delete the complaint record
    $sql = "DELETE FROM complaint WHERE ComplaintId = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $complaintId);

    // Execute the statement
    if($stmt->execute()) {
        // Deletion successful
        echo "Complaint deleted successfully";
    } else {
        // Error in deletion
        echo "Error deleting complaint: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If complaintId is not provided
    echo "Complaint ID not provided";
}
?>
