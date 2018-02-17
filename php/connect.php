<?php
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'filetransfer';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
  echo("Connection failed: " . $conn->connect_error);
  exit;
}

?>
