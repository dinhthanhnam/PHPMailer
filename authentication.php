<?php
  session_start();

  if(!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Bạn cần đăng nhập trước để vào quản lý tài khoản.";
    header('Location: login.php');
    exit(0);
  }
?>
