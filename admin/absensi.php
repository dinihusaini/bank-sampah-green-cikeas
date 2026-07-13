<?php
include '../config/koneksi.php';

$user = mysqli_query($conn, "
SELECT * FROM absensi
ORDER BY nama_nasabah ASC
");

if(isset($_POST['simpan'])){

    $nama = $_POST['nama_nasabah'];
    $alamat = $_POST['alamat'];
    $no_wa = $_POST['no_wa'];

    mysqli_query($conn, "INSERT INTO absensi VALUES(
        NULL,
        '$nama',
        '$alamat',
        '$no_wa',
        NOW()
    )");


    // ambil bulan hari ini
    $bulanSekarang = date('Y-m');


    echo "
    <script>
        alert('Absensi berhasil disimpan!');
        window.location='absensi.php?bulan=$bulanSekarang';
    </script>
    ";
}

$bulan = $_GET['bulan'] ?? '';

if($bulan != ''){

    $data = mysqli_query($conn,
        "SELECT * FROM absensi
        WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'
        ORDER BY id_nasabah DESC"
    );

}else{

    $data = false;

}
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Absensi Nasabah</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background-color: #f5f7f8;
        }

        .navbar{
            background-color: #0c5f24;
        }

        .form-card,
        .table-card{
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        .title-page{
            font-weight: bold;
            color: #0c5f24;
        }

        .btn-success{
            background: #198754;
            border: none;
        }

        .btn-success:hover{
            background: #146c43;
        }

        table th{
            background: #198754 !important;
            color: white;
        }

        .form-control{
            border-radius: 10px;
        }

        .table{
            border-radius: 12px;
            overflow: hidden;
        }

        @media print {

            body *{
                visibility: hidden;
            }

            .table-card,
            .table-card *{
                visibility: visible;
            }

            .table-card{
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
            }

            .btn,
            .navbar,
            form,
            .title-page,
            .text-muted{
                display: none !important;
            }

            table th{
                background: #198754 !important;
                color: white !important;
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
        <a class="navbar-brand d-flex align-items-center" href="dashboard_nasabah.php">
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
            <i class="bi bi-person-check-fill"></i>
            Absensi Nasabah
        </h2>

        <p class="text-muted">
            Kelola data kehadiran nasabah bank sampah.
        </p>
    </div>

    <div class="form-card mb-5">

        <form method="POST">

            <h5 class="mb-3">
                <i class="bi bi-search"></i>
                Cari Nasabah Terdaftar
            </h5>

            <div class="mb-3">

                <label class="form-label">
                    Pilih Nasabah
                </label>

                <input list="listNasabah"
                    id="pilihNasabah"
                    class="form-control"
                    placeholder="Cari nama nasabah..."
                    autocomplete="off">

                <datalist id="listNasabah">

                    <?php while($u = mysqli_fetch_assoc($user)){ ?>

                    <option 
                        value="<?= $u['nama_nasabah']; ?>"
                        data-alamat="<?= $u['alamat']; ?>"
                        data-wa="<?= $u['no_wa']; ?>">
                    </option>

                    <?php } ?>

                </datalist>

            </div>


            <hr>


            <div class="mb-3">
                <label class="form-label">Nama</label>

                <input type="text"
                    id="nama"
                    name="nama_nasabah"
                    class="form-control"
                    required>
            </div>


            <div class="mb-3">

                <label class="form-label">Alamat</label>

                <input type="text"
                    id="alamat"
                    name="alamat"
                    class="form-control"
                    required>

            </div>


            <div class="mb-3">

                <label class="form-label">No WhatsApp</label>

                <input type="text"
                    id="wa"
                    name="no_wa"
                    class="form-control"
                    required>

            </div>


            <button type="submit"
                    name="simpan"
                    class="btn btn-success">

                <i class="bi bi-save"></i>
                Simpan Absensi

            </button>


            <button type="button"
                    onclick="kosongkan()"
                    class="btn btn-secondary">

                <i class="bi bi-plus-circle"></i>
                Tambah Absensi Baru

            </button>


        </form>

    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">

        <form method="GET" class="d-flex gap-2">

            <input type="month"
                name="bulan"
                class="form-control"
                value="<?= $bulan; ?>">

            <button type="submit" class="btn btn-success">
                <i class="bi bi-funnel"></i> Filter
            </button>

        </form>

        <a href="cetak_absensi.php?bulan=<?= $bulan ?>"
        target="_blank"
        class="btn btn-dark">
        
        <i class="bi bi-printer"></i>
        Print Rekap
        
        </a>

    </div>

    <div class="table-card">

        <h4 class="mb-4 d-flex justify-content-between">

            <span>
                <i class="bi bi-table"></i>
                Data Absensi
            </span>

            <?php if($bulan != ''){ ?>

            <span class="badge bg-success fs-6">
                Total Hadir:
                <?= mysqli_num_rows($data); ?> Orang
            </span>

            <?php } ?>

        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No WA</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php

                $no = 1;

                if($data){

                while($d = mysqli_fetch_array($data)){
                ?>

                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $d['nama_nasabah']; ?></td>
                    <td><?= $d['alamat']; ?></td>
                    <td><?= $d['no_wa']; ?></td>
                    <td><?= date('Y-m-d', strtotime($d['tanggal'])); ?></td>

                    <td class="text-center">

                        <a href="edit_absensi.php?id=<?= $d['id_nasabah']; ?>&back=<?= urlencode($_SERVER['REQUEST_URI']); ?>"
                            class="btn btn-warning btn-sm text-white">

                            <i class="bi bi-pencil-square"></i>

                        </a>

                        <a href="hapus_absensi.php?id=<?= $d['id_nasabah']; ?>&back=<?= urlencode($_SERVER['REQUEST_URI']); ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin mau hapus data ini?')">

                            <i class="bi bi-trash"></i>

                        </a>

                    </td>
                </tr>

                <?php } } else { ?>

                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Silakan pilih bulan terlebih dahulu
                    </td>
                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>



    </div>


</div>

</div>

<script>

let input = document.getElementById("pilihNasabah");

input.addEventListener("input", function(){

    let pilihan = document.querySelectorAll("#listNasabah option");

    pilihan.forEach(function(item){

        if(item.value === input.value){

            document.getElementById("nama").value =
            item.value;


            document.getElementById("alamat").value =
            item.dataset.alamat;


            document.getElementById("wa").value =
            item.dataset.wa;

        }

    });

});


// tombol tambah baru
function kosongkan(){

    document.getElementById("pilihNasabah").value = "";
    document.getElementById("nama").value = "";
    document.getElementById("alamat").value = "";
    document.getElementById("wa").value = "";

    document.getElementById("nama").focus();

}

</script>

</body>
</html>
