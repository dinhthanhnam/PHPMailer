<?php
  session_start();
  if(isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Bạn đã đăng nhập rồi.";
    header('Location: userdashboard.php');
    exit(0);
  }

  $page_title = "Đăng nhập";
  include('includes/header.php');
  include('includes/navbar.php');
  
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <?php 
          if(isset($_SESSION['status'])) {
            echo '<div class="alert alert-success">';
            echo "<h4>".$_SESSION['status']."</h4>";
            echo '</div>';
            unset($_SESSION['status']);
          }
        ?>
        <div class="card shadow">
          <div class="card-header">
            <h5>Form Đăng nhập</h5>
          </div>
          <div class="card-body">
            <form action="logincode.php" method="POST">
              <div class="form-group mb-3">
                <label for="">Địa chỉ Email</label>
                <input type="text" name="email" class="form-control" required>
              </div>
              <div class="form-group mb-3">
                <label for="">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="form-group">
                <button type="submit" name="login_btn" class="btn btn-primary">Đăng nhập</button>
              </div>
            </form>
            <hr>
            <h5>
              Không nhận được Email xác minh?
              <a href="resend_email_verication.php">Gửi lại</a>
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>