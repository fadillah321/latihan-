<?php
session_start();

// Periksa apakah pengguna sudah login
if(isset($_SESSION['nama_lengkap'])) {
    $nama_lengkap = $_SESSION['nama_lengkap'];
} else {
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEB Galeri Foto</title>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link CSS custom -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Menarik dengan Bootstrap 5</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
     body {
            background-color: #FFEBCD; /* Ganti dengan warna latar belakang yang Anda inginkan */
        }

    .navbar {
        background-color: #725E42 ; /* Warna coklat */
        padding: 20px 10px; /* Tambahkan padding atas dan bawah 20px, kiri dan kanan 10px */
        font-size: 20px; /* Ubah ukuran font menjadi 20px */
    }

    .navbar-brand {
        color: #fff; /* Warna teks putih */
        font-weight: bold;
        font-size: 30px;
    }

    .navbar-nav .nav-link {
        color: #fff; /* Warna teks putih */
    }

    .navbar ul li a:hover {
        background-color: #3A2B2D; /* Warna abu-abu coklat gelap saat hover */
    }

    .navbar-nav .nav-link:hover {
        color: #f8f9fa; /* Warna teks putih lebih terang saat hover */
    }

    .container {
        background-color: #fff; /* Warna latar belakang putih */
        padding: 20px; /* Tambahkan padding 20px */
        border-radius: 10px; /* Tambahkan sudut bulat */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan tipis */
    }

    .card {
        background-color: #FFF7A9; /* Warna latar belakang abu-abu muda untuk kartu */
        border: none; /* Hapus garis batas */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan tipis */
    }

    .card-title {
        color: #8B4513; /* Warna teks coklat */
        font-weight: bold; /* Teks tebal */
    }

    .nama-lengkap {
        color: #4d2600; /* Warna teks coklat gelap */
    }
  </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">WEB GALERI FITRI</a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="galeri.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <?php
                    // Periksa apakah ada sesi nama_lengkap yang tersedia
                    if(isset($_SESSION['nama_lengkap'])) {
                        $nama_lengkap = $_SESSION['nama_lengkap'];
                        echo "<h4 class='card-title'>Hallo <span class='nama-lengkap' style='font-weight: bold;'>$nama_lengkap</span> Selamat Datang di Website Galeri Foto</h4>";
                    } else {
                        // Jika tidak ada sesi nama_lengkap yang tersedia, tampilkan pesan lain
                        echo "<h4 class='card-title'>Silakan login terlebih dahulu</h4>";
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

