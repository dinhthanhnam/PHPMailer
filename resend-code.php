<?php

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
session_start();
include('dbcon.php');

function  resend_email_verify($name, $email, $verify_token)
{
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
    $mail->Subject = 'Resend Email Verification';
    $email_template = "
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

if(isset($_POST['resend_email_verify_btn'])){

    if(!empty(trim($_POST['email'])))
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $checkemail_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $check_email_query_run = mysqli_query($conn, $checkemail_query);
        if(mysqli_num_rows($check_email_query_run) > 0)
        {
           $row = mysqli_fetch_array($check_email_query_run);
            if($row['verify_status'] == '0')
           {
                $name = $row['name'];
                $email = $row['email'];
                $verify_token = $row['verify_token'];
                
                resend_email_verify($name, $email, $verify_token);

                $_SESSION['status'] = "Email xác minh đã được gửi cho bạn!";
                header("Location: login.php");
                exit(0);
           }
           else
           {
                $_SESSION['status'] = "Email đã được xác minh, vui lòng đăng nhập!";
                header("Location: login.php");
                exit(0);
           }
            
        }
        else
        {
            $_SESSION['status'] = "Email chưa được đăng ký, vui lòng đăng ký!";
            header("Location: register.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "Vui lòng nhập Email";
        header("Location: resend_email_verication.php");
        exit(0);
    }
}
?>