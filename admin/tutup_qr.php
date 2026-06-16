<?php
session_start();

include '../config/koneksi.php';


if(
!isset($_SESSION['login'])
|| $_SESSION['role']!='admin'
){

header("Location: login.php");
exit;

}


mysqli_query($conn,"
UPDATE sesi_absensi
SET status='selesai'
WHERE status='aktif'
");


header("Location: qr_absensi.php");
exit;


?>