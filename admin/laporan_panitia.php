<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

// FILTER
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// QUERY FILTER
$filter_bulan = '';

$id_admin_bs = 12;

if($bulan != ''){
    $filter_bulan = "AND DATE_FORMAT(p.tanggal, '%m') = '$bulan'";
}

// PEMASUKAN (PENGEPUL DARI NASABAH SAJA)
$pemasukan = mysqli_query($conn, "
SELECT 
    SUM(p.berat * j.harga_per_kg) as total

FROM penimbangan p

JOIN jenis_sampah j 
ON p.id_jenis = j.id_jenis

JOIN absensi a
ON p.id_nasabah = a.id_nasabah

WHERE DATE_FORMAT(p.tanggal, '%Y') = '$tahun'
$filter_bulan

AND p.id_nasabah != '$id_admin_bs'
");

$p = mysqli_fetch_assoc($pemasukan);

$total_pemasukan = $p['total'];

// TABUNGAN NASABAH (selain Panitia)
$pengeluaran = mysqli_query($conn, "
SELECT 
    SUM(p.berat * j.harga_nasabah) as total

FROM penimbangan p

JOIN jenis_sampah j 
ON p.id_jenis = j.id_jenis

JOIN absensi a
ON p.id_nasabah = a.id_nasabah

WHERE DATE_FORMAT(p.tanggal, '%Y') = '$tahun'
$filter_bulan

AND p.id_nasabah != '$id_admin_bs'
");

$e = mysqli_fetch_assoc($pengeluaran);

$total_pengeluaran = $e['total'];


// TABUNGAN GABRUK (Panitia)
$gabruk = mysqli_query($conn, "
SELECT 
    SUM(p.berat * j.harga_per_kg) as total

FROM penimbangan p

JOIN jenis_sampah j 
ON p.id_jenis = j.id_jenis

JOIN absensi a
ON p.id_nasabah = a.id_nasabah

WHERE DATE_FORMAT(p.tanggal, '%Y') = '$tahun'
$filter_bulan

AND p.id_nasabah = '$id_admin_bs'
");

$g = mysqli_fetch_assoc($gabruk);

$total_gabruk = $g['total'];


// JIKA NULL JADI 0
$total_pemasukan = $total_pemasukan ?? 0;
$total_pengeluaran = $total_pengeluaran ?? 0;
$total_gabruk = $total_gabruk ?? 0;


// KEUNTUNGAN PANITIA
$keuntungan = $total_pemasukan - $total_pengeluaran;


// ARRAY BULAN
$bulanIndo = [
    1=>'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
];
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Laporan Panitia</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        body{
            background-color:#f5f7f8;
        }

        .navbar{
            background-color:#0c5f24;
        }

        .table-card,
        .filter-card{
            background:white;
            border-radius:18px;
            padding:30px;
            box-shadow:0 4px 15px rgba(0,0,0,0.06);
        }

        .title-page{
            font-weight:bold;
            color:#0c5f24;
        }

        table th{
            background:#198754 !important;
            color:white;
        }

        .table{
            border-radius:12px;
            overflow:hidden;
        }

        .btn-success{
            background:#198754;
            border:none;
        }

        .btn-success:hover{
            background:#146c43;
        }

        .form-select{
            border-radius:10px;
        }
        
        /* ===== RESPONSIVE HP ===== */
        @media (max-width:768px){
        
            body{
                overflow-x:hidden;
            }
        
            .container{
                width:95% !important;
                max-width:95% !important;
            }
        
        
            /* NAVBAR */
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
        
        
            /* HERO */
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
        
        
            /* CARD ANGKA */
            .col-md-3{
                width:50%;
            }
        
            .highlight-card{
                padding:15px !important;
            }
        
            .highlight-card h5{
                font-size:15px;
            }
        
        
            /* VISI MISI */
            .col-md-6{
                width:100%;
            }
        
        
            /* TEXT */
            h2{
                font-size:24px;
            }
        
            p{
                font-size:15px;
            }
        
        
            /* tombol WA */
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

<!-- NAVBAR -->
<nav class="navbar navbar-dark">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../assets/logobs.png" width="40" class="me-2">
            Bank Sampah Green Cikeas
        </a>

        <!-- BACK -->
        <a href="dashboard.php" class="btn btn-outline-light">
            <i class="bi bi-arrow-left"></i> Back
        </a>

    </div>
</nav>

<div class="container mt-4">

    <!-- JUDUL -->
    <div class="mb-4">

        <h2 class="title-page">
            <i class="bi bi-cash-stack"></i>
            Laporan Panitia
        </h2>

        <p class="text-muted">
            Laporan keuntungan panitia berdasarkan periode bulan dan tahun.
        </p>

    </div>

    <!-- FILTER -->
    <div class="filter-card mb-4">

        <form method="GET" class="row g-3 align-items-end">

            <!-- BULAN -->
            <div class="col-md-4">

                <label class="form-label">
                    Pilih Bulan
                </label>

                <select name="bulan" class="form-select">

                    <option value="">
                        Semua Bulan
                    </option>

                    <?php
                    for($i=1; $i<=12; $i++){

                        $bln = str_pad($i, 2, "0", STR_PAD_LEFT);
                    ?>

                    <option value="<?= $bln; ?>"
                        <?= ($bulan == $bln) ? 'selected' : ''; ?>>

                        <?= $bulanIndo[$i]; ?>

                    </option>

                    <?php } ?>

                </select>

            </div>

            <!-- TAHUN -->
            <div class="col-md-3">

                <label class="form-label">
                    Tahun
                </label>

                <select name="tahun" class="form-select">

                    <?php
                    for($t=2024; $t<=2030; $t++){
                    ?>

                    <option value="<?= $t; ?>"
                        <?= ($tahun == $t) ? 'selected' : ''; ?>>

                        <?= $t; ?>

                    </option>

                    <?php } ?>

                </select>

            </div>

            <!-- BUTTON -->
            <div class="col-md-5">

                <button type="submit" class="btn btn-success">

                    <i class="bi bi-funnel"></i>
                    Filter

                </button>

            </div>

        </form>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <h4 class="mb-4">
            <i class="bi bi-table"></i>
            Ringkasan Keuangan
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="text-center">

                    <tr>
                        <th>Keterangan</th>
                        <th>Total</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>
                            Pemasukan dari Pengepul
                        </td>

                        <td>
                            Rp <?= number_format($total_pemasukan, 0, ',', '.'); ?>
                        </td>

                    </tr>

                    <tr>

                        <td>
                            Tabungan Nasabah
                        </td>

                        <td>
                            Rp <?= number_format($total_pengeluaran, 0, ',', '.'); ?>
                        </td>

                    </tr>

                    <tr class="table-success fw-bold">

                        <td>
                            Keuntungan Panitia
                        </td>

                        <td>
                            Rp <?= number_format($keuntungan, 0, ',', '.'); ?>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    <!-- TABLE GABRUK -->
    <div class="table-card mt-4">

        <h4 class="mb-4">
            <i class="bi bi-recycle"></i>
            Tabungan Gabruk
        </h4>


        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="text-center">
                    <tr>
                        <th>Keterangan</th>
                        <th>Total</th>
                    </tr>
                </thead>


                <tbody>

                    <tr>

                        <td>
                            Sampah Gabruk (Milik Panitia)
                        </td>


                        <td>
                            Rp <?= number_format($total_gabruk,0,',','.'); ?>
                        </td>

                    </tr>

                </tbody>


            </table>

        </div>

    </div>


</div>

</body>
</html>