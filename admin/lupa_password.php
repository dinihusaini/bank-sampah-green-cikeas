<?php
session_start();
include '../config/koneksi.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';


if(isset($_POST['kirim'])){

    $email = $_POST['email'];

    $cek = mysqli_query($conn,
    "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($cek) > 0){

        $otp = rand(100000,999999);

        $expired = date(
            "Y-m-d H:i:s",
            strtotime("+5 minutes")
        );

        mysqli_query($conn,
        "UPDATE users SET
        otp='$otp',
        otp_expired='$expired'
        WHERE email='$email'");


        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;


            $mail->Username = 'banksampahgreencikeas@gmail.com';
            $mail->Password = 'yifz ephr qyzm uytp';


            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;


            $mail->setFrom(
                'banksampahgreencikeas@gmail.com',
                'Bank Sampah Green Cikeas'
            );


            $mail->addAddress($email);

            $mail->Subject =
            'Kode OTP Reset Password';


            $mail->Body =
            "Kode OTP Anda adalah: ".$otp;


            $mail->send();


            $_SESSION['email_reset'] = $email;


            header(
            "Location: verifikasi_otp.php"
            );
            exit;


        }catch(Exception $e){

            echo "Email gagal dikirim";

        }


    }else{

        echo "
        <script>
        alert('Email tidak ditemukan');
        </script>";

    }

}

?>


<!DOCTYPE html>
<html>
<head>

<title>Lupa Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>


<body class="d-flex justify-content-center align-items-center vh-100">


<div class="card p-4 shadow"
style="width:400px">


<h4 class="text-center">
Lupa Password
</h4>


<form method="POST">


<input type="email"
name="email"
class="form-control mb-3"
placeholder="Email terdaftar"
required>


<button name="kirim"
class="btn btn-success w-100">

Kirim OTP

</button>


</form>


</div>


</body>
</html>
