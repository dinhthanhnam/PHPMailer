<?php
$page_title = "Đăng nhập";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow">
          <div class="card-header">
            <h5>Form Đăng nhập</h5>
          </div>
          <div class="card-body">
            <form action="">
              <div class="form-group mb-3">
                <label for="">Địa chỉ Email</label>
                <input type="text" name="email" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label for="">Mật khẩu</label>
                <input type="password" name="password" class="form-control">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>