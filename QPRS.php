<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Complaint</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .container2 {
      margin-top: 20px;
      margin-left:0%;
      width:100%;
      background-color:#09057A;
        padding:20px 20px 20px 20px;
    }
    .bg-white {
      background-color: white;
    }
    .text-black {
      color: white;
    }
    .header-logo img {
      height: 50px; /* Adjust height as needed */
    }
    #h11{
        color:white;
    }

    .form-group{
        padding: 10px 10px 10px 1px;
    }
    .container.mt-4{
            background-color:#EBEBEB;
    }
    
    
  </style>
</head>
<body >

<div class="container2">
  <div class="row align-items-center">
    <div class="col-md-3">
      <div class="header-logo">
        <img src="Image/blg.png" alt="Logo">
      </div>
    </div>
    <div class="col-md-6 text-center">
      <h2 id="h11">Quality Problem Resolution Sheet</h2>
    </div>
    <div class="col-md-3 text-right">
    <a href="Book1.xlsx" class="btn btn-primary" download>Download PDF</a>
    </div>
  </div>
</div>

<style>
    body {
      background-color: #f8f9fa; /* Light grey background */
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background-color: #fff; /* White background */
      border-radius: 10px; /* Rounded corners */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Soft shadow */
    }

    .container h2 {
      color: #007bff; /* Primary color */
      margin-bottom: 30px;
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      color: #495057; /* Form label color */
    }

    .btn-primary {
      background-color: #007bff; /* Primary button color */
      border-color: #007bff; /* Primary button border color */
    }

    .btn-primary:hover {
      background-color: #0056b3; /* Darker color on hover */
      border-color: #0056b3; /* Darker border color on hover */
    }

    .form-text {
      color: #6c757d; /* Form text color */
    }

    textarea.form-control {
      resize: vertical; /* Allow vertical resizing of text area */
    }




    
  </style>
</head>
<body>

<div class="container">

  <form action="IQprs.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="complaint_id" value="<?php echo $_GET['complaint_id']; ?>">

    <div class="form-group">
      <label for="category" class="form-label">Complaint Category:</label>
      <select class="form-control" id="category" name="category" required>
        <option value="" disabled selected>Select Category</option>
        <option value="Material">Material</option>
        <option value="Man">Man</option>
        <option value="Machine">Machine</option>
        <option value="Method">Method</option>
      </select>
    </div>
    <div class="form-group">
        
      <label for="qprsFile" class="form-label">Upload QPRS:</label>
      <input type="file" class="form-control-file" id="qprsFile" name="qprsFile" required>
    </div>
    <div class="form-group">
      <label for="otherAttachments" class="form-label">Other Attachments (PDF/Image):</label>
      <input type="file" class="form-control-file" id="otherAttachments" name="otherAttachments[]" multiple>
      <small class="form-text text-muted">You can upload multiple files by holding down the CTRL or Command key while selecting files.</small>
    </div>
    <div class="form-group">
      <label for="comment" class="form-label">Comment:</label>
      <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Enter your comment here..."></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
  </form>
</div>


</body>
</html>