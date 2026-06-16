<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['email_reset'])){
    header("Location: lupa_password.php");
    exit;
}

if(isset($_POST['cek'])){

    $otp = $_POST['otp'];
    $email = $_SESSION['email_reset'];

    $cek = mysqli_query($conn,"
        SELECT * FROM users
        WHERE email='$email'
        AND otp='$otp'
        AND otp_expired >= NOW()
    ");

    if(mysqli_num_rows($cek) > 0){

        header("Location: reset_password.php");
        exit;

    }else{

        echo "
        <script>
        alert('OTP salah atau sudah expired');
        </script>";

    }

}
?>


<!DOCTYPE html>
<html>
<head>

<title>Verifikasi OTP</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
background:linear-gradient(to right,#0c5f24,#98ba7d);
height:100vh;
}

.card{
border-radius:15px;
}

</style>

</head>


<body class="d-flex justify-content-center align-items-center">


<div class="card shadow p-4" style="width:400px">


<h4 class="text-center mb-3">
Verifikasi OTP
</h4>


<p class="text-muted text-center">
Masukkan kode OTP yang dikirim ke email
</p>


<form method="POST">


<input type="number"
name="otp"
class="form-control mb-3"
placeholder="Kode OTP"
required>


<button name="cek"
class="btn btn-success w-100">

Verifikasi

</button>


</form>


</div>


</body>
</html>