<?php
session_start();

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background: #f5f7f8;
        }

        .navbar{
            background: #0c5f24;
        }

        .welcome-box{
            background: linear-gradient(135deg, #0c5f24, #198754);
            color: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .menu-card{
            background: white;
            border-radius: 18px;
            padding: 30px 20px;
            text-align: center;
            transition: 0.3s;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        .menu-card:hover{
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .menu-card i{
            font-size: 45px;
            color: #198754;
            margin-bottom: 15px;
        }

        .menu-card h5{
            color: #333;
            font-weight: 600;
        }

        a{
            text-decoration: none;
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
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">

            <img src="../assets/logobs.png"
                width="38"
                height="38"
                class="me-2"
                style="object-fit:cover;">

            Admin Bank Sampah

        </a>
        
        <div class="d-flex align-items-center gap-3">
            <div class="text-white">
                <i class="bi bi-person-circle"></i>
                <?= $_SESSION['nama']; ?>
            </div>

            <a href="logout.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- WELCOME -->
    <div class="welcome-box mb-5">
        <h1 class="fw-bold">Dashboard Admin</h1>
        <p class="mb-0">
            Selamat datang kembali 👋 Kelola data bank sampah dengan mudah dan cepat.
        </p>
    </div>

    <!-- MENU -->
    <div class="row g-4">
        
        <div class="col-md-4">
            <a href="daftar_nasabah.php">
                <div class="menu-card">
                    <i class="bi bi-person-lines-fill"></i>
                    <h5>Daftar Nasabah</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="absensi.php">
                <div class="menu-card">
                    <i class="bi bi-person-check"></i>
                    <h5>Kehadiran Nasabah</h5>
                </div>
            </a>
        </div>
        
        <!-- QR ABSENSI -->
        <div class="col-md-4">
            <a href="qr_absensi.php">
                <div class="menu-card">
                    <i class="bi bi-qr-code-scan"></i>
                    <h5>QR Absensi</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="penimbangan.php">
                <div class="menu-card">
                    <i class="bi bi-recycle"></i>
                    <h5>Penimbangan</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="harga.php">
                <div class="menu-card">
                    <i class="bi bi-cash-stack"></i>
                    <h5>Setting Harga</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="laporan_pengepul.php">
                <div class="menu-card">
                    <i class="bi bi-file-earmark-text"></i>
                    <h5>Laporan Pengepul</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="laporan_nasabah.php">
                <div class="menu-card">
                    <i class="bi bi-people"></i>
                    <h5>Laporan Nasabah</h5>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="laporan_panitia.php">
                <div class="menu-card">
                    <i class="bi bi-person-badge"></i>
                    <h5>Laporan Panitia</h5>
                </div>
            </a>
        </div>
    </div>
</div>


</body>
</html>