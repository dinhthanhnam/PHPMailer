<?php
$page_title = "Đăng ký tài khoản";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow">
          <div class="card-header">
            <h5>Form Đăng ký</h5>
          </div>
          <div class="card-body">
            <form action="code.php" method="POST">
              <div class="form-group mb-3">
                <label for="">Tên</label>
                <input type="text" name="name" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label for="">Số điện thoại</label>
                <input type="text" name="phone" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label for="">Địa chỉ Email</label>
                <input type="text" name="email" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label for="">Mật khẩu</label>
                <input type="password" name="password" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label for="">Xác nhận mật khẩu</label>
                <input type="password" name="confirm_password" class="form-control">
              </div>
              <div class="form-group">
                <button type="submit" name="register_btn" class="btn btn-primary">Đăng ký</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>