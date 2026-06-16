<?php

session_start();

include '../config/koneksi.php';


$id = $_GET['id'];
$back = $_GET['back'] ?? 'penimbangan.php';


$data = mysqli_query($conn,
"SELECT * FROM penimbangan 
WHERE id_penimbangan='$id'"
);

$d = mysqli_fetch_assoc($data);



if(isset($_POST['update'])){


$id_nasabah = $_POST['id_nasabah'];
$id_jenis = $_POST['id_jenis'];
$berat = $_POST['berat'];
$status = $_POST['status'];



mysqli_query($conn,
"UPDATE penimbangan SET

id_nasabah='$id_nasabah',
id_jenis='$id_jenis',
berat='$berat',
status='$status'

WHERE id_penimbangan='$id'"
);



echo "
<script>
alert('Data berhasil diedit');
window.location='$back';
</script>
";

}


?>


<!DOCTYPE html>
<html>

<head>

<title>Edit Penimbangan</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body style="background:#f5f7f8;">


<div class="container mt-5">


<div class="card shadow p-4">


<h3 class="mb-4">
Edit Penimbangan
</h3>


<form method="POST">


<label>Nasabah</label>

<select name="id_nasabah" class="form-select mb-3">


<?php

$n = mysqli_query($conn,
"SELECT * FROM absensi"
);


while($ns = mysqli_fetch_assoc($n)){

?>


<option value="<?= $ns['id_nasabah']; ?>"
<?= ($ns['id_nasabah']==$d['id_nasabah'])?'selected':''; ?>
>

<?= $ns['nama_nasabah']; ?>

</option>


<?php } ?>


</select>




<label>Jenis Sampah</label>


<select name="id_jenis" class="form-select mb-3">


<?php

$j = mysqli_query($conn,
"SELECT * FROM jenis_sampah"
);


while($js=mysqli_fetch_assoc($j)){

?>


<option value="<?= $js['id_jenis']; ?>"
<?= ($js['id_jenis']==$d['id_jenis'])?'selected':''; ?>
>


<?= $js['nama_jenis']; ?>


</option>


<?php } ?>


</select>




<label>Berat (Kg)</label>


<input type="number"
step="0.01"
name="berat"
class="form-control mb-3"
value="<?= $d['berat']; ?>">





<label>Status</label>


<select name="status"
class="form-select mb-3">


<option value="normal"
<?= ($d['status']=='normal')?'selected':''; ?>>

Normal

</option>



<option value="gabruk"
<?= ($d['status']=='gabruk')?'selected':''; ?>>

Gabruk

</option>


</select>




<button name="update"
class="btn btn-success">

Simpan Perubahan

</button>


<a href="penimbangan.php"
class="btn btn-secondary">

Batal

</a>



</form>


</div>


</div>


</body>

</html>