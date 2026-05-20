<?php
include('../koneksi.php');

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
$d = mysqli_fetch_array($data);

if(isset($_POST['update'])){

    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $kondisi_barang = $_POST['kondisi_barang'];

    mysqli_query($conn, "UPDATE barang SET
    nama_barang='$nama_barang',
    jumlah='$jumlah',
    kondisi_barang='$kondisi_barang'
    WHERE id_barang='$id'");

    header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>

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

        <h3 class="mb-4">Edit Barang</h3>

        <form method="POST">

            <div class="mb-3">
                <label>Nama Barang</label>

                <input type="text"
                name="nama_barang"
                class="form-control"
                value="<?= $d['nama_barang']; ?>"
                required>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>

                <input type="number"
                name="jumlah"
                class="form-control"
                value="<?= $d['jumlah']; ?>"
                required>
            </div>

            <div class="mb-3">

                <label>Kondisi Barang</label>

                <select name="kondisi_barang"
                class="form-control"
                required>

                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>

                </select>

            </div>

            <button type="submit"
            name="update"
            class="btn btn-primary">

                Update

            </button>

        </form>

    </div>

</div>

</body>
</html>