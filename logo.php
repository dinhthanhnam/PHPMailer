<?php
include("dbcon.php");

date_default_timezone_set('Asia/Ho_Chi_Minh');
try {
    if (isset($_REQUEST['email_id']) && isset($_REQUEST['create_tmsp'])) {
        $email_id = $_REQUEST['email_id'];
        $create_tmsp = $_REQUEST['create_tmsp'];
        $create_dt = (new DateTimeImmutable) ->setTimestamp($create_tmsp);
        $db = new PDO("mysql:host=localhost;dbname=PHPMailer", "root", "");
        $read_dt = new DateTimeImmutable('now');
        $sql = "UPDATE track SET read_dt = :read_dt 
                WHERE id = :email_id and create_dt = :create_dt and read_dt is null";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':read_dt'=> $read_dt->format('Y-m-d H:i:s'),
            ':email_id'=> $email_id,
            ':create_dt'=>$create_dt->format('Y-m-d H:i:s')
        ]);
    }
} catch (PDOException $e) {
    // Xử lý lỗi nếu kết nối thất bại
    echo "Lỗi kết nối: " . $e->getMessage();
}

$file = './logo.png';
header('Content-Type: image/png');
header('Content-Length: '.filesize($file));
readfile($file);
exit;

