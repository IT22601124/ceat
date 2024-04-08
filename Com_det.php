<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title >Add Complaint</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/Com_css.css">
  <style>
    .form-group {
      margin-top: 30px;
      margin-left:80px;
      width: 70%;
    }
    
    body{
    background-image: url('Image/bak2.jpg');
    color:white;
    background-size: cover;
    
}
.btn.btn-primary{
    margin-left:350px;
    height:50px;
    width:200px;
}
.container{
    
    position: auto;
    top: 80px;
    left: 280px;
    width: 80%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8); /* Background color with 50% opacity */

    z-index: 999; /* Ensure it appears on top of other content */

}h1{
    background-color: white;
    color: black;
    height: 80px;
    border: 2px solid black;
    text-align: center; /* Center align the text */
    line-height: 80px; /* Vertically center the text */
    font-family: Arial, sans-serif; /* Specify a font */
    font-size: 24px; /* Adjust font size */
    border-radius: 10px; /* Add border radius for rounded corners */
    box-shadow: 0 0 50px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow */
    padding: 0 20px; /* Add padding */
}

  </style>
</head>
<body>

<div>
  <h1>Add Complaint</h1>
</div>
<br><br>
  <div class="container">
  <form action="add_complaint.php" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="vendorCode">Vendor Code</label>
  <input type="text" class="form-control" id="vendorCode" name="vendorCode" required>
</div>
    <div class="form-group">
      <label for="deliveryId">Delivery ID</label>
      <input type="text" class="form-control" id="deliveryId" name="deliveryId" required >
    </div>
    <div class="form-group">
      <label for="complaintTitle">Complaint Title</label>
      <input type="text" class="form-control" id="complaintTitle" name="complaintTitle" required>
    </div>
    <div class="form-group">
      <label for="complaint">Complaint</label>
      <textarea class="form-control" id="complaint" name="complaint" rows="3" required></textarea>
    </div>
    <div class="form-group">
      <label for="complaintDate">Complaint Date</label>
      <input type="date" class="form-control" id="complaintDate" name="complaintDate" required>
    </div>
    <div class="form-group">
      <label for="pdfFile">Attachments (PDF)</label>
      <input type="file" class="form-control-file" id="pdfFile" name="pdfFile">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>

</div>

<br><br><br>

</body>
</html>
