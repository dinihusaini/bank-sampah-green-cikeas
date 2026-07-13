<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$bulanIndo = [
    1=>'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
];
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Laporan Tabungan Nasabah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

        @media print {

            body *{
                visibility:hidden;
            }

            .table-card,
            .table-card *{
                visibility:visible;
            }

            .table-card{
                position:absolute;
                top:0;
                left:0;
                width:100%;
                box-shadow:none;
            }

            .navbar,
            .filter-card,
            .btn,
            .title-page,
            .text-muted{
                display:none !important;
            }

            table th{
                background:#198754 !important;
                color:white !important;
                -webkit-print-color-adjust: exact;
            }

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

        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../assets/logobs.png" width="40" class="me-2">
            Bank Sampah Green Cikeas
        </a>

        <a href="dashboard.php" class="btn btn-outline-light">
            <i class="bi bi-arrow-left"></i> Back
        </a>

    </div>
</nav>

<div class="container mt-4">

    <div class="mb-4">

        <h2 class="title-page">
            <i class="bi bi-wallet2"></i>
            Laporan Tabungan Nasabah
        </h2>

        <p class="text-muted">
            Laporan total tabungan sampah nasabah per bulan dan per tahun.
        </p>

    </div>

    <div class="filter-card mb-4">

        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-4">

                <label class="form-label">
                    Pilih Nasabah
                </label>

                <select name="id_nasabah" class="form-select" required>

                    <option value="">
                        -- Pilih Nasabah --
                    </option>

                    <?php
                    $nasabah = mysqli_query($conn, "SELECT * FROM absensi");

                    while($n = mysqli_fetch_assoc($nasabah)){
                    ?>

                    <option value="<?= $n['id_nasabah']; ?>"
                        <?= (isset($_GET['id_nasabah']) && $_GET['id_nasabah'] == $n['id_nasabah']) ? 'selected' : ''; ?>>

                        <?= $n['nama_nasabah']; ?>

                    </option>

                    <?php } ?>

                </select>

            </div>

            <div class="col-md-3">

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

            <div class="col-md-2">

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

            <div class="col-md-3">

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-search"></i>
                    Lihat Laporan
                </button>

            </div>

        </form>

    </div>

<?php
if(isset($_GET['id_nasabah'])){

    $id = $_GET['id_nasabah'];

    $nasabah_nama = mysqli_query($conn, "
    SELECT nama_nasabah 
    FROM absensi 
    WHERE id_nasabah='$id'
    ");

    $n_nama = mysqli_fetch_assoc($nasabah_nama);

    $filter_bulan = '';

    if($bulan != ''){
        $filter_bulan = "AND DATE_FORMAT(p.tanggal, '%m') = '$bulan'";
    }

    $data = mysqli_query($conn, "
    SELECT 
        j.nama_jenis,
        j.harga_nasabah,
        SUM(p.berat) as total_kg,
        SUM(p.berat * j.harga_nasabah) as total_uang

    FROM penimbangan p

    JOIN jenis_sampah j 
    ON p.id_jenis = j.id_jenis

    WHERE p.id_nasabah = '$id'
    AND DATE_FORMAT(p.tanggal, '%Y') = '$tahun'
    $filter_bulan

    GROUP BY p.id_jenis

    ORDER BY j.nama_jenis ASC
    ");
?>

    <div class="table-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4 class="mb-0">
                <i class="bi bi-table"></i>
                Detail Tabungan - <?= $n_nama['nama_nasabah']; ?>
            </h4>

            <button onclick="window.print()" class="btn btn-dark">

                <i class="bi bi-printer"></i>
                Cetak Laporan

            </button>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Jenis Sampah</th>
                        <th>Total Kg</th>
                        <th>Harga / Kg</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;
                $grand_total = 0;
                $total_semua_kg = 0;

                while($d = mysqli_fetch_assoc($data)){

                    $grand_total += $d['total_uang'];
                    $total_semua_kg += $d['total_kg'];
                ?>

                <tr>

                    <td class="text-center">
                        <?= $no++; ?>
                    </td>

                    <td>
                        <?= $d['nama_jenis']; ?>
                    </td>

                    <td>
                        <?= number_format($d['total_kg'],2); ?> kg
                    </td>

                    <td>
                        Rp <?= number_format($d['harga_nasabah'], 0, ',', '.'); ?>
                    </td>

                    <td>
                        Rp <?= number_format($d['total_uang'], 0, ',', '.'); ?>
                    </td>

                </tr>

                <?php } ?>

                <tr class="table-success fw-bold">

                    <td colspan="2" class="text-end">
                        Total Semua Kg
                    </td>

                    <td>
                        <?= number_format($total_semua_kg,2); ?> kg
                    </td>

                    <td class="text-end">
                        Total Saldo
                    </td>

                    <td>
                        Rp <?= number_format($grand_total, 0, ',', '.'); ?>
                    </td>

                </tr>

                </tbody>

            </table>

        </div>

    </div>

<?php } ?>

</div>

</body>
</html>
