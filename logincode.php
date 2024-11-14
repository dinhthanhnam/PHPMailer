<?php
session_start();
include('dbcon.php'); // Kết nối với database

// Kiểm tra nếu form đã được submit
if(isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Mã hóa mật khẩu
    $hashed_password = md5($password);

    // Truy vấn để kiểm tra thông tin đăng nhập
    $login_query = "SELECT * FROM users WHERE email='$email' AND password='$hashed_password'";
    $login_query_run = mysqli_query($conn, $login_query);

    // Kiểm tra kết quả truy vấn
    if(mysqli_num_rows($login_query_run) > 0) {
        // Nếu đăng nhập thành công, lấy thông tin người dùng
        $row = mysqli_fetch_array($login_query_run);
        
        // Kiểm tra verify_status để xác nhận tài khoản đã được xác minh chưa
        if($row['verify_status'] == 1) {
            $_SESSION['authenticated'] = TRUE;
            $_SESSION['auth_user'] = [
              'username' => $row['name'],
              'phone' => $row['phone'],
              'email' => $row['email'],
            ];
            $_SESSION['status'] = 'Đăng nhập thành công.';
            header('Location: userdashboard.php');
            exit();
        } else {
            $_SESSION['status'] = 'Tài khoản chưa được xác minh. Vui lòng kiểm tra email.';
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['status'] = 'Đăng nhập thất bại, kiểm tra lại thông tin đăng nhập';
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['status'] = 'Vui lòng nhập đầy đủ thông tin';
    header('Location: login.php');
    exit();
}
?>
