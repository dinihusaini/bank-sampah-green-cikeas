<?php

include '../config/koneksi.php';


$id = $_GET['id'];


mysqli_query($conn,
"DELETE FROM penimbangan 
WHERE id_penimbangan='$id'"
);


$back = $_GET['back'] ?? 'penimbangan.php';


echo "
<script>
alert('Data berhasil dihapus');
window.location='$back';
</script>
";


?>