<?php
session_start();

$halaman = "aktivitas";
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Aktivitas Bank Sampah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
    }

    .btn-active {
        background-color: #98ba7d !important;
        color: black !important;
        border: none;
    }

    .card:hover {
        transform: scale(1.03);
        transition: 0.3s;
    }

    .card-img-top {
        height: 500px;
        object-fit: cover;
    }

    .wa-popup{
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }
    
    .wa-btn{
        width: 65px;
        height: 65px;
        border-radius: 50%;
        border: none;
        background: #4caf50;
        color: white;
        font-size: 28px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        transition: 0.3s;
    }
        
    .wa-btn:hover{
        transform: scale(1.08);
    }
        
    .wa-box{
        width: 250px;
        background: white;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            
        position: absolute;
        bottom: 80px;
        right: 0;
        display: none;
    }

    .footer-links li{
        margin-bottom: 10px;
    }

    .footer-links a{
        text-decoration: none;
        color: #dfeee3;
        transition: 0.3s;
    }

    .footer-links a:hover{
        color: #98ba7d;
        padding-left: 5px;
    }

    .social-icons a{
        width: 40px;
        height: 40px;
        background: rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        text-decoration: none;
        transition: 0.3s;
    }

    .social-icons a:hover{
        background: #98ba7d;
        color: black;
        transform: translateY(-3px);
    }

    .accordion-item:hover{
        transform: none !important;
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
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark" style="background-color:#0c5f24;">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand d-flex align-items-center" href="dashboard_nasabah.php">
            <img src="../assets/logobs.png" width="40" class="me-2">
            Bank Sampah Green Cikeas
        </a>

        <div>
            <a href="dashboard_nasabah.php" class="btn btn-sm <?= ($halaman=='dashboard') ? 'btn-active' : 'btn-light' ?>">Home</a>
            <a href="tentang.php" class="btn btn-sm <?= ($halaman=='tentang') ? 'btn-active' : 'btn-light' ?>">Tentang</a>
            <a href="jenis_sampah.php" class="btn btn-sm <?= ($halaman=='jenis') ? 'btn-active' : 'btn-light' ?>">Jenis Sampah</a>
            <a href="aktivitas.php" class="btn btn-sm <?= ($halaman=='aktivitas') ? 'btn-active' : 'btn-light' ?>">Aktivitas</a>
            <?php if(isset($_SESSION['login']) && $_SESSION['role']=='nasabah'){ ?>

                <a href="scan_absen.php"
                class="btn btn-sm btn-light">
        
                    <i class="bi bi-qr-code-scan"></i>
                    Scan Absen
        
                </a>
        
            <?php } ?>
        </div>

        <div class="d-flex align-items-center gap-2">
        
        <?php if(isset($_SESSION['login'])){ ?>
        
            <span class="text-white">
                <i class="bi bi-person-circle"></i>
                <?= $_SESSION['nama']; ?>
            </span>
        
            <a href="logout.php" 
               class="btn btn-danger btn-sm">
                Logout
            </a>
        
        <?php } else { ?>
        
            <a href="login.php" 
               class="btn btn-light btn-sm">
                Login
            </a>
        
            <a href="register.php" 
               class="btn btn-outline-light btn-sm">
                Daftar
            </a>
        
        <?php } ?>
        
        </div>

    </div>
</nav>

<main class="flex-fill">
<div class="container mt-4">

    <h2 class="mb-4">Aktivitas Bank Sampah</h2>

    <div class="row">

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/pertamanimbang.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Penimbangan Sampah Pertama</h5>
                    <p>Kegiatan penimbangan pertama BS Green Cikeas.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/penimbangan.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Penimbangan Sampah</h5>
                    <p>Kegiatan rutin setiap minggu untuk menimbang sampah dari nasabah.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/pemilahan.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Pemilahan Sampah</h5>
                    <p>Sampah dipisahkan berdasarkan jenis agar memiliki nilai jual.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/pengangkutan.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Pengangkutan Oleh Pengepul</h5>
                    <p>Setelah kegiatan penimbangan, sampah akan di angkut oleh pengepul.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/pembagiantabungan.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Pembagian Tabungan</h5>
                    <p>Pembagian tabungan nasabah selama 1 tahun.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/edukasi.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Edukasi Lingkungan</h5>
                    <p>Sosialisasi kepada masyarakat tentang pentingnya pengelolaan sampah.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/rewarddlh.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>BS Green Cikeas Mendapat reward dari DLH</h5>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/gotong.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Gotong Royong</h5>
                    <p>Kegiatan bersih lingkungan bersama masyarakat sekitar.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <img src="../assets/jalansehat.jpeg" class="card-img-top">
                <div class="card-body">
                    <h5>Jalan Sehat Bersama Aqua</h5>
                    <p>Agenda jalan sehat BS Green Cikeas dengan PT. Aqua</p>
                </div>
            </div>
        </div>

    </div>

    <div class="wa-popup">
        <div class="wa-box" id="waBox">
            <h6 class="mb-2">Hubungi Admin</h6>
            <p class="small text-muted mb-2">
                Ada pertanyaan? Hubungi admin kami ðŸ‘‹
            </p>
            
            <a href="https://wa.me/6281286918628"
            target="_blank"
            class="btn btn-success btn-sm w-100">
            WhatsApp Admin
            </a>
        </div>
        
        <button class="wa-btn" onclick="toggleWA()">
            <i class="bi bi-chat-dots"></i>
        </button>
    </div>

</div>
</main>

<?php include 'footer.php'; ?>

<script>
function toggleWA(){
    let box = document.getElementById("waBox");

    if(box.style.display === "block"){
        box.style.display = "none";
    } else {
        box.style.display = "block";
    }
}
</script>

</body>
</html>
