<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Complaint</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            margin: auto;
        }
        .btn-delete {
            margin-top: 10px;
        }.container2{
  width: 96%;
  margin-top: -2%;
  margin-left: 2%;
  background-color: #0f0f4e;
  color:white;
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
    <div class="container">
        <?php
        // Include the file that contains your database connection code
        include 'php/connect.php';

        // Check if the ComplaintId is provided in the URL
        if (isset($_GET['complaintId'])) {
            $complaintId = $_GET['complaintId'];

            // Retrieve the complaint details using the ComplaintId
            $sql = "SELECT * FROM complaint WHERE ComplaintId = $complaintId";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                // Fetch the complaint details
                $row = $result->fetch_assoc();
        ?>
        <form action="update_complaint.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="complaintId" value="<?php echo $complaintId; ?>">
            <div class="form-group">
                <label for="complaintTitle">Complaint Title:</label>
                <input type="text" class="form-control" id="complaintTitle" name="complaintTitle" value="<?php echo $row['ComplaintTitle']; ?>">
            </div>
            <div class="form-group">
                <label for="complaint">Complaint:</label>
                <textarea class="form-control" id="complaint" name="complaint" rows="5"><?php echo $row['Complaint']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="pdfFile">Upload New PDF File:</label>
                <input type="file" class="form-control-file" id="pdfFile" name="pdfFile">
            </div>
            <button type="submit" class="btn btn-primary">Update Complaint</button>
        </form>
        <?php
            } else {
                // Complaint not found
                echo "<div class='alert alert-danger' role='alert'>Complaint not found.</div>";
            }
        } else {
            // ComplaintId not provided in the URL
            echo "<div class='alert alert-danger' role='alert'>Complaint ID not provided.</div>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
