<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role']!='admin'){
    header("Location: login.php");
    exit;
}


if(isset($_POST['simpan'])){

    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $wa     = $_POST['wa'];

    mysqli_query($conn,"
    INSERT INTO absensi
    (
    nama_nasabah,
    alamat,
    no_wa,
    tanggal
    )

    VALUES

    (
    '$nama',
    '$alamat',
    '$wa',
    CURDATE()
    )
    ");


    echo "
    <script>
    alert('Nasabah berhasil ditambahkan');
    window.location='daftar_nasabah.php';
    </script>
    ";

}

?>


<!DOCTYPE html>
<html>
<head>

<title>Tambah Nasabah</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<div class="container mt-5">


<h3>
Tambah Nasabah
</h3>


<form method="POST">


<label>
Nama Nasabah
</label>

<input type="text"
name="nama"
class="form-control mb-3"
required>



<label>
Alamat
</label>

<textarea
name="alamat"
class="form-control mb-3"
required></textarea>



<label>
No WA
</label>

<input type="text"
name="wa"
class="form-control mb-3">


<button
name="simpan"
class="btn btn-success">

Simpan

</button>


<a href="daftar_nasabah.php"
class="btn btn-secondary">

Kembali

</a>


</form>


</div>


</body>
</html>
