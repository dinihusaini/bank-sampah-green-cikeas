<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn,
"SELECT * FROM absensi 
WHERE nama_nasabah NOT IN ('Panitia','admin BS')
ORDER BY id_nasabah DESC"
);

?>

<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Daftar Nasabah</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


<style>

body{
    background:#f5f7f8;
}

.navbar{
    background:#0c5f24;
}

.header-box{
    background:linear-gradient(135deg,#0c5f24,#198754);
    padding:30px;
    color:white;
    border-radius:20px;
    box-shadow:0 5px 18px rgba(0,0,0,0.1);
}


.content-card{
    background:white;
    border-radius:18px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}


.table thead th{
    background:#0c5f24;
    color:white;
}

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
        
        .table{
            min-width:850px;
        }
        
        .table td,
        .table th{
            vertical-align:middle;
            white-space:nowrap;
        }
        
        @media(max-width:768px){
        
            .content-card{
                padding:15px;
            }
        
            .header-box{
                padding:20px;
            }
        
            .header-box h2{
                font-size:24px;
            }
        
            .btn{
                margin-bottom:5px;
            }
        
        }

</style>


</head>


<body>


<nav class="navbar navbar-dark">

<div class="container">


<a class="navbar-brand fw-bold d-flex align-items-center">

<img src="../assets/logobs.png"
width="40"
class="me-2">

Admin Bank Sampah

</a>


<div class="text-white">

<i class="bi bi-person-circle"></i>

<?= $_SESSION['nama']; ?>

</div>


</div>

</nav>



<div class="container mt-4">


<div class="header-box mb-4">

<h2 class="fw-bold">

<i class="bi bi-person-lines-fill"></i>

Daftar Nasabah

</h2>


<p class="mb-0">

Kelola data nasabah Bank Sampah Green Cikeas

</p>


</div>




<div class="content-card">


<a href="dashboard.php"
class="btn btn-success mb-3">

<i class="bi bi-arrow-left"></i>

Kembali

</a>

<a href="tambah_nasabah.php"
class="btn btn-primary mb-3">

<i class="bi bi-plus-circle"></i>

Tambah Nasabah

</a>

<a href="cetak_nasabah.php"
target="_blank"
class="btn btn-danger mb-3">

<i class="bi bi-file-earmark-pdf"></i>

Cetak PDF

</a>





<div class="table-responsive">

<table class="table table-hover align-middle">


<thead>

<tr>

<th>No</th>

<th>Nama</th>

<th>Alamat</th>

<th>No WA</th>

<th>Tanggal Daftar</th>

<th class="text-center">
Aksi
</th>


</tr>

</thead>



<tbody>


<?php

$no=1;

while($d=mysqli_fetch_assoc($data)){

?>


<tr>


<td>

<?= $no++ ?>

</td>



<td>

<b>

<?= $d['nama_nasabah']; ?>

</b>

</td>




<td>

<?= $d['alamat']; ?>

</td>



<td>

<?= $d['no_wa']; ?>

</td>



<td>

<?= date('d-m-Y', strtotime($d['tanggal'])); ?>

</td>




<td class="text-center">


<a href="edit_nasabah.php?id=<?= $d['id_nasabah']; ?>"
class="btn btn-warning btn-sm">


<i class="bi bi-pencil"></i>

Edit


</a>




<a onclick="return confirm('Hapus nasabah ini?')"
href="hapus_nasabah.php?id=<?= $d['id_nasabah']; ?>"
class="btn btn-danger btn-sm">


<i class="bi bi-trash"></i>

Hapus


</a>



</td>


</tr>



<?php } ?>


</tbody>


</table>

</div>



</div>


</div>



</body>

</html>
