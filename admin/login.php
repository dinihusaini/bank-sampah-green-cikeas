<?php
session_start();
include '../config/koneksi.php';

$success = isset($_GET['success']);

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $data = mysqli_query(
        $conn,
        "SELECT * FROM users 
        WHERE username_users='$username' 
        AND password_users='$password'"
    );

    $d = mysqli_fetch_assoc($data);

    if($d){
        $_SESSION['login'] = true;
        $_SESSION['show_popup'] = true;
        $_SESSION['role'] = $d['role'];
        $_SESSION['nama'] = $d['nama_users'];

        if($d['role'] == 'admin'){
            header("Location: dashboard.php");
        } else {
            header("Location: dashboard_nasabah.php");
        }
        exit;
    } else {
        $error = "Login gagal!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login</title>

    <!-- Bootstrap + Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(to right, #0c5f24, #98ba7d);
            height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
        }

        .btn-login {
            background-color: #0c5f24;
            color: white;
        }

        .btn-login:hover {
            background-color: #0a4e1e;
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

<body class="d-flex justify-content-center align-items-center">

<div class="card login-card shadow p-4">

    <div class="text-center mb-3">
        <img src="../assets/logobs.png" width="60">
        <h4 class="mt-2">Bank Sampah Green Cikeas</h4>
    </div>

    <h5 class="text-center mb-3">Login</h5>

    <form method="POST">

        <div class="mb-3 input-group">
            <span class="input-group-text">
                <i class="bi bi-person"></i>
            </span>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-3 input-group">
            <span class="input-group-text">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button id="btnLogin" name="login" class="btn btn-login w-100">
            <span id="btnText">Login</span>
            <span id="btnLoading" class="spinner-border spinner-border-sm d-none"></span>
        </button>

    </form>

    <p class="text-center mt-3">
        <a href="lupa_password.php">Lupa Password?</a>
    </p>
    
    <p class="text-center">
        Belum punya akun? <a href="register.php">Daftar</a>
    </p>

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

<script>

// =======================
// SWEETALERT
// =======================

// SUCCESS REGISTER
<?php if($success) { ?>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Akun berhasil dibuat, silakan login',
    confirmButtonColor: '#0c5f24'
});
<?php } ?>

// LOGIN GAGAL
<?php if(isset($error)) { ?>
Swal.fire({
    icon: 'error',
    title: 'Login Gagal!',
    text: 'Username atau password salah',
    confirmButtonColor: '#d33'
});
<?php } ?>

// =======================
// HAPUS ?success
// =======================
if (window.location.search.includes('success=1')) {
    window.history.replaceState({}, document.title, window.location.pathname);
}

// =======================
// LOADING BUTTON
// =======================
document.querySelector("form").addEventListener("submit", function() {
    let btn = document.getElementById("btnLogin");
    let text = document.getElementById("btnText");
    let loading = document.getElementById("btnLoading");

    setTimeout(() => {
        btn.disabled = true;
        loading.classList.remove("d-none");
        text.classList.add("d-none");
    }, 10);
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

</body>
</html>