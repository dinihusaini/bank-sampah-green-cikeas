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


// nonaktifkan qr lama
mysqli_query($conn,"
UPDATE sesi_absensi 
SET status='selesai'
WHERE status='aktif'
");


// kode unik QR
$kode = "BS".date("YmdHis");


// buat sesi baru
mysqli_query($conn,"
INSERT INTO sesi_absensi
(tanggal,kode_qr,status)
VALUES
(CURDATE(),'$kode','aktif')
");


header("Location: qr_absensi.php");
exit;

?>