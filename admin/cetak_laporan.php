<?php

include '../config/koneksi.php';

$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];


header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Laporan-Pengepul.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF";

echo '
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
';


$data = mysqli_query($conn, "

SELECT 
    j.nama_jenis,
    j.harga_per_kg,
    SUM(p.berat) as total_kg

FROM penimbangan p

INNER JOIN jenis_sampah j
ON p.id_jenis = j.id_jenis

WHERE DATE_FORMAT(p.tanggal,'%m')='$bulan'

AND DATE_FORMAT(p.tanggal,'%Y')='$tahun'

GROUP BY j.id_jenis

HAVING total_kg > 0

");

?>


<h2>
Laporan Pengepul Bulan <?= $bulan ?> / <?= $tahun ?>
</h2>


<table border="1">

<tr style="background:#198754;color:white;">

<th>No</th>
<th>Jenis Sampah</th>
<th>Total Kg</th>
<th>Harga/Kg</th>
<th>Total Harga</th>

</tr>


<?php

$no=1;

$total_semua=0;


while($d=mysqli_fetch_assoc($data)){


$total = $d['total_kg'] * $d['harga_per_kg'];


$total_semua += $total;


?>


<tr>

<td><?= $no++ ?></td>


<td>
<?= $d['nama_jenis'] ?>
</td>


<td>
<?= $d['total_kg'] ?> Kg
</td>


<td>
Rp <?= number_format($d['harga_per_kg'],0,',','.') ?>
</td>


<td>
Rp <?= number_format($total,0,',','.') ?>
</td>


</tr>


<?php } ?>


<tr>

<td colspan="4">
<b>Total Keseluruhan</b>
</td>


<td>
<b>
Rp <?= number_format($total_semua,0,',','.') ?>
</b>
</td>


</tr>


</table>


</body>
</html>