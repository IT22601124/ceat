<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vertical Dashboard</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/Com_css.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/com_no.css">
  <style>
    body {
      background-image: url("Image/bak2.jpg");
      background-repeat: no-repeat;
      background-size: cover;
    }

    .sidebar {
      background-color: #343a40; /* Dark background color */
      color: #fff; /* Light text color */
      height: 100vh;
      width: 250px;
      padding-top: 20px;
    }

    .content {
      padding: 20px;
    }

    .complaint {
      background-color: rgba(255, 255, 255, 0.7); /* White background color with 70% opacity */
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .nav-link {
      color: #fff; /* Light text color for links */
    }

    .nav-link:hover {
      background-color: #6c757d; /* Dark background color on hover */
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="nav flex-column">
      <img src="Image/lg1.png" alt="Logo" class="mx-auto d-block mb-4" style="width: 200px;">
      <a class="nav-link" href="#">Dashboard</a>
      <a class="nav-link" href="#">Orders</a>
      <a class="nav-link" href="#">Reports</a>
      <a class="nav-link" href="#">Messages</a>
      <a class="nav-link" href="#">Rating</a>
      <a class="nav-link" href="#">Complaints</a>
      <hr>
      <a class="nav-link mt-auto" href="#">Profile</a>
      <a class="nav-link" href="#">Logout</a>
    </div>
  </div>

  <div class="content">
    <?php
      // Establish connection to the database
      $servername = "localhost:4306"; // Change this to your servername
      $username = "root"; // Change this to your username
      $password = ""; // Change this to your password
      $dbname = "vendor"; // Change this to your database name
      
      $conn = new mysqli($servername, $username, $password, $dbname);
      
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
      // Assuming the vendor code is provided as a parameter, you can retrieve it like this
      $vendorCode = 'aa'; // $_Get['vendorCode]
      
      // Query to fetch complaints related to the vendor based on vendor code
      $sql = "SELECT ComplaintID, DeliveryID, ComplaintTitle, Complaint, CompaintDate 
              FROM complaint 
              WHERE vendorCode = '$vendorCode'";
      $result = $conn->query($sql);
      
      // Display complaints in divs
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<div class='complaint'>";
          echo "<h3>Complaint ID: " . $row["ComplaintID"] . "</h3>";
          echo "<p>Delivery ID: " . $row["DeliveryID"] . "</p>";
          echo "<p>Title: " . $row["ComplaintTitle"] . "</p>";
          echo "<p>Complaint: " . $row["Complaint"] . "</p>";
          echo "<p>Date: " . $row["CompaintDate"] . "</p>";
          echo "<button class='btn btn-primary more-details-btn' onclick='redirectToDetailsPage(" . $row["ComplaintID"] . ")'>More Details</button>";
          echo "</div>";
        }
      } else {
        echo "<p>No complaints found for this vendor</p>";
      }
      
      // Close connection
      $conn->close();
    ?>
  </div>

  <script>
    function redirectToDetailsPage(complaintId) {
      // Redirect to the new page with the complaint ID as a parameter
      window.location.href = 'com_details.php?complaintId=' + complaintId;
    }
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
