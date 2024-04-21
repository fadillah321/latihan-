<?php
include "backend.php";
session_start();

$namaalbum = $_POST['nama_album'];
$deskripsi = $_POST['deskripsi'];
$tanggaldibuat = date('Y-m-d'); // Menggunakan fungsi date() untuk mendapatkan tanggal saat ini
$userid = $_SESSION['user_id'];

$sql = mysqli_query($conn, "INSERT INTO album VALUES('', '$namaalbum', '$deskripsi', '$tanggaldibuat', '$userid')");

header("location:album.php");
?>


