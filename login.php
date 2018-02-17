<?php
session_start();
if (isset($_SESSION['user'])) {
  header('Location: ./index.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Transfile - Login</title>
  </head>
  <body>
    <div id="resultDiv"></div>
    <h1 style="margin-bottom:-10px;">Transfile</h1>
    <p>Transfer files rapidly quick!</p>
    <input type="text" id="uid" placeholder="Username"><br>
    <input type="password" id="pwd" placeholder="Password"><br>
    <input type="password" id="confirmPwd" placeholder="Confirm Password">
    <button type="button" id="submitBtn">Log in</button>
  </body>
  <script type="text/javascript">
    $(document).ready(function() {

      function validate(input) {
        if (!input) {
          return 0;
        } else {
          return 1;
        }
      }

      function confirm(pwd, confirmPwd) {
        if (pwd == confirmPwd) {
          return 1;
        } else {
          return 0;
        }
      }

      function requestLogin(uid, pwd, confirmPwd) {
        if (validate(uid) == 0 || validate(pwd) == 0 || validate(confirmPwd) == 0) {
          alert('Please fill in all forms before submitting!');
          return;
        }
        if (confirm(pwd, confirmPwd) == 0) {
          alert("The two passwords didn't match!");
          return;
        }
        if (uid.length > 30) {
          alert('Your username can not be longer than 30 characters!');
          return;
        }
        if (pwd.length > 50) {
          alert('Your password can not be longer than 50 characters!');
          return;
        }
        $.post('./php/login/login.php', {uid:uid, pwd:pwd}, function(data) {
          $('#resultDiv').html(data);
        });
      }

      $('#submitBtn').on('click', function() {
        var uid = $('#uid').val();
        var pwd = $('#pwd').val();
        var confirmPwd = $('#confirmPwd').val();
        requestLogin(uid, pwd, confirmPwd);
      });

    });
  </script>
</html>
