<?php

include '../config/koneksi.php';


$bulan = $_GET['bulan'] ?? '';
$search = $_GET['search'] ?? '';


$query = "
SELECT p.*, a.nama_nasabah, j.nama_jenis
FROM penimbangan p
JOIN absensi a ON p.id_nasabah = a.id_nasabah
JOIN jenis_sampah j ON p.id_jenis = j.id_jenis
WHERE 1=1
";


if($bulan != ''){
$query .= "
AND DATE_FORMAT(p.tanggal,'%Y-%m')='$bulan'
";
}


if($search != ''){
$query .= "
AND a.nama_nasabah LIKE '%$search%'
";
}


$query .= "
ORDER BY p.tanggal DESC
";


$data = mysqli_query($conn,$query);


// TOTAL BERAT

$total = mysqli_query($conn,"
SELECT SUM(berat) AS total
FROM penimbangan
WHERE DATE_FORMAT(tanggal,'%Y-%m')='$bulan'
");

$t = mysqli_fetch_assoc($total);

?>


<script>
window.print();
</script>


<style>

table{
    border-collapse:collapse;
    font-size:14px;
}

th,td{
    padding:8px;
}

td{
    vertical-align:top;
}

.no{
    width:40px;
    text-align:center;
}

.tengah{
    text-align:center;
    white-space:nowrap;
}

</style>



<h2 align="center">
Laporan Penimbangan Sampah
</h2>


<?php if($bulan!=''){ ?>

<p align="center">
Periode : <?= date('F Y', strtotime($bulan.'-01')) ?>
</p>

<?php } ?>



<table
border="1"
width="100%"
cellpadding="8"
cellspacing="0">


<tr>

<th class="no">No</th>

<th>Nama</th>

<th>Jenis Sampah</th>

<th>Berat</th>

<th>Status</th>

<th class="tengah">
Tanggal
</th>


</tr>



<?php

$no=1;

while($d=mysqli_fetch_assoc($data)){

?>


<tr>


<td class="no">
<?= $no++ ?>
</td>


<td>
<?= $d['nama_nasabah'] ?>
</td>


<td>
<?= $d['nama_jenis'] ?>
</td>


<td class="tengah">
<?= $d['berat'] ?> Kg
</td>


<td class="tengah">
<?= ucfirst($d['status']) ?>
</td>


<td class="tengah">
<?= date('d-m-Y', strtotime($d['tanggal'])) ?>
</td>


</tr>


<?php } ?>


<tr>

<td colspan="3" align="right">
<b>Total Berat</b>
</td>


<td colspan="3">
<b>
<?= number_format($t['total'] ?? 0,2) ?> Kg
</b>
</td>


</tr>


</table>