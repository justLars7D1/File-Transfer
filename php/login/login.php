<?php
session_start();
if (isset($_SESSION['user'])) {
  echo 'You are already logged in!';
  exit;
}

include('../connect.php');

$user_uid = mysqli_real_escape_string($conn, $_POST['uid']);
$user_pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

if ($stmt = $conn->prepare('SELECT COUNT(*), user_pwd, user_id FROM users WHERE user_uid=?')) {
  $stmt->bind_param('s', $user_uid);
  $stmt->execute();
  $result = $stmt->get_result();
  $result = $result->fetch_assoc();
  $fetched_pwd = $result['user_pwd'];
  if ($result['COUNT(*)'] == 1) {
    if (password_verify($user_pwd, $fetched_pwd)) {
      $_SESSION['user'] = [$result['user_id'], $user_uid, $user_pwd];
      echo '<script>location.reload()</script>';
    } else {
      echo 'Thez provided username or password is incorrect!';
      exit;
    }
  } else {
    echo 'Thes provided username or password is incorrect!';
    exit;
  }

} else {
  echo 'Could not perform the search query!';
  exit;
}

?>
