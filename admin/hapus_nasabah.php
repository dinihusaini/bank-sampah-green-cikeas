<?php

include '../config/koneksi.php';


$id = $_GET['id'];


mysqli_query($conn,
"DELETE FROM absensi 
WHERE id_nasabah='$id'"
);


header("Location: daftar_nasabah.php");

?>