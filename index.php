<?php
session_start();

// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'dbgaleriw');

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Query untuk mengambil data album
$query_album = "SELECT * FROM album";
$result_album = mysqli_query($koneksi, $query_album);

// Array warna latar belakang untuk setiap kartu
$colors = ["#ffcccc", "#ffcccc", "#ffcccc", "#ffcccc", "#ffcccc", "#ffcccc"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-color: #FFEBCD; /* Ganti dengan warna latar belakang yang Anda inginkan */
        }
        .navbar {
            background-color: #725E42; 
        }
        .navbar-brand {
            color: #fff; 
            font-weight: bold;
            font-size: 30px ;
        }
        .navbar ul li a:hover {
            background-color: #3A2B2D;
        }

        .navbar-nav .nav-link {
            color: #fff; 
            font-size: 20px ;
        }
        .navbar-nav .nav-link:hover {
            color: #fff; 
            font-size: 20px ;
        }
        /* Tambahkan gaya untuk card */
        .card {
            width: 15rem; /* Lebar kartu */
            margin-bottom: 30px; /* Jarak antara kartu */
            border: 5px solid #725E42; /* Tambahkan bingkai */
            border-radius: 30px; /* Bentuk sudut */
            background-color: #FFF7A9;
            
        }
        /* Gaya untuk gambar di dalam kartu */
        .card-img-top { 
            width: 100%; /* Lebar gambar */
            height: auto; /* Tinggi otomatis */
            border-top-left-radius: 10px; /* Sudut atas kiri */
            border-top-right-radius: 10px; /* Sudut atas kanan */
        }
        /* Gaya untuk peringatan */
        .alert {
            margin-top: 20px; /* Jarak dari atas navbar */
            margin-bottom: 20px; /* Jarak dari card */
        }
    </style>
</head>
<body>
 
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" >Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        </div>
    </div>
</nav>

<div class="container">
    <!-- Peringatan untuk registrasi atau login -->
    <div class="alert alert-warning text-center" role="alert">
        Jika Anda belum memiliki akun, Anda bisa <a href="register.php" class="alert-link">registrasi</a>. Jika sudah memiliki akun, Anda bisa <a href="login.php" class="alert-link">login</a> untuk mengunggah foto.
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php 
            $index = 0; // Untuk mengatur indeks warna latar belakang
            while ($row_album = mysqli_fetch_assoc($result_album)): 
        ?>
            <div class="col">
                <div class="card"<?php echo $colors[$index]; ?>>
                    <img src="flow.png" class="card-img-top" alt="Album Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row_album['nama_album']; ?></h5>
                        <p class="card-text"><?php echo $row_album['deskripsi']; ?></p>
                     
                    </div>
                </div>
            </div>
            <?php 
                // Pindah ke warna latar belakang berikutnya atau kembali ke awal jika sudah mencapai akhir array
                $index = ($index + 1) % count($colors); 
            ?>
        <?php endwhile; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
