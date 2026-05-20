<?php
session_start();
include('../koneksi.php');

// Proteksi halaman keamanan
if(!isset($_SESSION['username']) || $_SESSION['role'] !== 'peminjam'){
    header("location: ../login.php");
    exit;
}

if(isset($_POST['pinjam'])){

    // INI DIA! Mengambil ID User asli dari session login (Otomatis ID: 3 jika Budi yang login)
    $id_user = $_SESSION['id_user']; 
    
    $id_barang = $_POST['id_barang'];
    $jumlah_pinjam = $_POST['jumlah_pinjam'];
    $tanggal_pinjam = date('Y-m-d'); // Otomatis mencatat tanggal hari ini

    // 1. Jalankan query INSERT ke tabel peminjaman
    $query_input = "INSERT INTO peminjaman (id_user, id_barang, jumlah_pinjam, tanggal_pinjam) 
                    VALUES ('$id_user', '$id_barang', '$jumlah_pinjam', '$tanggal_pinjam')";
                    
    $simpan = mysqli_query($conn, $query_input);

    if($simpan){
        // 2. POTONG STOK BARANG OTOMATIS (Opsional tapi bagus agar stok berkurang setelah dipinjam)
        mysqli_query($conn, "UPDATE barang SET jumlah = jumlah - '$jumlah_pinjam' WHERE id_barang = '$id_barang'");

        // 3. Kembalikan ke halaman utama user dengan notifikasi sukses (bisa dikembangkan nanti)
        echo "<script>
                alert('Peminjaman berhasil diajukan!');
                window.location='index.php';
              </script>";
        exit;
    } else {
        echo "Gagal memproses peminjaman: " . mysqli_error($conn);
    }
} else {
    header("location: index.php");
    exit;
}
?>