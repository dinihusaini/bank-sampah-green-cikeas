<?php
include '../config/koneksi.php';

$id = $_GET['id'];
$back = $_GET['back'] ?? 'absensi.php';

$data = mysqli_query($conn, "SELECT * FROM absensi WHERE id_nasabah='$id'");
$d = mysqli_fetch_array($data);

if(isset($_POST['update'])){

    $nama = $_POST['nama_nasabah'];
    $alamat = $_POST['alamat'];
    $no_wa = $_POST['no_wa'];

    mysqli_query($conn, "UPDATE absensi SET
        nama_nasabah='$nama',
        alamat='$alamat',
        no_wa='$no_wa'
        WHERE id_nasabah='$id'
    ");

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
    <title>Edit Absensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7f8;
        }

        .card-edit{
            background:white;
            border-radius:20px;
            padding:30px;
            margin-top:50px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
        }

        .btn-success{
            background:#198754;
            border:none;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card-edit">

        <h3 class="mb-4">
            <i class="bi bi-pencil-square"></i>
            Edit Data Absensi
        </h3>

        <form method="POST">

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama_nasabah"
                class="form-control"
                value="<?= $d['nama_nasabah']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat"
                class="form-control"
                value="<?= $d['alamat']; ?>" required>
            </div>

            <div class="mb-3">
                <label>No WhatsApp</label>
                <input type="text" name="no_wa"
                class="form-control"
                value="<?= $d['no_wa']; ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-success">
                <i class="bi bi-save"></i> Update
            </button>

            <a href="absensi.php" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>