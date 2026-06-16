<?php

include '../config/koneksi.php';

$data = mysqli_query($conn,
"SELECT * FROM absensi
WHERE nama_nasabah NOT IN ('Panitia','admin BS')"
);

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

.tanggal{
    width:100px;
    text-align:center;
    white-space:nowrap;
}

.no{
    width:40px;
    text-align:center;
}

</style>


<h2 align="center">
Laporan Daftar Nasabah
</h2>


<table border="1" 
width="100%"
cellpadding="8"
cellspacing="0">


<tr>

<th class="no">No</th>
<th>Nama</th>
<th>Alamat</th>
<th>No WA</th>
<th class="tanggal">Tanggal</th>

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
<?= $d['alamat'] ?>
</td>

<td>
<?= $d['no_wa'] ?>
</td>

<td class="tanggal">
<?= date('d-m-Y', strtotime($d['tanggal'])) ?>
</td>


</tr>


<?php } ?>


</table>