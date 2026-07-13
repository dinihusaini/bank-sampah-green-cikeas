<?php
session_start();
include '../config/koneksi.php';

$halaman = "jenis";
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Jenis Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card:hover {
            transform: scale(1.03);
            transition: 0.3s;
        }
        .btn-active {
            background-color: #98ba7d !important;
            color: black !important;
            border: none;
        }
        .card-img-top {
            height: 300px;
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
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard_nasabah.php">
            <img src="../assets/logobs.png" alt="Logo" width="40" class="me-2">
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

    <h2>Daftar Jenis Sampah</h2>

    <div class="input-group mb-4">
        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" id="search" class="form-control" placeholder="Cari jenis sampah...">
    </div>

    <div class="row">

    <?php
    $data = mysqli_query($conn, "SELECT * FROM jenis_sampah");

    while($d = mysqli_fetch_assoc($data)){
    ?>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm card-item">

                <img src="../assets/<?= $d['gambar']; ?>" class="card-img-top">

                <div class="card-body">
                    <h5 class="card-title"><?= $d['nama_jenis']; ?></h5>
                </div>

            </div>
        </div>

    <?php } ?>

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

<script>
document.getElementById("search").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();

    document.querySelectorAll(".card-item").forEach(card => {
        let text = card.innerText.toLowerCase();

        if(text.includes(value)){
            card.parentElement.style.display = "";
        } else {
            card.parentElement.style.display = "none";
        }
    });
});
</script>
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
