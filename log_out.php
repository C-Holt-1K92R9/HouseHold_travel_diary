<?php
  // PHP example
  require "0_config.php";
  session_start();
  $id=$_SESSION['user_id'];
  unset($_SESSION['user_id']);
  $conn->query("UPDATE user 
                    SET login_token = ''
                    WHERE user_id = '$id'");
  $cookie_name = 'my_cookie';
  setcookie('logincookie', '', time() - (3600*24*2), '/'); // set expiration date to 1 day ago
  unset($_COOKIE['logincookie']);
  session_destroy();
  header('Location: index.php');
  exit;
?>