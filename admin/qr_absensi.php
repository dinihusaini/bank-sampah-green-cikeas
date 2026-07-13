<?php
session_start();

include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role']!='admin'){
    header("Location: login.php");
    exit;
}

$cek = mysqli_query($conn,"
SELECT * FROM sesi_absensi
WHERE status='aktif'
ORDER BY id_sesi DESC
LIMIT 1
");

$sesi = mysqli_fetch_assoc($cek);


if($sesi){

$link =
"https://bsgreencikeas.com/admin/proses_absen.php?kode="
.$sesi['kode_qr'];


$qr =
"https://api.qrserver.com/v1/create-qr-code/?size=250x250&data="
.urlencode($link);

}

?>

<!DOCTYPE html>
<html>
<head>

<title>QR Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
        @media (max-width:768px){
        
            body{
                overflow-x:hidden;
            }
        
            .container{
                width:95% !important;
                max-width:95% !important;
            }
        

            .navbar .container{
                flex-direction:column;
                gap:12px;
            }
            
            .navbar .container > div{
                display:flex;
                flex-wrap:wrap;
                justify-content:center;
                gap:6px;
            }
        
            .navbar-brand{
                font-size:16px;
            }
        
            .navbar-brand img{
                width:35px;
                height:35px;
            }
        
            .navbar .btn{
                font-size:12px;
                padding:5px 10px;
            }
        
            .hero-banner{
                height:320px !important;
            }
        
            .hero-banner h1{
                font-size:28px !important;
                line-height:1.3;
            }
        
            .hero-banner p{
                font-size:15px;
                max-width:90%;
            }
            
            .hero-banner .btn{
                font-size:14px;
                padding:8px 18px;
            }
        
            .col-md-3{
                width:50%;
            }
        
            .highlight-card{
                padding:15px !important;
            }
        
            .highlight-card h5{
                font-size:15px;
            }
        
            .col-md-6{
                width:100%;
            }
        
            h2{
                font-size:24px;
            }
        
            p{
                font-size:15px;
            }
        
            .wa-btn{
                width:55px;
                height:55px;
                font-size:22px;
            }
        }
        
        @media(max-width:768px){

            .navbar{
                padding-top:10px !important;
                padding-bottom:10px !important;
            }
        
            .navbar-brand{
                margin-bottom:5px;
            }
        
        }
        
        @media(max-width:768px){

            .navbar{
                padding-bottom:15px !important;
            }
        
            .navbar-brand{
                margin-bottom:0 !important;
            }
        
        }
</style>

</head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body class="bg-light">


<div class="container mt-5">


<div class="card shadow p-5 text-center">

<h3>
ðŸ“· QR Absensi Penimbangan
</h3>

<p class="text-muted">
Silahkan scan QR ini saat kegiatan penimbangan
</p>


<?php if($sesi){ ?>

<img 
src="<?= $qr ?>"
width="250"
class="mx-auto mb-4">


<h5>
Tanggal:
<?= date('d-m-Y', strtotime($sesi['tanggal'])) ?>
</h5>

<a href="tutup_qr.php"
onclick="return confirm('Tutup sesi absensi ini?')"
class="btn btn-danger mb-3">

Tutup Sesi QR

</a>


<?php } else { ?>

<p>
Belum ada QR aktif
</p>


<?php } ?>


<?php if(!$sesi){ ?>

<a href="buat_qr.php"
class="btn btn-primary">

+ Buat QR Baru

</a>

<?php } ?>

<a href="dashboard.php"
class="btn btn-success mt-3">
Kembali
</a>


</div>


</div>


</body>
</html>
