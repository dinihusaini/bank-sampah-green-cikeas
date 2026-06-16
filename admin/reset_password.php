<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['email_reset'])){
    header("Location: lupa_password.php");
    exit;
}


if(isset($_POST['reset'])){

    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    if($password != $konfirmasi){

        echo "
        <script>
        alert('Konfirmasi password tidak sama');
        </script>";

    }else{


        $email = $_SESSION['email_reset'];


        mysqli_query($conn,"
            UPDATE users SET
            password_users='$password',
            otp=NULL,
            otp_expired=NULL
            WHERE email='$email'
        ");


        unset($_SESSION['email_reset']);


        echo "
        <script>
        alert('Password berhasil diganti');
        window.location='login.php';
        </script>";

    }

}

?>


<!DOCTYPE html>
<html>
<head>

<title>Password Baru</title>


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


<div class="card shadow p-4"
style="width:400px">


<h4 class="text-center mb-3">
Buat Password Baru
</h4>


<form method="POST">


<input type="password"
name="password"
class="form-control mb-3"
placeholder="Password baru"
required>


<input type="password"
name="konfirmasi"
class="form-control mb-3"
placeholder="Konfirmasi password"
required>


<button name="reset"
class="btn btn-success w-100">

Simpan Password

</button>


</form>


</div>


</body>
</html>