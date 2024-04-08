<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaints Table</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/Com_css.css">
</head>
<style>
.container2{
  width: 98%;
  margin-left:2%;
  font-size:20px;
}

#h1_c {
  padding: 10px;
}

/* Custom CSS for table */
.table th, .table td {
  vertical-align: middle;
  text-align: center;
}

.table thead th {
  background-color: #007bff; /* Header background color */
  color: #fff; /* Header text color */
}

.table tbody tr:hover {
  background-color: #f8f9fa; /* Row hover background color */
}

/* Add 3D effect to the table */
.table {
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.table thead th {
  background-color: #004B94;
  color: #fff;
}

.table tbody td {
  background-color: #fff;
  border-bottom: 1px solid #ddd;
}

.table tbody tr:last-child td {
  border-bottom: none;
}

.table-hover tbody tr:hover td {
  background-color: #f8f9fa;
}

.table-striped tbody tr:nth-child(odd) td {
  background-color: #f8f9fa;
}

#na{
    width:1900px;
    margin-left:13%;
}
table{
    box-shadow 15px;
}#exportPDF{
    margin-left:40%;
    width:200px;
    height:50px;
}
#searchInput {
  width: 700px;
  border-radius: 20px;
  padding: 10px 15px;
  border: 1px solid #ced4da;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

#searchInput:focus {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
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

<br>

<div class="containert" id="na">
    <div class="row">
      <div class="col-sm-6">
      <input type="text" id="searchInput" class="form-control" placeholder="Search by Complaint Title">
      </div>
      <div class="col-sm-6">
      <a href="com_det.php" class="btn btn-primary mb-3">Add Complaint</a> 
      </div>
    </div>
</div>
<div name='html_content'>


<div class="container mt-4">
    <div class="table-responsive"> <!-- Make table responsive -->
        <table id="complaintsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Complaint ID</th>
                    <th>Delivery ID</th>
                    <th>Complaint Title</th>
                    <th>Complaint Date</th>
                    <th>PDF File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'php/connect.php';
                $sql = "SELECT ComplaintID, DeliveryID, ComplaintTitle, Complaint, CompaintDate, pdf_file FROM complaint";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr data-complaint-id='" . $row["ComplaintID"] . "'>";
                        echo "<td>" . $row["ComplaintID"] . "</td>";
                        echo "<td>" . $row["DeliveryID"] . "</td>";
                        echo "<td>" . $row["ComplaintTitle"] . "</td>";
                        echo "<td>" . $row["CompaintDate"] . "</td>";
                        echo "<td><a href='{$row["pdf_file"]}' target='_blank'>View PDF</a></td>";
                        echo "<td>";
                   
                        echo "<button type='button' class='btn btn-danger delete-btn'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No complaints found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<a href="generate_pdf.php" class="btn btn-primary mt-3" id="exportPDF">Export to PDF</a>
<br><br>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    // Search function
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#complaintsTable tbody tr').filter(function() {
            $(this).toggle($(this).find('td:nth-child(3)').text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Delete button click event
    $(".delete-btn").click(function() {
        var row = $(this).closest("tr");
        var complaintId = row.data("complaint-id");

        // Display a confirmation dialog
        var confirmDelete = confirm("Are you sure you want to delete this complaint?");

        // If user confirms, proceed with the deletion
        if (confirmDelete) {
            $.ajax({
                url: "delete.php",
                type: "POST",
                data: { complaintId: complaintId },
                success: function(response) {
                    row.remove();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>
</div>
</body>
</html>
