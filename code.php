<?php
session_start();
include("dbcon.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";
function sendemail_verify($name, $email, $verify_token)
{
  try {
    $db = new PDO("mysql:host=localhost;dbname=PHPMailer", "root", "");

    $sql = "INSERT INTO track(recipient, create_dt)
            VALUE (:rerecipient, :create_dt)";
    $stmt = $db->prepare($sql);
    $recipient = $email;
    $create_dt = new DateTimeImmutable('now');
    $stmt->execute([
      ':rerecipient'=> $recipient,
      ':create_dt'=> $create_dt ->format('Y-m-d H:i:s'),
    ]);

    $email_id = $db ->lastInsertId();
  } catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
  }

  $body_html = sprintf("<img src='http://localhost/PHPMailer/logo.php?email_id=%s&create_tmsp=%s' alt='logo'>",
                $email_id, $create_dt->getTimestamp());
  $mail = new PHPMailer();
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';               // Máy chủ SMTP của Gmail
  $mail->SMTPAuth = true;
  $mail->Username = 'thanhnamak@gmail.com';      // Địa chỉ Gmail của bạn
  $mail->Password = 'vjkbsvlcaqgpagst';         // App Password đã tạo
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;                             // Cổng TLS

  $mail->setFrom('thanhnamak@gmail.com', 'Nam');   // Địa chỉ gửi đi
  $mail->addAddress($email);
  $mail->isHTML(true);
  $mail->Subject = 'Email Verification';
  $email_template = "
    $body_html
    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;'>
            <tr>
                <td style='background-color: #4CAF50; padding: 20px; text-align: center;'>
                    <h1 style='color: #ffffff; margin: 0;'>Chào mừng bạn!</h1>
                </td>
            </tr>
            <tr>
                <td style='padding: 20px;'>
                    <h2 style='color: #4CAF50;'>Xin chào $name,</h2>
                    <p>Bạn đã thực hiện đăng ký tài khoản trên trang của chúng tôi.</p>
                    <p>Nếu đây là hành động của bạn, vui lòng bấm vào nút bên dưới để xác nhận email và hoàn thành quá trình đăng ký:</p>
                    <div style='text-align: center; margin: 20px 0;'>
                        <a href='http://localhost/PHPMailer/verify_email.php?token=$verify_token' style='display: inline-block; padding: 12px 20px; color: #ffffff; background-color: #4CAF50; text-decoration: none; border-radius: 5px; font-weight: bold;'>Xác nhận Email</a>
                    </div>
                    <p style='font-size: 14px; color: #555;'>Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email này. Liên hệ với chúng tôi nếu bạn cần hỗ trợ.</p>
                    <p>Trân trọng,<br>Đội ngũ Hỗ trợ</p>
                </td>
            </tr>
            <tr>
                <td style='background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #888;'>
                    <p>&copy; 2024 Lập trình PHP. Nhóm 6</p>
                </td>
            </tr>
        </table>
    </div>
";

  $mail->Body = $email_template;

  if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  };
}

if (isset($_POST["register_btn"])) {
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $verify_token = md5(rand());

  // Kiểm tra các trường có được nhập đầy đủ hay không
  if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['status'] = "Vui lòng điền đầy đủ tất cả các trường.";
    header("Location: register.php");
    exit();
  }

  // Kiểm tra confirm_password có trùng khớp với password không
  if ($password !== $confirm_password) {
    $_SESSION['status'] = "Mật khẩu xác nhận không khớp.";
    header("Location: register.php");
    exit();
  }

  //check email ton tai
  $check_email_query = "SELECT email FROM users WHERE email = '$email'";
  $check_email_query_run = mysqli_query($conn, $check_email_query);

  if (mysqli_num_rows($check_email_query_run) > 0) {
    $_SESSION['status'] = 'Email này đã đăng ký cho tài khoản khác';
    header('Location: register.php');
    exit();
  } else {
    //insert user
    $password_hashed = md5($password);
    $query = "INSERT INTO users(name, phone, email, password, verify_token)
                VALUE ('$name', '$phone', '$email', '$password_hashed', '$verify_token')";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
      sendemail_verify($name, $email, $verify_token);
      $_SESSION['status'] = "Sắp xong rồi! Hãy vào hộp thư của bạn để mở link xác nhận Email.";
      header("Location: login.php");
      exit();
    } else {
      $_SESSION['status'] = "Đăng ký thất bại";
      header("Location: register.php");
      exit();
    }
  }
}
