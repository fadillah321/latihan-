<?php
session_start();

// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'dbgaleriw');

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Periksa apakah album_id disertakan di URL
if(isset($_GET['album_id'])) {
    $album_id = $_GET['album_id'];
} else {
    // Jika album_id tidak disertakan, alihkan pengguna kembali ke halaman album.php atau tampilkan pesan kesalahan
    header("Location: album.php");
    exit();
}

// Query untuk mengambil data album berdasarkan album_id
$query_album = "SELECT * FROM album WHERE album_id = $album_id";
$result_album = mysqli_query($koneksi, $query_album);

// Periksa apakah album dengan album_id yang diberikan ditemukan
if(mysqli_num_rows($result_album) == 0) {
    // Jika tidak ada album yang cocok dengan album_id, alihkan pengguna kembali ke halaman album.php atau tampilkan pesan kesalahan
    header("Location: album.php");
    exit();
}

// Ambil data album yang dipilih
$selected_album = mysqli_fetch_assoc($result_album);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-color: #FFEBCD; /* Ganti dengan warna latar belakang yang Anda inginkan */
        }
    .navbar {
        background-color: #725E42;
    }
    .navbar ul li a:hover {
            background-color: #3A2B2D;
        }
    .card {
        max-width: 400px; /* Mengatur lebar maksimum kartu */
        margin: 0 auto; /* Mengatur margin atas dan bawah serta membuatnya berada di tengah */
        padding: 20px; /* Menambahkan ruang di dalam kartu */
        background-color:  #93632D; /* Warna latar belakang kartu */
        border: 5px solid #3A2B2D; /* Menambahkan bingkai */
        border-radius: 10px; /* Membuat sudut kartu melengkung */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Menambahkan efek bayangan */
    }

    .form-label,
    .form-control {
        color: #000000; /* Warna teks dan input form */
    }

    .btn-primary {
        background-color: #3A2B2D; /* Warna latar belakang tombol */
        border-color: #725E42; /* Warna border tombol */
    }

    .btn-primary:hover {
        background-color: #725E42; /* Warna latar belakang tombol saat dihover */
        border-color:  #FFF7A9; /* Warna border tombol saat dihover */
    }
</style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-#dd88dd">
    <div class="container-fluid">
        <a class="navbar-brand">Edit Album</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="galeri.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="album.php">Album</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="foto.php">Foto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h5 class="text-center mb-4">Edit Album: <?php echo $selected_album['nama_album']; ?></h5>
    <div class="card">
        <div class="card-body">
            <!-- Formulir untuk mengedit detail album -->
            <form action="update_album.php" method="post">
                <div class="mb-3">
                    <label for="nama_album" class="form-label">Nama Album:</label>
                    <input type="text" class="form-control" id="nama_album" name="nama_album" value="<?php echo $selected_album['nama_album']; ?>">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi:</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo $selected_album['deskripsi']; ?></textarea>
                </div>
                <input type="hidden" name="album_id" value="<?php echo $album_id; ?>">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
