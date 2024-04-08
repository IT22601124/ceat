<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Success</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 20px;
        }
        .container2{
            background-color: #0f0f4e;
            width: 98%;
            margin-left: 2%;
            color:white;
            padding:5px 5px 5px 5px;
        }
        #h1_c{
            margin-left:-10%;
        }
        #send{
            margin-left:45%;
            background-color:green;
            width:130px;
            height:50px;
            

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

<div class="container">
    <div class="alert alert-success" role="alert">
        Complaint submitted successfully!
    </div>
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
    <table class="table table-striped">
        <tbody>
            <tr>
                <th>Complaint ID</th>
                <td><?php echo $complaintId; ?></td>
            </tr>
            <tr>
                <th>Vendor Code</th>
                <td><?php echo $row['vendorCode']; ?></td>
            </tr>
            <tr>
                <th>Delivery ID</th>
                <td><?php echo $row['DeliveryID']; ?></td>
            </tr>
            <tr>
                <th>Complaint Title</th>
                <td><?php echo $row['ComplaintTitle']; ?></td>
            </tr>
            <tr>
                <th>Complaint</th>
                <td><?php echo $row['Complaint']; ?></td>
            </tr>
            <tr>
                <th>Complaint Date</th>
                <td><?php echo $row['CompaintDate']; ?></td>
            </tr>
            <tr>
                <th>PDF File</th>
                <td><a href="<?php echo $row['pdf_file']; ?>" target="_blank">View PDF</a></td>
            </tr>
            <tr>
                <th>Actions</th>
                <td>
                    <a href="edit_complaint.php?complaintId=<?php echo $complaintId; ?>" class="btn btn-primary">Edit</a>
                    <button type="button" class="btn btn-danger delete-btn" data-complaint-id="<?php echo $complaintId; ?>">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
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

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- jQuery for Delete Functionality -->
<script>
$(document).ready(function() {
    $(".delete-btn").click(function() {
        var complaintId = $(this).data("complaint-id");

        // Display a confirmation dialog
        var confirmDelete = confirm("Are you sure you want to delete this complaint?");

        // If user confirms, proceed with the deletion
        if (confirmDelete) {
            $.ajax({
                url: "delete_complaint.php",
                type: "POST",
                data: { complaintId: complaintId },
                success: function(response) {
                    

                    window.location.href = "Com_det.php?complaintId=" + complaintId;

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>
<button type="button" class="btn btn-danger"  id="send">Send</button>
<script>
$(document).ready(function() {
    // Function to open default email client with prefilled details
    $("#send").click(function() {
        var recipient = "recipient@gmail.com"; // Change to your recipient email address
        var subject = "Complaint Details";
        var body = ""; // Add body content if needed

        var mailtoLink = "mailto:" + recipient + "?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
        window.location.href = mailtoLink;
    });
});
</script>
</body>
</html>
