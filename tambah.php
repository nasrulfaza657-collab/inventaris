<?php
include('../koneksi.php');

if(isset($_POST['simpan'])){

    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $kondisi_barang = $_POST['kondisi_barang'];

    mysqli_query($conn, "INSERT INTO barang (nama_barang, jumlah, kondisi_barang)
    VALUES('$nama_barang', '$jumlah', '$kondisi_barang')");

    header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f1f5f9;
            font-family:'Segoe UI';
        }

        .main{
            width:500px;
            margin:50px auto;
        }

        .card-form{
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

<div class="main">

    <div class="card-form">

        <h3 class="mb-4">Tambah Barang</h3>

        <form method="POST">

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kondisi Barang</label>

                <select name="kondisi_barang" class="form-control" required>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>

            <button type="submit" name="simpan" class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>

</div>

</body>
</html>