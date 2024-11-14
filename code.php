<?php 
    session_start();
    include("dbcon.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require "vendor/autoload.php";
    function sendemail_verify($name, $email, $verify_token) {
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
        $mail->Subject = 'Test Email Verify';
        $email_template = "
            <h2>Bạn đã thực hiện đăng ký trên trang của chúng mình</h2>
            <h5>Nếu đây là hành động của bạn, vui lòng bấm xác nhận ở dưới để hoàn thành quá trình đăng ký</h5>
            <br>
            <a href='http://localhost/PHPMailer/verify_email.php?token=$verify_token'>Xác nhận</a>
        ";
        $mail->Body = $email_template;
    
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    if(isset($_POST["register_btn"]))
    {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $verify_token = md5(rand());

        sendemail_verify($name, $email, $verify_token);
        echo "sent or not";
        // //check email ton tai
        // $check_email_query = "SELECT email FROM users WHERE email = '$email'";
        // $check_email_query_run = mysqli_query($conn, $check_email_query);

        // if(mysqli_num_rows($check_email_query_run) > 0) {
        //     $_SESSION['status'] = 'Email này đã đăng ký cho tài khoản khác';
        //     header('Location: register.php');
        // } else {
        //     //insert user
        //     $password_hashed = md5($password);
        //     $query = "INSERT INTO users(name, phone, email, password, verify_token)
        //         VALUE ('$name', '$phone', '$email', '$password_hashed', '$verify_token')";
        //     $query_run = mysqli_query($conn, $query);
        //     if($query_run) {
        //         sendemail_verify($name, $email, $verify_token);
        //         $_SESSION['status'] = "Sắp xong rồi! Hãy vào hộp thư của bạn để mở link xác nhận Email.";
        //         header("Location: login.php");
        //     } else  {
        //         $_SESSION["status"] = "Đăng ký thất bại";
        //         header("Location: register.php");
        //     }
        // }
    }

