  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QPRS Table</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/Com_css.css">
    <style>
      /* Table styling */
.table {
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
  max-width: 100%;
  background-color: #fff;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 6px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

/* Table header */
.table thead th {
  background-color: #f8f9fa;
  border-bottom: 2px solid #dee2e6;
  color: #6c757d;
  font-weight: bold;
  padding: 10px;
  text-align: left;
}

/* Table body */
.table tbody td {
  border-bottom: 1px solid #dee2e6;
  padding: 10px;
}

/* Alternate row color */
.table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

/* Hover effect */
.table tbody tr:hover {
  background-color: #f0f0f0;
}

/* Links in table cells */
.table tbody a {
  color: #007bff;
}

/* Button styling */
.btn {
  padding: 8px 20px;
  font-size: 14px;
  border-radius: 4px;
}

/* Primary button */
.btn-primary {
  color: #fff;
  background-color: #007bff;
  border: 1px solid #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

      .mb-4{

      }
      .container2{
    width: 98%;
    margin-left:25px;
  }
  #h1_1{
    color: azure;
      position: absolute;
      left: -250px;
      bottom: 20px;
      font-size:30px;
  }#searchInput {
      margin-bottom: 15px;
      width: 300px; /* Adjust width as needed */
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
          <h1 id="h1_1">Quality Problem Resolution Sheet</h1>
        </div>
      </div>
  </div>



  <div class="container mt-4">
    <div class="form-group">
      <label for="categoryFilter">Filter by Category:</label>
      <select class="form-control" id="categoryFilter">
        <option value="">All Categories</option>
        <option value="Material">Material</option>
        <option value="Man">Man</option>
        <option value="Machine">Machine</option>
        <option value="Method">Method</option>
      </select>
    </div>
    
    <!-- Table remains unchanged -->
    <table class="table">
      <!-- Table headers remain unchanged -->
      <thead>
        <tr>
          <th>Document No</th>
          <th>Complaint ID</th>
          <th>Category</th>
          <th>QPRS Form</th>
          <th>Other Document</th>
          <th>Vendor Comment</th>
          <th>Date</th>
          <th>Comment</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Include the file that contains your database connection code
        include 'php/connect.php';

        // Query to fetch data from the QPRS table
        $sql = "SELECT * FROM QPRS";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['DocumentNo']}</td>";
            echo "<td>{$row['CompaintId']}</td>";
            echo "<td>{$row['Category']}</td>";
            echo "<td><a href='{$row["QPRSform"]}' target='_blank'>{$row["QPRSform"]}</a></td>";
          echo "<td><a href='{$row["OtherDocument"]}' target='_blank'>{$row["OtherDocument"]}</a></td>";

            echo "<td>{$row['VendorComment']}</td>";
            echo "<td>{$row['Date']}</td>";
            echo "<td><button type='button' class='btn btn-primary add-comment-btn' data-toggle='modal' data-target='#commentModal' data-document-no='{$row['DocumentNo']}'>Comment</button></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Comment Modal -->
  <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="commentForm">
          <div class="modal-body">
            <div class="form-group">
              <label for="comment">Comment:</label>
              <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <input type="hidden" id="documentNo" name="documentNo">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Comment</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".add-comment-btn").click(function() {
        var documentNo = $(this).data('document-no');
        $("#documentNo").val(documentNo);
      });

      $("#commentForm").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
          url: "save_comment.php",
          type: "POST",
          data: formData,
          success: function(response) {
            
            alert("Comment added successfully!");
            $("#commentModal").modal("hide");
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred. Please try again.");
          }
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Function to filter table rows based on selected category
      $("#categoryFilter").change(function() {
        var selectedCategory = $(this).val();
        if (selectedCategory === "") {
          // If "All Categories" is selected, show all rows
          $("tbody tr").show();
        } else {
          // Otherwise, hide rows that do not match the selected category
          $("tbody tr").hide().filter(function() {
            return $(this).find("td:eq(2)").text() === selectedCategory;
          }).show();
        }
      });

      // Rest of your JavaScript code remains unchanged
      $(".add-comment-btn").click(function() {
        var documentNo = $(this).data('document-no');
        $("#documentNo").val(documentNo);
      });

      $("#commentForm").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        
        $.ajax({
          url: "save_comment.php",
          type: "POST",
          data: formData,
          success: function(response) {
            alert("Comment added successfully!");
            $("#commentModal").modal("hide");
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred. Please try again.");
          }
        });
      });
    });
  </script>


  </body>
  </html>
