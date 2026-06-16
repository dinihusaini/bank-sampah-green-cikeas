<?php
session_start();
include '../config/koneksi.php';


if(
!isset($_SESSION['login']) 
|| $_SESSION['role']!='nasabah'
){

    header("Location: login.php");
    exit;

}


$nama = $_SESSION['nama'];


// cari id nasabah
$q = mysqli_query($conn,"
SELECT * FROM absensi
WHERE nama_nasabah='$nama'
");


$d = mysqli_fetch_assoc($q);


if(!$d){

    echo "
    <script>
    alert('Data nasabah tidak ditemukan');
    window.location='dashboard_nasabah.php';
    </script>";

    exit;
}


$id_nasabah = $d['id_nasabah'];

$bulan = date('m');
$tahun = date('Y');


// cek sudah absen bulan ini
$cek = mysqli_query($conn,"
SELECT * FROM kehadiran_penimbangan
WHERE id_nasabah='$id_nasabah'
AND MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
");


if(mysqli_num_rows($cek)>0){

    echo "
    <script>
    alert('Kamu sudah absen bulan ini 😊');
    window.location='dashboard_nasabah.php';
    </script>";

    exit;
}


// insert absen

mysqli_query($conn,"
INSERT INTO kehadiran_penimbangan
(
id_nasabah,
tanggal,
jam
)

VALUES

(
'$id_nasabah',
CURDATE(),
CURTIME()
)
");


echo "
<script>
alert('Absensi berhasil, selamat menimbang sampah ♻️');
window.location='dashboard_nasabah.php';
</script>";

?>