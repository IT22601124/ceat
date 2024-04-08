<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export to PDF</title>
  <!-- Include the jsPDF library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>

  <!-- Your HTML content to be exported -->
  <div id="content">
    <h1>Hello, World!</h1>
    <p>This is a test content for exporting to PDF.</p>
  </div>

  <!-- Button to trigger PDF export -->
  <button onclick="exportToPDF()">Export to PDF</button>

  <script>
    // Function to export HTML content to PDF
    function exportToPDF() {
      const doc = new jsPDF();

      // Get the HTML content to be exported
      const content = document.getElementById('content').innerHTML;

      // Convert the HTML content to PDF
      doc.fromHTML(content, 15, 15, {
        width: 170
      }, function () {
        // Generate Data URI for the PDF content
        const pdfDataUri = doc.output('datauristring');

        // Open the PDF in a new browser tab
        const newTab = window.open();
        if (newTab !== null) {
          newTab.document.write('<iframe width="100%" height="100%" src="' + pdfDataUri + '"></iframe>');
        } else {
          alert('Your browser blocked opening the PDF. Please allow pop-ups for this site.');
        }
      }, function (error) {
        console.error('Error generating PDF:', error);
        alert('Error generating PDF. Please try again later.');
      });
    }
  </script>

</body>
</html>
