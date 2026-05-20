<?php
include('../koneksi.php');

/*
|--------------------------------------------------------------------------
| PROSES PINJAM BARANG
|--------------------------------------------------------------------------
*/
if(isset($_POST['pinjam'])){

    $id_user = 1;
    $id_barang = $_POST['id_barang'];
    $jumlah_pinjam = $_POST['jumlah_pinjam'];
    $tanggal_pinjam = date('Y-m-d');

    mysqli_query($conn, "INSERT INTO peminjaman
    (id_user, id_barang, jumlah_pinjam, tanggal_pinjam)
    VALUES
    ('$id_user', '$id_barang', '$jumlah_pinjam', '$tanggal_pinjam')");

    mysqli_query($conn, "UPDATE barang
    SET jumlah = jumlah - '$jumlah_pinjam'
    WHERE id_barang='$id_barang'");

    header("location: index.php");
}

/*
|--------------------------------------------------------------------------
| DATA BARANG
|--------------------------------------------------------------------------
*/
$data = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Inventaris</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>

        *{
            font-family:'Segoe UI', sans-serif;
        }

        body{
            background:#f1f5f9;
        }

        .sidebar{
            width:260px;
            height:100vh;
            background:#1e293b;
            position:fixed;
            color:white;
            padding-top:20px;
        }

        .logo{
            font-size:24px;
            font-weight:bold;
            text-align:center;
            margin-bottom:40px;
        }

        .menu a{
            display:block;
            color:#cbd5e1;
            padding:14px 25px;
            text-decoration:none;
            margin:5px 15px;
            border-radius:10px;
            transition:0.3s;
        }

        .menu a:hover,
        .menu .active{
            background:#334155;
            color:white;
        }

        .main{
            margin-left:260px;
            padding:30px;
        }

        .topbar{
            background:white;
            padding:18px 25px;
            border-radius:15px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .table-area{
            background:white;
            padding:25px;
            border-radius:18px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

    </style>

</head>

<body>

<div class="sidebar">

    <div class="logo">USER PANEL</div>

    <div class="menu">

        <a href="index.php" class="active">
            <i class="fa fa-box"></i> Daftar Barang
        </a>

        <a href="../logout.php">
            <i class="fa fa-right-from-bracket"></i> Logout
        </a>

    </div>

</div>

<div class="main">

    <div class="topbar">

        <h4>Daftar Barang</h4>

        <div>User</div>

    </div>

    <div class="table-area">

        <table class="table table-hover align-middle">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

            <?php
            $no = 1;

            while($d = mysqli_fetch_array($data)){
            ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $d['nama_barang']; ?></td>

                    <td><?= $d['jumlah']; ?></td>

                    <td><?= $d['kondisi_barang']; ?></td>

                    <td>

                        <?php if($d['jumlah'] > 0){ ?>

                            <span class="badge bg-success">
                                Tersedia
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-danger">
                                Habis
                            </span>

                        <?php } ?>

                    </td>

                    <td>

                        <?php if($d['jumlah'] > 0){ ?>

                        <form method="POST">

                            <input type="hidden"
                            name="id_barang"
                            value="<?= $d['id_barang']; ?>">

                            <input type="number"
                            name="jumlah_pinjam"
                            class="form-control mb-2"
                            placeholder="Jumlah"
                            min="1"
                            max="<?= $d['jumlah']; ?>"
                            required>

                            <button type="submit"
                            name="pinjam"
                            class="btn btn-primary btn-sm">

                                Pinjam

                            </button>

                        </form>

                        <?php } ?>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>