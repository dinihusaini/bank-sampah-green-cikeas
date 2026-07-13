<?php

include '../config/koneksi.php';


$id = $_GET['id'];

$back = $_GET['back'] ?? 'absensi.php';


mysqli_query($conn,
"DELETE FROM penimbangan
WHERE id_nasabah='$id'"
);


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
