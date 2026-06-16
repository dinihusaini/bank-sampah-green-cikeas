<?php
session_start();

include '../config/koneksi.php';

$totalNasabah = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM users
    WHERE role = 'nasabah'
");

$dataNasabah = mysqli_fetch_assoc($totalNasabah);

$totalSampahQuery = mysqli_query($conn, "SELECT SUM(berat) as total FROM penimbangan");
$dataSampah = mysqli_fetch_assoc($totalSampahQuery);

$totalSampah = $dataSampah['total'] ?? 0;

$halaman = "tentang";
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Tentang Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .btn-active {
        background-color: #98ba7d !important;
        color: black !important;
        border: none;
    }

    .flow-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
    }
    
    .flow-step {
        width: 180px;
        height: 140px;
        border-radius: 20px;
        color: white;
        text-align: center;
        padding: 15px;
        position: relative;
        font-weight: 500;
        transition: 0.3s;
    }
    
    .flow-step:hover {
        transform: translateY(-5px) scale(1.03);
    }
    
    /* warna tiap step */
    .step1 { background: #6ec1e4; }
    .step2 { background: #8e44ad; }
    .step3 { background: #e91e63; }
    .step4 { background: #f39c12; }
    .step5 { background: #4caf50; }
    
    .flow-number {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .flow-text {
        font-size: 14px;
    }
    
    /* responsive */
    @media (max-width: 768px) {
        .flow-step {
            width: 100%;
        }
    }

    .section-card {
        background: linear-gradient(135deg, #ffffff, #f5fbf6);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        transition: 0.3s;
        border-left: 5px solid #0c5f24;
    }
    
    .section-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
    }
    
    .section-title {
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .section-title i {
        font-size: 22px;
        color: #0c5f24;
    }

    .strategy-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.05);
        border-left: 5px solid #0c5f24;
        transition: 0.3s;
    }
    
    .strategy-card:hover {
        transform: translateY(-5px);
    }
    
    .strategy-title {
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .strategy-icon {
        font-size: 20px;
        color: #0c5f24;
        margin-right: 8px;
    }
    
    .harapan-box {
        background: linear-gradient(135deg, #e8f5e9, #ffffff);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.05);
    }
    
    .harapan-box li {
        margin-bottom: 10px;
    }
    
    .list-modern li {
        margin-bottom: 8px;
        padding-left: 5px;
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

    /* FOOTER */
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

<body class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->
<nav class="navbar navbar-dark" style="background-color:#0c5f24;">
    <div class="container d-flex justify-content-between align-items-center">
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

        <!-- USER -->
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

    <!-- PROFIL -->
    <div class="p-4 bg-white shadow-sm rounded mb-4">
        <img src="../assets/tentangbs.jpeg"
        class="img-fluid rounded shadow mt-3 w-100"
        style="height:500px; object-fit:cover;">
        <hr>
        <h3>Profil Bank Sampah</h3>

        <p>
            Bank Sampah <b>Green Cikeas</b> merupakan sistem pengelolaan sampah berbasis masyarakat 
            yang berdiri sejak tahun 2021 dan berlokasi di Perumahan Green Cikeas Residence 
            RT 01 RW 020, Desa Cicadas, Kecamatan Gunung Putri.
        </p>

        <p>
            Bank sampah ini didirikan oleh Kelompok Masyarakat Peduli Lingkungan RW 020 
            dengan tujuan meningkatkan kesadaran masyarakat dalam pengelolaan sampah 
            serta memberikan nilai ekonomi dari sampah rumah tangga.
        </p>

        <p>
            Kegiatan utama meliputi penimbangan sampah setiap bulan serta edukasi kepada warga 
            mengenai pemilahan dan pengelolaan sampah.
        </p>

        <p class="fst-italic text-success">
            "Dari Sampah Menjadi Berkah, Demi Lingkungan yang Lebih Bersih 🌱"
        </p>
    </div>

    <!-- STRUKTUR ORGANISASI -->
    <div class="p-4 bg-white shadow-sm rounded mb-4 text-center">
        <h4>Struktur Organisasi</h4>
        <p class="text-muted">Pengurus Bank Sampah Green Cikeas</p>

        <img src="../assets/struktur.jpeg" class="img-fluid rounded shadow mt-3">
    </div>

    <!-- PENGURUS BANK SAMPAH -->
    <div class="p-4 bg-white shadow-sm rounded mb-4">

        <div class="text-center mb-5">
            <h3 class="fw-bold">
                Pengurus Bank Sampah
            </h3>

            <p class="text-muted">
                Tim pengelola Bank Sampah Green Cikeas
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- ANGGOTA 1 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="strategy-card text-center h-100">

                    <img src="../assets/anggota1.jpeg"
                        class="rounded-circle shadow mb-3"
                        width="120"
                        height="120"
                        style="object-fit:cover;">

                    <h5 class="fw-bold">
                        Sustiani
                    </h5>

                    <span class="badge bg-success mb-3">
                        Ketua
                    </span>
                </div>
            </div>

            <!-- ANGGOTA 2 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="strategy-card text-center h-100">

                    <img src="../assets/anggota2.jpeg"
                        class="rounded-circle shadow mb-3"
                        width="120"
                        height="120"
                        style="object-fit:cover;">

                    <h5 class="fw-bold">
                        Qomsatun
                    </h5>

                    <span class="badge bg-primary mb-3">
                        Sekretaris
                    </span>
                </div>
            </div>

            <!-- ANGGOTA 3 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="strategy-card text-center h-100">

                    <img src="../assets/anggota3.jpeg"
                        class="rounded-circle shadow mb-3"
                        width="120"
                        height="120"
                        style="object-fit:cover;">

                    <h5 class="fw-bold">
                        Ani Supriatin
                    </h5>

                    <span class="badge bg-warning text-dark mb-3">
                        Bendahara
                    </span>
                </div>
            </div>

            <!-- ANGGOTA 4 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="strategy-card text-center h-100">

                    <img src="../assets/anggota4.jpeg"
                        class="rounded-circle shadow mb-3"
                        width="120"
                        height="120"
                        style="object-fit:cover;">

                    <h5 class="fw-bold">
                        Nur Wakidah
                    </h5>

                    <span class="badge bg-danger mb-3">
                        Anggota
                    </span>
                </div>
            </div>

            <!-- ANGGOTA 5 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="strategy-card text-center h-100">

                    <img src="../assets/anggota5.jpeg"
                        class="rounded-circle shadow mb-3"
                        width="120"
                        height="120"
                        style="object-fit:cover;">

                    <h5 class="fw-bold">
                        Wiwit Erniasih
                    </h5>

                    <span class="badge bg-info text-dark mb-3">
                        Anggota
                    </span>
                </div>
            </div>

            <!-- ANGGOTA 6 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="strategy-card text-center h-100">

                    <img src="../assets/anggota6.jpeg"
                        class="rounded-circle shadow mb-3"
                        width="120"
                        height="120"
                        style="object-fit:cover;">

                    <h5 class="fw-bold">
                        Devi Lestari
                    </h5>

                    <span class="badge bg-secondary mb-3">
                        Anggota
                    </span>
                </div>
            </div>

            <!-- ANGGOTA 7 -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="strategy-card text-center h-100">

                    <img src="../assets/anggota7.jpeg"
                        class="rounded-circle shadow mb-3"
                        width="120"
                        height="120"
                        style="object-fit:cover;">

                    <h5 class="fw-bold">
                        Lasminingtyas
                    </h5>

                    <span class="badge bg-dark mb-3">
                        Anggota
                    </span>
                </div>
            </div>

        </div>

    </div>

    <!-- INFO -->
    <div class="section-card">
        <h4 class="section-title">
            <i class="bi bi-info-circle"></i> Informasi Umum
        </h4>

        <ul class="list-modern">
            <li><b>Tahun Berdiri:</b> 2021</li>
            <li><b>Jumlah Nasabah:</b> 114 Rumah Tangga</li>
            <li><b>Jenis Sampah:</b> Plastik, kertas, kardus, logam, botol kaca</li>
            <li><b>Kegiatan:</b> Menabung sampah & edukasi lingkungan</li>
        </ul>
    </div>

    <!-- STATISTIK -->
    <div class="row text-center mt-4 mb-4">
        <div class="col-md-3 mb-3">
            <div class="section-card">
                <h2 class="text-success fw-bold" id="counter1">0</h2>
                <p>Nasabah Aktif</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="section-card">
                <h2 class="text-success fw-bold">
                    <span id="counter2">0</span> Kg
                </h2>
                <p>Kg Sampah Terkelola</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="section-card">
                <h2 class="text-success fw-bold" id="counter3">0</h2>
                <p>Kegiatan Lingkungan</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="section-card">
                <h2 class="text-success fw-bold" id="counter4">0</h2>
                <p>Tahun Berdiri</p>
            </div>
        </div>

    </div>

    <!-- TUJUAN -->
    <div class="section-card">
        <h4 class="section-title">
            <i class="bi bi-bullseye"></i> Tujuan
        </h4>

        <ul class="list-modern">
            <li>Mengurangi jumlah sampah di lingkungan</li>
            <li>Meningkatkan kesadaran masyarakat</li>
            <li>Memberikan nilai ekonomi dari sampah</li>
            <li>Mendorong partisipasi masyarakat</li>
        </ul>
    </div>

    <!-- CARA KERJA -->
    <div class="p-4 bg-white shadow-sm rounded mb-4 text-center">
        <h4 class="mb-3">Alur Penimbangan Sampah</h4>
        
        <p class="text-muted mx-auto" style="max-width:600px;">
            Proses pengelolaan sampah dilakukan secara sistematis mulai dari pemilahan hingga pengangkutan.
        </p>
        
        <div class="flow-container">
            <div class="flow-step step1">
                <div class="flow-number">1</div>
                <div class="flow-text">
                    Pemilahan Sampah Rumah Tangga
                </div>
            </div>
            
            <div class="flow-step step2">
                <div class="flow-number">2</div>
                <div class="flow-text">
                    Penyetoran Sampah ke Bank
                </div>
            </div>
            
            <div class="flow-step step3">
                <div class="flow-number">3</div>
                <div class="flow-text">
                    Penimbangan Sampah
                </div>
            </div>
            
            <div class="flow-step step4">
                <div class="flow-number">4</div>
                <div class="flow-text">
                    Pencatatan
                </div>
            </div>
            
            <div class="flow-step step5">
                <div class="flow-number">5</div>
                <div class="flow-text">
                    Pengangkutan
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 bg-white shadow-sm rounded mb-4">
        <h3 class="mb-4 text-center">Strategi & Harapan Bank Sampah</h3>
        <div class="row">
            <!-- STRATEGI -->
             <div class="col-md-6">
                <div class="strategy-card">
                    <div class="strategy-title">
                        <i class="bi bi-people strategy-icon"></i>
                        Peningkatan Partisipasi Warga
                    </div>
                    
                    <ul>
                        <li>Edukasi rutin tentang pemilahan sampah</li>
                        <li>Membentuk kader lingkungan</li>
                        <li>Memberikan insentif kepada nasabah aktif</li>
                    </ul>
                </div>
                
                <div class="strategy-card">
                    <div class="strategy-title">
                        <i class="bi bi-gear strategy-icon"></i>
                        Penguatan Manajemen Internal
                    </div>
                    
                    <ul>
                        <li>Sistem pencatatan manual & digital</li>
                        <li>Pelatihan petugas dan relawan</li>
                    </ul>
                </div>
                
                <div class="strategy-card">
                    <div class="strategy-title">
                        <i class="bi bi-diagram-3 strategy-icon"></i>
                        Kemitraan & Kolaborasi
                    </div>
                    
                    <ul>
                        <li>Kerja sama dengan pemerintah & sekolah</li>
                        <li>Dukungan CSR perusahaan</li>
                    </ul>
                </div>
                
                <div class="strategy-card">
                    <div class="strategy-title">
                        <i class="bi bi-phone strategy-icon"></i>
                        Pemanfaatan Teknologi
                    </div>
                    
                    <ul>
                        <li>Media sosial untuk edukasi & komunikasi</li>
                    </ul>
                </div>
            </div>
            
            <!-- HARAPAN -->
             <div class="col-md-6">
                <div class="harapan-box">
                    <h5 class="mb-3">Harapan Bank Sampah</h5>
                    
                    <ul>
                        <li>Masyarakat lebih sadar dan peduli lingkungan</li>
                        <li>Volume sampah ke TPA berkurang signifikan</li>
                        <li>Menjadi wadah ekonomi sirkular</li>
                        <li>Lingkungan bersih, sehat, dan lestari</li>
                        <li>Menjadi model bank sampah berkelanjutan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- DOKUMENTASI -->
    <div class="p-4 bg-white shadow-sm rounded mb-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4 class="mb-0">Dokumentasi Kegiatan</h4>

            <a href="aktivitas.php" class="btn btn-success">

                <i class="bi bi-images"></i> More Here

            </a>

        </div>

        <div class="row g-3">

            <div class="col-md-6">
                <img src="../assets/kegiatan6.jpeg"
                    class="img-fluid rounded shadow w-100"
                    style="height:300px; object-fit:cover;">
            </div>

            <div class="col-md-6">
                <img src="../assets/kegiatan2.jpeg"
                    class="img-fluid rounded shadow w-100"
                    style="height:300px; object-fit:cover;">
            </div>

            <div class="col-md-6">
                <img src="../assets/kegiatan3.jpeg"
                    class="img-fluid rounded shadow w-100"
                    style="height:300px; object-fit:cover;">
            </div>

            <div class="col-md-6">
                <img src="../assets/kegiatan4.jpeg"
                    class="img-fluid rounded shadow w-100"
                    style="height:300px; object-fit:cover;">
            </div>

        </div>

    </div>

    <!-- TESTIMONI -->
    <div class="p-4 bg-white shadow-sm rounded mb-4">

        <h3 class="text-center mb-4">
            Testimoni Warga
        </h3>

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="strategy-card h-100">
                    <p class="fst-italic">
                        "Lingkungan jadi lebih bersih dan warga semakin sadar memilah sampah."
                    </p>

                    <h6 class="mt-3 mb-0">
                        — Ibu Siti
                    </h6>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="strategy-card h-100">
                    <p class="fst-italic">
                        "Sampah rumah tangga sekarang bisa menghasilkan nilai ekonomi."
                    </p>

                    <h6 class="mt-3 mb-0">
                        — Pak Rudi
                    </h6>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="strategy-card h-100">
                    <p class="fst-italic">
                        "Kegiatan bank sampah membuat warga lebih kompak."
                    </p>

                    <h6 class="mt-3 mb-0">
                        — Ibu Lina
                    </h6>
                </div>
            </div>

        </div>

    </div>

    <!-- QUOTE -->
    <div class="text-center py-5">

        <h2 class="fw-bold text-success">
            “Sampah Bukan Akhir, Tapi Awal Perubahan.”
        </h2>

        <p class="text-muted mt-2">
            Bersama Bank Sampah Green Cikeas menciptakan lingkungan yang lebih bersih 🌱
        </p>

    </div>

    <div class="wa-popup">
        <div class="wa-box" id="waBox">
            <h6 class="mb-2">Hubungi Admin</h6>
            <p class="small text-muted mb-2">
                Ada pertanyaan? Hubungi admin kami 👋
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

<script>
function animateCounter(id, target){
    let count = 0;
    target = parseFloat(target);

    let step = target / 50;

    let timer = setInterval(() => {

        count += step;

        if(count >= target){
            count = target;
            clearInterval(timer);
        }

        document.getElementById(id).innerHTML =
            Math.round(count)

    }, 20);
}

animateCounter("counter1", <?= $dataNasabah['total']; ?>);
animateCounter("counter2", <?= $totalSampah; ?>);
animateCounter("counter3", 25);
animateCounter("counter4", 2021);
</script>

</body>
</html>