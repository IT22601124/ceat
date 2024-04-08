<?php
include 'php/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["complaintId"])) {
  $complaintId = $_POST["complaintId"];
  
  // Prepare and execute SQL statement to delete the complaint
  $sql = "DELETE FROM complaint WHERE ComplaintID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $complaintId);
  
  if ($stmt->execute()) {
    echo "Complaint deleted successfully";
  } else {
    echo "Error deleting complaint: " . $conn->error;
  }
  
  $stmt->close();
}

$conn->close();
?>
