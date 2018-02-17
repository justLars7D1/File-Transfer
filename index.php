<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ./login.php');
  exit;
}
session_destroy();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Transfile - Home</title>
  </head>
  <body>

  </body>
</html>
