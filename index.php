<?php 
  session_start();
  $page_title = "Trang chính";
  include('includes/header.php');
  include('includes/navbar.php');
?>

<div class="py-5">
  <div class="container">
    <div class="row">
      <?php 
        if(!isset($_SESSION['authenticated'])) {
          echo "
          <div class='col-md-12 text-center'>
          <h2>Hệ thống đăng ký đăng nhập & xác nhận Email</h2>
          <h4>dùng PHPMailer</h4>
          </div>";
        } else {
          echo "
          <div class='col-md-12 text-center'>
          <h2>Xin chào ".$_SESSION['auth_user']['username']."</h2>
          </div>";
        }
      ?>
      
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>