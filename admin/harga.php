<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

// UPDATE HARGA
if(isset($_POST['update'])){

    $id = $_POST['id_jenis'];
    $harga_nasabah = $_POST['harga_nasabah'];
    $harga_pengepul = $_POST['harga_pengepul'];

    mysqli_query($conn, "UPDATE jenis_sampah 
    SET 
    harga_nasabah='$harga_nasabah',
    harga_pengepul='$harga_pengepul'
    WHERE id_jenis='$id'");

    echo "
    <script>
        alert('Harga berhasil diupdate!');
        window.location='harga.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Setting Harga Sampah</title>

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

        .form-control{
            border-radius:10px;
        }

        .table{
            border-radius:12px;
            overflow:hidden;
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
            <i class="bi bi-cash-coin"></i>
            Setting Harga Sampah
        </h2>

        <p class="text-muted">
            Kelola harga nasabah dan harga pengepul untuk setiap jenis sampah.
        </p>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <h4 class="mb-4">
            <i class="bi bi-table"></i>
            Data Harga Sampah
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Jenis Sampah</th>
                        <th>Harga Nasabah / Kg</th>
                        <th>Harga Pengepul / Kg</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $data = mysqli_query($conn, "SELECT * FROM jenis_sampah");

                $no = 1;

                while($d = mysqli_fetch_assoc($data)){
                ?>

                <tr>

                    <form method="POST">

                        <td class="text-center">
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= $d['nama_jenis']; ?>
                        </td>

                        <td width="300">

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input type="number"
                                        name="harga_nasabah"
                                        class="form-control"
                                        value="<?= $d['harga_nasabah']; ?>"
                                        required>

                            </div>

                        </td>

                        <td width="300">

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input type="number"
                                        name="harga_pengepul"
                                        class="form-control"
                                        value="<?= $d['harga_pengepul']; ?>"
                                        required>

                            </div>

                        </td>

                        <td class="text-center">

                            <input type="hidden"
                                   name="id_jenis"
                                   value="<?= $d['id_jenis']; ?>">

                            <button name="update"
                                    class="btn btn-success btn-sm">

                                <i class="bi bi-save"></i>
                                Simpan

                            </button>

                        </td>

                    </form>

                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>