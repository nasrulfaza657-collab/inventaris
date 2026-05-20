<?php
session_start();
include('../koneksi.php');

/*
|--------------------------------------------------------------------------
| PROTEKSI HALAMAN ADMIN
|--------------------------------------------------------------------------
*/
if(!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin'){
    header("location: ../login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| DATA PEMINJAMAN
|--------------------------------------------------------------------------
*/
$data = mysqli_query($conn, "
    SELECT 
        peminjaman.*,
        user.nama AS nama_user,
        barang.nama_barang
    FROM peminjaman
    LEFT JOIN user ON peminjaman.id_user = user.id_user
    LEFT JOIN barang ON peminjaman.id_barang = barang.id_barang
    ORDER BY peminjaman.id_pinjam DESC
");

// Cek jika query error
if (!$data) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

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
    <div class="logo">INVENTARIS</div>
    <div class="menu">
        <a href="dashboard.php">
            <i class="fa fa-home"></i> Dashboard
        </a>
        <a href="peminjaman.php" class="active">
            <i class="fa fa-handshake"></i> Peminjaman
        </a>
        <a href="../logout.php">
            <i class="fa fa-right-from-bracket"></i> Logout
        </a>
    </div>
</div>

<div class="main">
    <div class="topbar">
        <h4>Data Peminjaman</h4>
        <div class="fw-bold text-primary"><i class="fa fa-user-shield me-1"></i> <?= $_SESSION['username']; ?></div>
    </div>

    <div class="table-area">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Pinjam</th>
                    <th>Tanggal Pinjam</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            while($d = mysqli_fetch_array($data)){
                
                // Menentukan nama yang tampil (Bersih tanpa teks deteksi ID)
                if (!empty($d['nama_user'])) {
                    $nama_tampil = $d['nama_user'];
                } else {
                    $nama_tampil = "<span class='badge bg-danger'>ID User (".$d['id_user'].") Tidak Terdaftar</span>";
                }
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $nama_tampil; ?></td>
                    <td><?= $d['nama_barang']; ?></td>
                    <td><?= $d['jumlah_pinjam']; ?></td>
                    <td><?= $d['tanggal_pinjam']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>