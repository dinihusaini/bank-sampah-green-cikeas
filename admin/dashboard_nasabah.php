<?php
session_start();
include '../config/koneksi.php'; 

$halaman = "dashboard";
$totalNasabah = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM users
    WHERE role = 'nasabah'
");

$dataNasabah = mysqli_fetch_assoc($totalNasabah);

$totalSampahQuery = mysqli_query($conn, "SELECT SUM(berat) as total FROM penimbangan");
$dataSampah = mysqli_fetch_assoc($totalSampahQuery);

$totalSampah = $dataSampah['total'] ?? 0;

$totalJenisQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM jenis_sampah");
$dataJenis = mysqli_fetch_assoc($totalJenisQuery);

$totalAktivitas = 12;
?>

<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Nasabah</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* tombol aktif */
        .btn-active {
            background-color: #98ba7d !important;
            color: black !important;
            border: none;
        }

        .btn:hover {
            transform: scale(1.03);
            transition: 0.2s;
        }

        .card {
            border-radius: 12px;
        }

        .card:hover {
            transform: translateY(-6px) scale(1.01);
            transition: 0.3s;
        }

        /* VISI MISI */
        .card-visi {
            background: white;
            padding: 25px;
            border-radius: 12px;
            position: relative;
            transition: 0.3s;
            opacity: 0;
            transform: translateY(30px);
            height: 100%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }

        .card-visi.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card-visi:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .highlight-card {
            background: linear-gradient(135deg, #e8f5e9, #ffffff);
            border-left: 5px solid #0c5f24;
        }

        .icon-box {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 28px;
            color: #0c5f24;
        }

        .section {
            margin-top: 40px;
        }

        .circle-box {
            width: 220px;
            height: 220px;
            background: #4caf50;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: bold;
            line-height: 1.5;
            margin: auto;
            box-shadow: 0 0 0 8px #dff5e1, 0 0 0 12px #cce7d0;
        }
        
        .impact-box {
            background: #ffffff;
            border: 2px solid #4caf50;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: 0.4s ease;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .impact-box.show {
            opacity: 1;
            transform: translateY(0);
        }

        .impact-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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

        /* GALLERY */
        .gallery-card{
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .gallery-card:hover{
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .gallery-img{
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .gallery-caption{
            padding: 12px;
            text-align: center;
            font-weight: 600;
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

        /* MAPS */
        .map-container{
            overflow: hidden;
            border-radius: 18px;
            background: white;
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

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="dashboard_nasabah.php">
            <img src="../assets/logobs.png" width="40" class="me-2">
            Bank Sampah Green Cikeas
        </a>

        <!-- MENU -->
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
<!-- HERO BANNER -->
<div class="hero-banner" style="
    background: url('../assets/banner.jpeg') center/cover no-repeat;
    height: 400px;
    position: relative;
">
    <div style="
        position:absolute;
        width:100%;
        height:100%;
        background: rgba(0,0,0,0.6);
    "></div>

    <div class="container h-100 d-flex align-items-center" style="position:relative; z-index:2;">
        <div class="text-white">
            <h1 class="fw-bold" style="font-size:48px;">
                Bank Sampah <br> Green Cikeas
            </h1>

            <p style="max-width:500px;">
                Solusi pengelolaan sampah berbasis masyarakat untuk lingkungan yang lebih bersih dan bernilai ekonomi.
            </p>

            <a href="tentang.php" class="btn mt-3" style="background:#98ba7d;">
                Tentang Kami →
            </a>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container mt-4">

    <div class="container mt-4">
        <h5>
        Halo, 
        <b>
        <?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Pengunjung'; ?>
        </b> 👋
        </h5>
        <p class="text-muted">Selamat datang di dashboard Bank Sampah Green Cikeas</p>
        <p class="fst-italic text-muted">
            "Dari Sampah Menjadi Berkah, Demi Lingkungan yang Lebih Bersih 🌱"
        </p>
    </div>

    <!-- DESKRIPSI -->
    <div class="p-4 bg-white shadow-sm rounded mb-4">
        <h2>Bank Sampah Green Cikeas</h2>

        <p>
            Bank Sampah Green Cikeas merupakan sistem pengelolaan sampah berbasis masyarakat yang dilakukan dengan cara menabung sampah yang telah dipilah sesuai jenisnya.
        </p>

        <p>
            Setiap sampah yang disetorkan akan ditimbang dan memiliki nilai ekonomi sesuai dengan jenis dan beratnya. Program ini bertujuan untuk meningkatkan kesadaran masyarakat terhadap lingkungan sekaligus memberikan manfaat ekonomi.
        </p>

        <p>
            Dengan adanya bank sampah, masyarakat dapat berperan aktif dalam mengurangi limbah, menjaga kebersihan lingkungan, serta mendapatkan keuntungan dari sampah yang dikumpulkan.
        </p>
    </div>
    
    <?php if(!isset($_SESSION['login'])){ ?>

    <div class="text-center my-4 p-4 bg-white shadow-sm rounded">
    
        <h3 class="fw-bold text-success">
            Mau Jadi Nasabah Bank Sampah Green Cikeas?
        </h3>
    
        <p class="text-muted">
            Yuk bergabung bersama kami dan mulai ubah sampah menjadi tabungan bernilai 💚
        </p>
    
        <a href="register.php" 
           class="btn btn-success">
    
            <i class="bi bi-person-plus"></i>
            Daftar Sekarang
    
        </a>
    
    </div>
    
    <?php } ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-6 col-md-3 mb-3">
                <div class="card shadow-sm p-3 highlight-card text-center h-100">
                    <h5>👥 Total Nasabah</h5>
                    
                    <h4 id="totalNasabah"
                    class="text-success my-2 fw-bold">
                    <?= $dataNasabah['total']; ?>
                    </h4>
                    
                    <p class="text-muted small">
                        Data pengguna aktif saat ini
                    </p>
                </div>
            </div>
            
            <div class="col-6 col-md-3 mb-3">
                <div class="card shadow-sm p-3 highlight-card text-center h-100">
                    <h5>♻️ Sampah Terkelola</h5>

                    <h4 class="text-success my-2 fw-bold">
                        <?= $totalSampah; ?> Kg
                    </h4>

                    <p class="text-muted small">
                        Total sampah terkumpul
                    </p>
                </div>
            </div>
            
            <div class="col-6 col-md-3 mb-3">
                <div class="card shadow-sm p-3 highlight-card text-center h-100">
                    <h5>🗂 Jenis Sampah</h5>

                    <h4 class="text-success my-2 fw-bold">
                        <?= $dataJenis['total']; ?>
                    </h4>

                    <p class="text-muted small">
                        Jenis sampah tersedia
                    </p>
                </div>
            </div>

            <!-- AKTIVITAS -->
            <div class="col-6 col-md-3 mb-3">
                <div class="card shadow-sm p-3 highlight-card text-center h-100">
                    <h5>📅 Aktivitas</h5>

                    <h4 class="text-success my-2 fw-bold">
                        <?= $totalAktivitas; ?>
                    </h4>

                    <p class="text-muted small">
                        Kegiatan bank sampah
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- VISI MISI -->
    <div class="row">

        <div class="col-md-6 mb-3 d-flex">
            <div class="card-visi w-100">
                <div class="icon-box">♻️</div>
                <h4><b>Misi</b></h4>
                <p>
                    Meningkatkan kesadaran masyarakat dalam pengelolaan sampah secara mandiri dan berkelanjutan.
                    Mengurangi jumlah sampah melalui kegiatan penimbangan dan pemilahan.
                    Memberikan nilai ekonomi dari sampah serta mendorong partisipasi aktif masyarakat.
                </p>
            </div>
        </div>

        <div class="col-md-6 mb-3 d-flex">
            <div class="card-visi w-100">
                <div class="icon-box">🌿</div>
                <h4><b>Visi</b></h4>
                <p>
                    Menjadi bank sampah yang berkelanjutan, inovatif, dan mampu meningkatkan kesejahteraan masyarakat
                    serta menjaga kelestarian lingkungan.
                </p>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row align-items-center">
            <!-- KIRI (LINGKARAN) -->
             <div class="col-md-4 text-center mb-4">
                <div class="circle-box">
                    DAMPAK<br>SAMPAH<br>PADA<br>LINGKUNGAN
                </div>
            </div>
            
            <!-- KANAN (TEXT BOX) -->
             <div class="col-md-8">
                <div class="impact-box">
                    Sampah yang tidak dikelola dengan baik memberikan dampak serius terhadap lingkungan.
                </div>
                
                <div class="impact-box">
                    Pencemaran tanah, air, dan udara menjadi konsekuensi utama dari penumpukan sampah,
                    terutama sampah plastik yang sulit terurai.
                </div>
                
                <div class="impact-box">
                    Kesadaran untuk mengurangi, memilah, dan mendaur ulang sampah sangat penting demi menjaga kelestarian lingkungan.
                </div>
            </div>
        </div>
    </div>

    <!-- GALLERY KEGIATAN -->
    <div class="container mt-5">
        
        <div class="text-center mb-4">
            <h2 class="fw-bold">Gallery Kegiatan</h2>
        
            <p class="text-muted">
                Dokumentasi kegiatan Bank Sampah Green Cikeas
            </p>
        </div>

        <div class="row">

            <!-- FOTO 1 -->
            <div class="col-6 col-md-3 mb-4">
                <div class="gallery-card">
                    <img src="../assets/kegiatan1.jpeg"
                         class="img-fluid gallery-img">

                    <div class="gallery-caption">
                        Penimbangan Sampah
                    </div>
                </div>
            </div>

            <!-- FOTO 2 -->
            <div class="col-6 col-md-3 mb-4">
                <div class="gallery-card">
                    <img src="../assets/kegiatan2.jpeg"
                         class="img-fluid gallery-img">

                    <div class="gallery-caption">
                        Pemilahan Sampah
                    </div>
                </div>
            </div>

            <!-- FOTO 3 -->
            <div class="col-6 col-md-3 mb-4">
                <div class="gallery-card">
                    <img src="../assets/kegiatan3.jpeg"
                        class="img-fluid gallery-img">

                    <div class="gallery-caption">
                        Kegiatan Warga
                    </div>
                </div>
            </div>

            <!-- FOTO 4 -->
            <div class="col-6 col-md-3 mb-4">
                <div class="gallery-card">
                    <img src="../assets/kegiatan4.jpeg"
                        class="img-fluid gallery-img">

                    <div class="gallery-caption">
                        Pengangkutan Sampah
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- LOKASI -->
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Lokasi Bank Sampah</h2>
            
            <p class="text-muted">
                Lokasi Bank Sampah Green Cikeas
            </p>
        </div>
        
        <div class="map-container shadow-sm">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3778.9402618536983!2d106.92426167476566!3d-6.42105069356992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6995005a1ba7e5%3A0x41b89d470c1ca29f!2sBank%20Sampah%20Green%20Cikeas!5e1!3m2!1sid!2sid!4v1779681228939!5m2!1sid!2sid"
                width="100%"
                height="350"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>

        </div>
    </div>

    <!-- FAQ -->
    <div class="container mt-5 mb-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Pertanyaan Umum</h2>
            
            <p class="text-muted">
                Informasi seputar Bank Sampah Green Cikeas
            </p>
        </div>
        
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item mb-3 border-0 shadow-sm rounded overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq1">
                    
                        Bagaimana cara setor sampah?
                    </button>
                </h2>

                <div id="faq1"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">
                        Nasabah dapat memilah sampah sesuai jenisnya,
                        kemudian datang ke bank sampah untuk dilakukan
                        penimbangan dan pencatatan.
                    </div>
                </div>
            </div>

            <!-- ITEM 2 -->
            <div class="accordion-item mb-3 border-0 shadow-sm rounded overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq2">

                        Jenis sampah apa saja yang diterima?
                    </button>
                </h2>

                <div id="faq2"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">
                        Sampah plastik, kardus, botol, kertas,
                        logam, dan beberapa jenis sampah lainnya.
                    </div>
                </div>
            </div>

            <!-- ITEM 3 -->
            <div class="accordion-item mb-3 border-0 shadow-sm rounded overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq3">

                        Apakah sampah memiliki nilai ekonomi?
                    </button>
                </h2>

                <div id="faq3"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">
                        Ya, setiap jenis sampah memiliki harga berbeda
                        sesuai kategori dan berat sampah.
                    </div>
                </div>
            </div>

            <!-- ITEM 4 -->
            <div class="accordion-item border-0 shadow-sm rounded overflow-hidden">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-semibold"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq4">

                        Kapan jadwal operasional bank sampah?
                    </button>
                </h2>

                <div id="faq4"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">
                        Operasional dilakukan 1 bulan sekali di awal bulan,
                        pukul 08.00 - 10.00 WIB.
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- FLOATING WHATSAPP -->
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

<!-- POPUP -->
<?php if(isset($_SESSION['show_popup'])) { ?>
<script>
Swal.fire({
    title: 'Selamat Datang 👋',
    text: 'Halo, <?= $_SESSION['nama']; ?>!',
    icon: 'success'
});
</script>
<?php unset($_SESSION['show_popup']); } ?>

<!-- ANIMASI -->
<script>
window.addEventListener("load", () => {
    const cards = document.querySelectorAll(".card-visi");
    cards.forEach((card, i) => {
        setTimeout(() => {
            card.classList.add("show");
        }, i * 200);
    });
});
</script>
</main>

<?php include 'footer.php'; ?>

<script>
function animateCounter(id, target){

    let count = 0;
    target = parseInt(target);

    if(target === 0){
        document.getElementById(id).innerText = 0;
        return;
    }

    let timer = setInterval(() => {

        count++;

        document.getElementById(id).innerText = count;

        if(count >= target){
            clearInterval(timer);
        }

    }, 50);
}

animateCounter(
    "totalNasabah",
    <?= $dataNasabah['total']; ?>
);
</script>

<script>
window.addEventListener("load", () => {
    const items = document.querySelectorAll(".impact-box");
    items.forEach((el, i) => {
        setTimeout(() => {
            el.classList.add("show");
        }, i * 200);
    });
});
</script>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>