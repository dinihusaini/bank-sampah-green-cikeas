<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn,
"SELECT * FROM absensi WHERE id_nasabah='$id'"
);

$d = mysqli_fetch_assoc($data);


if(isset($_POST['update'])){

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$wa = $_POST['wa'];


mysqli_query($conn,
"UPDATE absensi SET

nama_nasabah='$nama',
alamat='$alamat',
no_wa='$wa'

WHERE id_nasabah='$id'"
);


header("Location: daftar_nasabah.php");
exit;

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Edit Nasabah</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body style="background:#f5f7f8">


<div class="container mt-5">


<div class="card shadow p-4">


<h3>Edit Nasabah</h3>


<form method="POST">


<label>Nama</label>
<input 
type="text"
name="nama"
class="form-control mb-3"
value="<?= $d['nama_nasabah']; ?>">


<label>Alamat</label>
<input 
type="text"
name="alamat"
class="form-control mb-3"
value="<?= $d['alamat']; ?>">


<label>No WA</label>
<input 
type="text"
name="wa"
class="form-control mb-3"
value="<?= $d['no_wa']; ?>">


<button 
name="update"
class="btn btn-success">

Simpan

</button>


<a href="daftar_nasabah.php"
class="btn btn-secondary">

Batal

</a>


</form>


</div>


</div>


</body>
</html>