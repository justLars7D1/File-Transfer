<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ./login.php');
  exit;
}
#session_destroy();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Transfile - Home</title>
  </head>
  <body>
    <h3>Upload your file:</h3>
    <input type="file" id="fileUpload"><button type="submit" id="uploadBtn">Submit</button>
    <div id='loadingmessage' style='display:none'>
      <img src='./loading.gif'/>
    </div>
    <div id="result"></div>
  </body>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#loadingmessage').hide();

      function validate(input) {
        if (!input) {
          return 0;
        } else {
          return 1;
        }
      }

      $('#uploadBtn').on('click', function() {
        var file = $('#fileUpload').val();
        if (validate(file) == 0) {
          alert('Please select a file first!');
          return;
        }
        var file_data = $('#fileUpload').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $('#loadingmessage').show();
        $.ajax({
          url: './php/upload/uploadFile.php',
          dataType: 'text',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(res) {
            $('#loadingmessage').hide();
            $('#result').html(res);
          }
        });
      });
    });
  </script>
</html>
