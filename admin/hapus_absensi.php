<?php

include '../config/koneksi.php';


$id = $_GET['id'];

$back = $_GET['back'] ?? 'absensi.php';


// hapus semua penimbangan nasabah dulu
mysqli_query($conn,
"DELETE FROM penimbangan
WHERE id_nasabah='$id'"
);


// baru hapus nasabah
mysqli_query($conn,
"DELETE FROM absensi
WHERE id_nasabah='$id'"
);



echo "
<script>
alert('Data nasabah berhasil dihapus');
window.location='$back';
</script>
";


?>