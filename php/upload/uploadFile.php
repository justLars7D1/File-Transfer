<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ./login.php');
  exit;
}

if (empty($_FILES['file'])) {
  echo 'There was no file found!';
  exit;
}

include('../connect.php');

$file = $_FILES['file'];

$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileError = $file['error'];
$fileType = $file['type'];

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

if ($fileError != 0) {
  echo 'There was an error when uploading your file!';
  exit;
}

$uniqid = uniqid('', true);

$fileNameNew = $uniqid.".".$fileActualExt;
$fileDestination = '../../uploads/'.$fileNameNew;

$sql = "INSERT INTO uploaded_files (upload_name, upload_user_id) VALUES (?, ?)";

if($statement = $conn->prepare($sql)) {
  $statement->bind_param('si', $fileNameNew , $_SESSION['user'][0]);
  if ($statement->execute()) {
    if (move_uploaded_file($fileTmpName, $fileDestination)) {
      echo '<br><br>The file has been uploaded!<br>
    Give this URL to a friend so he can download it:<br> <a href="http://localhost:8080/filetransfer/download.php?id='.$uniqid.'">http://localhost:8080/filetransfer/download.php?id='.$uniqid.'</a>';
    }
  }
}

?>
