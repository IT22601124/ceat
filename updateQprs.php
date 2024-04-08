<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit QPRS Data</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/Com_css.css">
    <style>
.container2{
  width: 96%;
  margin-left: 2%;
}.container.mt-4{
    width:60%;
   
    background-color:white;
    padding: 20px 20px 20px 20px;
    border-radius:16px;     
}body{
    background-image: url("Image/bak2.jpg");

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
        <h1 id="h1_c">Edit QPRS Data</h1>
      </div>
    </div>
</div>

<div class="container mt-4">
   
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
            // Data found, display the edit form
            $row = $result->fetch_assoc();
            ?>
            <form action="updateQprsProcess.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="document_no" value="<?php echo $row['DocumentNo']; ?>">
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select class="form-control" id="category" name="category">
                        <option value="Man" <?php if ($row['Category'] == 'Man') echo 'selected'; ?>>Man</option>
                        <option value="Material" <?php if ($row['Category'] == 'Material') echo 'selected'; ?>>Material</option>
                        <option value="Method" <?php if ($row['Category'] == 'Method') echo 'selected'; ?>>Method</option>
                        <option value="Machine" <?php if ($row['Category'] == 'Machine') echo 'selected'; ?>>Machine</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="qprs_form">QPRS Form:</label>
                    <input type="file" class="form-control" id="qprs_form" name="qprs_form">
                </div>
                <div class="form-group">
                    <label for="other_document">Other Document:</label>
                    <input type="file" class="form-control" id="other_document" name="other_document">
                </div>
                <div class="form-group">
                    <label for="vendor_comment">Vendor Comment:</label>
                    <input type="text" class="form-control" id="vendor_comment" name="vendor_comment" value="<?php echo $row['VendorComment']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <?php
        } else {
            // No data found for the provided document number
            echo "<p>No data found for document number: $docNo</p>";
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
</div>

</body>
</html>
