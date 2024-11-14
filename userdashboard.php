<?php
  include('authentication.php');
  $page_title = "User Dashboard";
  include('includes/header.php');
  include('includes/navbar.php');
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
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
            <h5>User Dashboard</h5>
          </div>
          <div class="card-body">
            <h4>Thông tin tài khoản</h4>
            <hr>
            <h5>Username: <?= $_SESSION['auth_user']['username']?> </h5>
            <h5>Email: <?= $_SESSION['auth_user']['email']?> </h5>
            <h5>Số điện thoại: <?= $_SESSION['auth_user']['phone']?> </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>