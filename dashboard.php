<?php
session_start(); // Memulai session agar bisa membaca data admin yang login
include('../koneksi.php');

/*
|--------------------------------------------------------------------------
| PROTEKSI HALAMAN
|--------------------------------------------------------------------------
*/
if(!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin'){
    header("location: ../login.php"); 
    exit;
}

// Ambil Nama Lengkap Admin dari Database berdasarkan ID yang sedang login
$nama_admin_tampil = $_SESSION['username']; // Cadangan awal pake username session

if (isset($_SESSION['id_user'])) {
    $id_admin_login = $_SESSION['id_user'];
    $ambil_admin = mysqli_query($conn, "SELECT nama FROM user WHERE id_user = '$id_admin_login'");
    
    // Cek apakah datanya ketemu di database
    if ($ambil_admin && mysqli_num_rows($ambil_admin) > 0) {
        $data_admin = mysqli_fetch_assoc($ambil_admin);
        $nama_admin_tampil = $data_admin['nama']; // Kalau ketemu, pakai nama lengkap asli
    }
}
/*
|--------------------------------------------------------------------------
| SIMPAN DATA BARANG
|--------------------------------------------------------------------------
*/
if(isset($_POST['simpan'])){

    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $kondisi_barang = $_POST['kondisi_barang'];

    mysqli_query($conn, "INSERT INTO barang (nama_barang, jumlah, kondisi_barang)
    VALUES('$nama_barang', '$jumlah', '$kondisi_barang')");

    header("location: dashboard.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| TOTAL BARANG
|--------------------------------------------------------------------------
*/
$totalBarang = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang"));

/*
|--------------------------------------------------------------------------
| TOTAL PEMINJAMAN
|--------------------------------------------------------------------------
*/
$totalPeminjaman = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM peminjaman"));

/*
|--------------------------------------------------------------------------
| TOTAL USER
|--------------------------------------------------------------------------
*/
$totalUser = 0;
$cekUser = mysqli_query($conn, "SHOW TABLES LIKE 'user'");

if(mysqli_num_rows($cekUser) > 0){
    $totalUser = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user"));
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
    <title>Dashboard Inventaris</title>

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
        .card-box{
            border-radius:18px;
            padding:25px;
            color:white;
            position:relative;
            overflow:hidden;
        }
        .card-box i{
            position:absolute;
            right:20px;
            bottom:20px;
            font-size:55px;
            opacity:0.2;
        }
        .bg-primary-custom{
            background:linear-gradient(135deg,#2563eb,#1d4ed8);
        }
        .bg-success-custom{
            background:linear-gradient(135deg,#059669,#047857);
        }
        .bg-dark-custom{
            background:linear-gradient(135deg,#334155,#0f172a);
        }
        .table-area{
            background:white;
            padding:25px;
            border-radius:18px;
            margin-top:30px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }
        .card-form{
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
            margin-top:30px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">INVENTARIS</div>
    <div class="menu">
        <a href="dashboard.php" class="active">
            <i class="fa fa-home"></i> Dashboard
        </a>
        <a href="peminjaman.php">
            <i class="fa fa-handshake"></i> Peminjaman
        </a>
        <a href="../logout.php">
            <i class="fa fa-right-from-bracket"></i> Logout
        </a>
    </div>
</div>

<div class="main">

    <div class="topbar">
        <h4>Dashboard Inventaris</h4>
        <div class="fw-bold text-primary">
            <i class="fa fa-user-shield me-1"></i> <?= $nama_admin_tampil; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card-box bg-primary-custom">
                <h6>Total Barang</h6>
                <h2><?= $totalBarang; ?></h2>
                <i class="fa fa-box"></i>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card-box bg-success-custom">
                <h6>Total Peminjaman</h6>
                <h2><?= $totalPeminjaman; ?></h2>
                <i class="fa fa-handshake"></i>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card-box bg-dark-custom">
                <h6>Total User</h6>
                <h2><?= $totalUser; ?></h2>
                <i class="fa fa-users"></i>
            </div>
        </div>
    </div>

    <div class="table-area">
        <h5 class="mb-4">Data Barang</h5>
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
                    <td>
                        <span class="badge bg-success">
                            <?= $d['kondisi_barang']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if($d['jumlah'] > 0){ ?>
                            <span class="badge bg-primary">Tersedia</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Habis</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $d['id_barang']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?= $d['id_barang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

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
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>
    </div>

</div>

</body>
</html>