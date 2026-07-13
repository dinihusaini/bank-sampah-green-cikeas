<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['simpan'])){
    $id_nasabah = $_POST['id_nasabah'];
    $id_jenis = $_POST['id_jenis'];
    $berat = $_POST['berat'];
    $status = $_POST['status'];
    $tanggal = $_POST['tanggal'];

    $_SESSION['last_nasabah'] = $id_nasabah;
    $_SESSION['last_tanggal'] = $tanggal;

    mysqli_query($conn, "INSERT INTO penimbangan 
    (id_nasabah, id_jenis, berat, status, tanggal)
    VALUES ('$id_nasabah', '$id_jenis', '$berat', '$status', '$tanggal')");

    $bulanSekarang = date('Y-m', strtotime($tanggal));

    echo "
    <script>
    alert('Data berhasil disimpan!');
    window.location='penimbangan.php?bulan=$bulanSekarang';
    </script>
    ";
}

if(isset($_POST['tambah_jenis'])){

    $nama_jenis = $_POST['nama_jenis'];
    $harga_nasabah = $_POST['harga_nasabah'];
    $harga_pengepul = $_POST['harga_pengepul'];

    mysqli_query($conn, "
    INSERT INTO jenis_sampah
    (nama_jenis, harga_per_kg, harga_nasabah, harga_pengepul, gambar)
    VALUES
    (
        '$nama_jenis',
        '$harga_pengepul',
        '$harga_nasabah',
        '$harga_pengepul',
        ''
    )
    ");

    echo "
    <script>
        alert('Jenis sampah berhasil ditambahkan!');
        window.location='penimbangan.php';
    </script>
    ";
}

$search = $_GET['search'] ?? '';
$bulan = $_GET['bulan'] ?? '';

$query = "
SELECT p.*, a.nama_nasabah, j.nama_jenis 
FROM penimbangan p
JOIN absensi a ON p.id_nasabah = a.id_nasabah
JOIN jenis_sampah j ON p.id_jenis = j.id_jenis
WHERE 1=1
";

if($search != ''){
    $query .= " AND a.nama_nasabah LIKE '%$search%'";
}

if($bulan != ''){
    $query .= " AND DATE_FORMAT(p.tanggal, '%Y-%m') = '$bulan'";
}

$query .= " ORDER BY id_penimbangan DESC";

if($search != '' || $bulan != ''){

    $data = mysqli_query($conn, $query);

}else{

    $data = false;

}

$totalBerat = '';

if($bulan != ''){

    $totalQuery = mysqli_query($conn, "
        SELECT SUM(berat) as total_berat
        FROM penimbangan
        WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'
    ");

    $totalData = mysqli_fetch_assoc($totalQuery);

    $totalBerat = number_format($totalData['total_berat'] ?? 0, 2);
}

?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Penimbangan Sampah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>

        body{
            background-color:#f5f7f8;
        }

        .navbar{
            background-color:#0c5f24;
        }

        .form-card,
        .table-card{
            background:white;
            border-radius:18px;
            padding:30px;
            box-shadow:0 4px 15px rgba(0,0,0,0.06);
        }

        .title-page{
            font-weight:bold;
            color:#0c5f24;
        }

        .btn-success{
            background:#198754;
            border:none;
        }

        .btn-success:hover{
            background:#146c43;
        }

        table th{
            background:#198754 !important;
            color:white;
        }

        .form-control,
        .form-select{
            border-radius:10px;
        }

        .table{
            border-radius:12px;
            overflow:hidden;
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
            .form-card,
            .btn,
            form,
            .title-page,
            .text-muted{
                display:none !important;
            }

        }

        .select2-container .select2-selection--single{
            height: 45px !important;
            border-radius: 10px !important;
            border: 1px solid #ced4da !important;
            padding-top: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 9px !important;
        }
        
        .select2-container{
            width:100% !important;
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
            <i class="bi bi-recycle"></i>
            Penimbangan Sampah
        </h2>

        <p class="text-muted">
            Kelola data penimbangan sampah nasabah.
        </p>

    </div>

    <div class="form-card mb-5">

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nasabah</label>

                <select name="id_nasabah" class="form-select select2" required>

                    <option value="">-- Pilih Nasabah --</option>

                    <?php
                    $nasabah = mysqli_query($conn, "SELECT * FROM absensi");

                    while($n = mysqli_fetch_assoc($nasabah)){
                    ?>

                    <option value="<?= $n['id_nasabah']; ?>"
                    <?= (isset($_SESSION['last_nasabah']) && $_SESSION['last_nasabah'] == $n['id_nasabah']) ? 'selected' : ''; ?>>
                        <?= $n['nama_nasabah']; ?>
                    </option>

                    <?php } ?>

                </select>
            </div>

            <div class="mb-3">

                <label class="form-label">
                    Jenis Sampah
                </label>

                <div class="d-flex gap-2">

                    <div style="flex:1;">

                        <select name="id_jenis"
                                class="form-select select2"
                                required>

                            <option value="">
                                -- Pilih Jenis Sampah --
                            </option>


                            <?php
                            $jenis = mysqli_query($conn,
                            "SELECT * FROM jenis_sampah");

                            while($j = mysqli_fetch_assoc($jenis)){
                            ?>

                            <option value="<?= $j['id_jenis']; ?>">
                                <?= $j['nama_jenis']; ?>
                            </option>

                            <?php } ?>


                        </select>

                    </div>


                    <button type="button"
                            class="btn btn-success"
                            style="width:60px; height:45px;"
                            data-bs-toggle="modal"
                            data-bs-target="#modalJenis">

                        <i class="bi bi-plus-lg"></i>

                    </button>


                </div>

            </div>

            <div class="mb-3">
                <label class="form-label">Berat (kg)</label>

                <input type="number"
                       step="0.01"
                       name="berat"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>

                <select name="status" class="form-select">

                    <option value="normal">Normal</option>
                    <option value="gabruk">Gabruk</option>

                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
            
                <input type="date"
                       name="tanggal"
                       class="form-control"
                       value="<?= $_SESSION['last_tanggal'] ?? date('Y-m-d'); ?>"
                       required>
            </div>

            <button name="simpan" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>

        </form>

    </div>

    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">

        <form method="GET" class="d-flex gap-2 flex-wrap">

            <input type="text"
                name="search"
                class="form-control"
                placeholder="Cari nama nasabah..."
                value="<?= $search; ?>">

            <input type="month"
                name="bulan"
                class="form-control"
                value="<?= $bulan; ?>">

            <button type="submit" class="btn btn-success">
                <i class="bi bi-search"></i> Filter
            </button>

        </form>

        <a href="cetak_penimbangan.php?bulan=<?= $bulan ?>&search=<?= $search ?>"
        target="_blank"
        class="btn btn-dark">
        
        <i class="bi bi-printer"></i>
        Print Rekap
        
        </a>

    </div>

    <div class="table-card">

        <h4 class="mb-4 d-flex justify-content-between align-items-center">

            <span>
                <i class="bi bi-table"></i>
                Data Penimbangan
            </span>

            <?php if($bulan != ''){ ?>

            <span class="badge bg-success fs-6">
                Total: <?= $totalBerat; ?> Kg
            </span>

            <?php } ?>

        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Berat</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
                <tbody>

                <?php

                $no = 1;

                if($data){

                while($d = mysqli_fetch_assoc($data)){
                ?>

                <tr>

                    <td class="text-center"><?= $no++; ?></td>

                    <td><?= $d['nama_nasabah']; ?></td>

                    <td><?= $d['nama_jenis']; ?></td>

                    <td><?= $d['berat']; ?> kg</td>

                    <td>
                        <?php if($d['status'] == 'normal'){ ?>

                            <span class="badge bg-success">
                                Normal
                            </span>

                        <?php }else{ ?>

                            <span class="badge bg-danger">
                                Gabruk
                            </span>

                        <?php } ?>
                    </td>

                    <td><?= $d['tanggal']; ?></td>


                    <td class="text-center">
                    
                    <a href="edit_penimbangan.php?id=<?= $d['id_penimbangan']; ?>&back=<?= urlencode($_SERVER['REQUEST_URI']); ?>"
                    class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i>
                    Edit
                    </a>
                    
                    
                    <a href="hapus_penimbangan.php?id=<?= $d['id_penimbangan']; ?>&back=<?= urlencode($_SERVER['REQUEST_URI']); ?>"
                    onclick="return confirm('Hapus data penimbangan ini?')"
                    class="btn btn-danger btn-sm">
                    
                    <i class="bi bi-trash"></i>
                    Hapus
                    
                    </a>
                    
                    
                    </td>
                    
                    
                    </tr>

                <?php } } else { ?>

                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Silakan cari nama atau pilih bulan terlebih dahulu
                    </td>
                </tr>

                <?php } ?>

                </tbody>

            </table>
            
            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {

    $('.select2').select2({
        placeholder: "Pilih data",
        width: '100%'
    });

});
</script>

<div class="modal fade" id="modalJenis">

<div class="modal-dialog">

<div class="modal-content">


<form method="POST">


<div class="modal-header bg-success text-white">

<h5 class="modal-title">
Tambah Jenis Sampah
</h5>


<button type="button"
class="btn-close"
data-bs-dismiss="modal">
</button>


</div>



<div class="modal-body">


<div class="mb-3">

<label class="form-label">
Nama Sampah
</label>

<input type="text"
name="nama_jenis"
class="form-control"
required>

</div>



<div class="mb-3">

<label class="form-label">
Harga Nasabah / Kg
</label>

<input type="number"
name="harga_nasabah"
class="form-control"
required>

</div>



<div class="mb-3">

<label class="form-label">
Harga Pengepul / Kg
</label>

<input type="number"
name="harga_pengepul"
class="form-control"
required>

</div>



</div>



<div class="modal-footer">


<button class="btn btn-success"
        name="tambah_jenis">

<i class="bi bi-save"></i>
Simpan

</button>


</div>


</form>


</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
