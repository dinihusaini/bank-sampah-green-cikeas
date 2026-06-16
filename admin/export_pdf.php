<?php
include '../config/koneksi.php';
?>

<h2>Laporan Panitia</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Keterangan</th>
    <th>Total</th>
</tr>

<?php
$pemasukan = mysqli_query($conn, "
SELECT SUM(p.berat * j.harga_pengepul) as total
FROM penimbangan p
JOIN jenis_sampah j ON p.id_jenis = j.id_jenis
");
$p = mysqli_fetch_assoc($pemasukan);

$pengeluaran = mysqli_query($conn, "
SELECT SUM(p.berat * j.harga_nasabah) as total
FROM penimbangan p
JOIN jenis_sampah j ON p.id_jenis = j.id_jenis
");
$e = mysqli_fetch_assoc($pengeluaran);

$keuntungan = $p['total'] - $e['total'];
?>

<tr>
    <td>Pemasukan</td>
    <td>Rp <?= number_format($p['total']); ?></td>
</tr>

<tr>
    <td>Pengeluaran</td>
    <td>Rp <?= number_format($e['total']); ?></td>
</tr>

<tr>
    <td><b>Keuntungan</b></td>
    <td><b>Rp <?= number_format($keuntungan); ?></b></td>
</tr>

</table>

<script>
window.print();
</script>