<?php
include '../config/koneksi.php';

if(isset($_POST['daftar'])){

    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $alamat = $_POST['alamat'];
    $no_wa  = $_POST['no_wa'];

    mysqli_query($conn, "INSERT INTO users 
    (nama_users, username_users, password_users, role, email)
    VALUES
    ('$nama','$username','$password','nasabah','$email')");


    mysqli_query($conn, "INSERT INTO absensi
    (nama_nasabah, alamat, no_wa, tanggal)
    VALUES
    ('$nama','$alamat','$no_wa',NOW())");


    header("Location: login.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Daftar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #0c5f24, #98ba7d);
            height: 100vh;
        }

        .register-card {
            width: 100%;
            max-width: 420px;
            border-radius: 15px;
        }

        .btn-register {
            background-color: #0c5f24;
            color: white;
        }

        .btn-register:hover {
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

<body class="d-flex justify-content-center align-items-center">

<div class="card register-card shadow p-4">

    <div class="text-center mb-3">
        <img src="../assets/logobs.png" width="60">
        <h4 class="mt-2">Bank Sampah Green Cikeas</h4>
    </div>

    <h5 class="text-center mb-3">Daftar Nasabah</h5>

    <form method="POST">

        <div class="mb-3 input-group">
            <span class="input-group-text">
                <i class="bi bi-person"></i>
            </span>
            <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required>
        </div>
        
        <div class="mb-3 input-group">
            <span class="input-group-text">
                <i class="bi bi-house"></i>
            </span>
        
            <input 
            type="text"
            name="alamat"
            class="form-control"
            placeholder="Alamat"
            required>
        </div>
        
        <div class="mb-3 input-group">
        
            <span class="input-group-text">
                <i class="bi bi-whatsapp"></i>
            </span>
        
            <input 
                type="text"
                name="no_wa"
                class="form-control"
                placeholder="No WhatsApp"
                required>
        
        </div>

        <div class="mb-3 input-group">
            <span class="input-group-text">
                <i class="bi bi-person-badge"></i>
            </span>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        
        <div class="mb-3 input-group">
        
            <span class="input-group-text">
                <i class="bi bi-envelope"></i>
            </span>
        
            <input 
                type="email" 
                name="email" 
                class="form-control" 
                placeholder="Email aktif"
                required>
        
        </div>

        <div class="mb-3 input-group">
            <span class="input-group-text">
                <i class="bi bi-lock"></i>
            </span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button name="daftar" class="btn btn-register w-100">Daftar</button>

    </form>

    <p class="text-center mt-3">
        Sudah punya akun? <a href="login.php">Login</a>
    </p>

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
