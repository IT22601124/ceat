  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/Com_css.css">
  <style>
    #p1{
    background-color: #DBDBDB;
    padding:5px 25px 25px 25px;
  }
  #p2{

  
    padding:5px 25px 25px 25px;
  }
  .container2{
    width: 90%;
    margin-left:5%;
    font-size:20px;

    
  }
  .container3{
    width: 90%;
    margin-left:0%;
    font-size:20px;
  }

  .cc{
    width: 90%;
    margin-left:8%;
    font-size:20px;


  }

  #GQ{
      font-size: 20px;
      margin-left:10%;
      
  }
  .content-container {
    display: flex;
    align-items: center;
  }

  .text-container {
    flex: 1; /* Take up remaining space */
  }

  .image-container {
    margin-left: auto; /* Push the image to the right */
  }
  .img1{
    margin-left:-100px;
  }
  #cdiv{
    background-color:#DBDBDB;
    margin-left:-5%;
    width: 20%;
    
  }

  </style>
  </head>
  <body>
  <div class="container2" id="nav1">
      <div class="row">
        <div class="col-sm-6">
          <img src="Image/lgo2.png" width="180" height="100" alt="Logo" id="lg2">
        </div>
        <div class="col-sm-6">
          <h1 id="h1_c">COMPLAINT</h1>
        </div>
      </div>
  </div>
  <br><br>

  <div class="cc" >
      <div class="row">
        <div class="col-sm-6">
          
    <div class="container3" id="cn1">
      <div id="complaint-details">
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

  // Get complaint ID from URL parameter
  $complaintId = $_GET['complaintId'];

  // Query to fetch details of the specified complaint
  $sql = "SELECT * FROM complaint WHERE ComplaintID = $complaintId";
  $result = $conn->query($sql);


  // Fetch complaint details
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // Display details
      echo "<p id='p1'><strong>Complaint ID:</t></strong> " . $row["ComplaintID"] . "</p>";
      echo "<p id='p2'><strong>Delivery ID:</strong> " . $row["DeliveryID"] . "</p>";
      echo "<p id='p1'><strong>Title:</strong> " . $row["ComplaintTitle"] . "</p>";
      echo "<p id='p2'><strong>Complaint:</strong> " . $row["Complaint"] . "</p>";
      echo "<p  id='p1'><strong>Date:</strong> " . $row["CompaintDate"] . "</p>";

      // Pass complaint ID and delivery ID to JavaScript
      echo "<script>";
      echo "var complaintId = " . $row["ComplaintID"] . ";";
      echo "var deliveryId = " . $row["DeliveryID"] . ";";
      echo "</script>";
    }
  } else {
    echo "<p>No details found for the specified complaint ID</p>";
  }

  // Close connection
  $conn->close();
  ?>

      </div>
    </div>

        </div>
        <div class="col-sm-6" id="cdiv">
          <div id="cd2"><h1 st>Delivery Details</h1></div>

          <?php
  // Include your database connection file
  include 'php/connect.php';

  // Query to fetch DeliveryID based on ComplaintID
  $sql = "SELECT DeliveryID FROM complaint WHERE ComplaintID = $complaintId";
  $result = $conn->query($sql);

  if ($result) {
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $deliveryId = $row['DeliveryID'];

      // Query to fetch delivery details using DeliveryID
      $sql_delivery = "SELECT * FROM delivery WHERE DeliveryId = $deliveryId";
      $result_delivery = $conn->query($sql_delivery);

      if ($result_delivery) {
        if ($result_delivery->num_rows > 0) {
          while ($row = $result_delivery->fetch_assoc()) {
            // Display details
            echo "<p id='p1'><strong>Order ID:</strong> " . $row["OrderId"] . "</p>";
            echo "<p id='p2'><strong>Vendor Code:</strong> " . $row["VendorCode"] . "</p>";
            echo "<p id='p1'><strong>Invoice No:</strong> " . $row["InvoiceNo"] . "</p>";
            echo "<p id='p2'><strong>Product:</strong> " . $row["Product"] . "</p>";
            echo "<p id='p1'><strong>Quantity:</strong> " . $row["Quantity"] . "</p>";
            echo "<p id='p2'><strong>Shipping Method:</strong> " . $row["ShippingMethod"] . "</p>";
            echo "<p id='p1'><strong>Estimated Date:</strong> " . $row["EstimateDate"] . "</p>";
            echo "<p id='p2'><strong>Delivery Date:</strong> " . $row["DeliveryDate"] . "</p>";
            echo "<p id='p1'><strong>Comment:</strong> " . $row["Comment"] . "</p>";

            echo "<script>";
            echo "var complaintId = " . $row["ComplaintID"] . ";";
            echo "var deliveryId = " . $row["DeliveryID"] . ";";
            echo "</script>";
          }
        } else {
          echo "<p>No details found for the specified delivery ID</p>";
        }
      } else {
        echo "Error fetching delivery details: " . $conn->error;
      }
    } else {
      echo "<p>No DeliveryID found for the specified ComplaintID</p>";
    }
  } else {
    echo "Error fetching DeliveryID: " . $conn->error;
  }


  // Close connection
  $conn->close();
  ?>




        </div>
      </div>
  </div>
  <br>

  <div id="GQ" class="content-container">
    <label><b>Go to Quality Problem Resolution sheet</b></label>
    
  <img src="Image/goo.png" width="180" height="100" alt="Logo" id="img1" onclick="redirectToQPRS()">


  </div>

  <div class="container mt-4">
    <div class="table-responsive">
        <table id="complaintsTable" class="table table-bordered table-striped">
            <!-- Table content -->
        </table>
    </div>
   

</div>

    
      <button class="btn btn-primary" onclick="window.print()">Print</button>
  </div>

  <!-- External libraries -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>


  <script>
    // Function to export table data to PDF



  function redirectToQPRS() {
    
      // Construct the URL with the complaint ID and delivery ID as query parameters
      var url = "QPRS.php?complaint_id=" + complaintId + "&delivery_id=" + deliveryId;

      // Redirect to the new page
      window.location.href = url;
  }

  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
  </html>



