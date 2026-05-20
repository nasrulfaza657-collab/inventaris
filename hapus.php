<?php
include('../koneksi.php');

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");

header("location:index.php");
?>