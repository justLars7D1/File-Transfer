<?php
session_start();
if (!isset($_GET['id'])) {
  header('Location: ./login.php');
  exit;
}

include('./php/connect.php');

$file_id = mysqli_real_escape_string($conn, $_GET['id']);
$file_id .= '%';

if ($stmt = $conn->prepare('SELECT COUNT(*), upload_name, upload_user_id FROM uploaded_files WHERE upload_name LIKE ?')) {
  $stmt->bind_param('s', $file_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $result = $result->fetch_assoc();
  if ($result['COUNT(*)'] != 1) {
    header('./login.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Download - Transfile</title>
  </head>
  <body>
    <div>
      <p>File:</p>
      <?php
      echo '<p><a style="text-decoration:none;" href="http://localhost:8080/filetransfer/uploads/'.$result['upload_name'].'">'.$result['upload_name'].'</a> by ';

      $statement = $conn->prepare('SELECT user_uid FROM users WHERE user_id=?');
      $statement->bind_param('i', $result['upload_user_id']);
      $statement->execute();
      $outcome = $statement->get_result();
      $outcome = $outcome->fetch_assoc();
      echo $outcome['user_uid'].'</p>';
      ?>
    </div>
  </body>
</html>
