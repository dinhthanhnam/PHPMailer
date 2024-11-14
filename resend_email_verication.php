<?php
session_start();

$page_title = "Đăng nhập";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
          <?php 
            if(isset($_SESSION['status'])) 
            {
              ?>
              <div class="alert alert-success">
                <h5> <? $_SESSION['status'] ?></h5>
              </div>
              <?php
              unset($_SESSION['status']);
            }
          ?>
        <div class="card">
          <div class="card-header">
            <h5>Gửi lại Email xác minh</h5>
          </div>
          <div class="card-body">
            <form action="resend-code.php" method="POST">
              <div class="form-group mb-3">
                <label for="">Địa chỉ Email</label>
                <input type="text" name="email" class="form-control" required>
              </div>
              <div class="form-group">
                <button type="submit" name="resend_email_verify_btn" class="btn btn-primary">Gửi lại</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>