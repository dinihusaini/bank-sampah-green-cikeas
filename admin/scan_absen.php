<?php
session_start();

if(
!isset($_SESSION['login']) 
|| $_SESSION['role'] != 'nasabah'
){

    header("Location: login.php");
    exit;

}

?>

<!DOCTYPE html>
<html>

<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Scan Absensi</title>

<script src="https://unpkg.com/html5-qrcode"></script>

<style>
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


<body>


<h3 align="center">
Scan QR Absensi
</h3>


<div id="reader"
style="width:300px;margin:auto;">
</div>



<script>

function sukses(result){

    window.location.href = result;

}


let scanner = new Html5Qrcode("reader");


scanner.start(

    { facingMode: "environment" },

    {
        fps: 10,
        qrbox: 250
    },

    sukses

);

</script>


</body>

</html>
