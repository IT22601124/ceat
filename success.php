<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray background */
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #0f0f4e;
            text-align: center;
            margin-bottom: 30px;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead th {
            background-color: #0f0f4e;
            color: #fff;
        }
        .btn {
            cursor: pointer;
        }
        .btn.btn-primary {
            background-color: #0f0f4e;
            border-color: #0f0f4e;
        }
        .btn.btn-danger.delete-btn {
            background-color: red;
            border-color: red;
        }
        .document-img {
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
        .document-table {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Success Inserted</h1>
    <img src="Image/ok.png" width="200px" height="200px" alt="" class="document-img">
    
    <!-- Display Inserted Data -->
    <div class="document-table">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Document No</th>
                    <th>Complaint ID</th>
                    <th>Category</th>
                    <th>QPRS Form</th>
                    <th>Other Document</th>
                    <th>Vendor Comment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Include the file that contains your database connection code
            include 'php/connect.php';

            // Check if the document number is provided in the URL
            if (isset($_GET['document_no'])) {
                $docNo = $_GET['document_no'];

                // Query to fetch data from the QPRS table for the specific document number
                $sql = "SELECT * FROM qprs WHERE DocumentNo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $docNo);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Data found, display it
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['DocumentNo']}</td>";
                        echo "<td>{$row['CompaintId']}</td>";
                        echo "<td>{$row['Category']}</td>";
                        echo "<td><a href='{$row["QPRSform"]}' target='_blank'>QPRS Form</a></td>";
                        echo "<td><a href='{$row["OtherDocument"]}' target='_blank'>Other Document</a></td>";
                        echo "<td>{$row['VendorComment']}</td>";
                        echo "<td>{$row['Date']}</td>";
                        echo "<td>";
                        echo "<button type='button' class='btn btn-danger delete-btn' data-document-no='{$row["DocumentNo"]}'>Delete</button>";
                        echo "<a href='updateQprs.php?document_no={$row["DocumentNo"]}' class='btn btn-primary'>Edit</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // No data found for the provided document number
                    echo "<tr><td colspan='8'>No data found</td></tr>";
                }

                // Close statement and database connection
                $stmt->close();
                $conn->close();
            } else {
                // Redirect to error page if document number is not provided
                header("Location: error.php");
                exit();
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $(".delete-btn").click(function() {
        var documentNo = $(this).data("document-no");

        // Display a confirmation dialog
        var confirmDelete = confirm("Are you sure you want to delete this data?");

        // If user confirms, proceed with the deletion
        if (confirmDelete) {
            $.ajax({
                url: "deleteQprs.php",
                type: "POST",
                data: { documentNo: documentNo },
                success: function(response) {
                    // Reload the page after deletion
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>

</body>
</html>
