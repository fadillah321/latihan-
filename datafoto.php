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
// Koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'dbgaleriw');

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Inisialisasi variabel selected_album dan result_foto
$selected_album = null;
$result_foto = null;

// Periksa apakah album_id diberikan dalam URL
if(isset($_GET['album_id'])) {
    $album_id = $_GET['album_id'];

    // Query untuk mengambil data album berdasarkan album_id yang diberikan
    $query_album = "SELECT * FROM album WHERE album_id = ?";
    $stmt_album = mysqli_prepare($conn, $query_album);
    mysqli_stmt_bind_param($stmt_album, "i", $album_id);
    mysqli_stmt_execute($stmt_album);
    $result_album = mysqli_stmt_get_result($stmt_album);

    // Periksa apakah album ditemukan
    if(mysqli_num_rows($result_album) > 0) {
        $selected_album = mysqli_fetch_assoc($result_album);

        // Query untuk mengambil data foto berdasarkan album_id yang diberikan
        $query_foto = "SELECT * FROM foto WHERE album_id = ?";
        $stmt_foto = mysqli_prepare($conn, $query_foto);
        mysqli_stmt_bind_param($stmt_foto, "i", $album_id);
        mysqli_stmt_execute($stmt_foto);
        $result_foto = mysqli_stmt_get_result($stmt_foto);
    } else {
        // Jika album tidak ditemukan, tampilkan pesan kesalahan
        echo "Album tidak ditemukan.";
        exit();
    }
} else {
    // Jika album_id tidak diberikan dalam URL, tampilkan pesan kesalahan
    echo "Album tidak dipilih.";
    exit();
}

// Jika formulir komentar dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['isi_komentar']) && isset($_POST['foto_id'])) {
    $isi_komentar = $_POST['isi_komentar'];
    $foto_id = $_POST['foto_id'];

    // Pastikan data yang diterima tidak mengandung karakter berbahaya
    $isi_komentar = mysqli_real_escape_string($conn, $isi_komentar);
    $foto_id = mysqli_real_escape_string($conn, $foto_id);

    // Mendapatkan tanggal saat ini
    $tanggal_komentar = date("Y-m-d");

    // Simpan komentar beserta tanggal ke basis data
    $query = "INSERT INTO komentarfoto (foto_id, user_id, isi_komentar, tanggal_komentar) VALUES ('$foto_id', '" . $_SESSION['user_id'] . "', '$isi_komentar', '$tanggal_komentar')";
    if (mysqli_query($conn, $query)) {
        // Redirect kembali ke halaman datafoto.php setelah komentar berhasil disimpan
        header("Location: datafoto.php?album_id=$album_id");
        exit();
    } else {
        // Kirim pesan kesalahan jika terjadi masalah saat menyimpan komentar ke database
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan komentar.'
        );
        echo json_encode($response);
        exit();
    }
}

// Jika permintaan untuk like diterima
if (isset($_GET['like']) && isset($_GET['foto_id'])) {
    $foto_id = $_GET['foto_id'];

    // Periksa apakah album dipilih
    if (!$selected_album) {
        // Jika album tidak dipilih, alihkan kembali ke halaman datafoto.php
        header("Location: datafoto.php");
        exit();
    }

    // Tambahkan like jika album dipilih
    $user_id = $_SESSION['user_id'];
    $tanggal_like = date("Y-m-d");
    mysqli_query($conn,"INSERT INTO likefoto VALUES('', '$foto_id', '$user_id', '$tanggal_like')");

    // Alihkan kembali ke halaman datafoto.php setelah like berhasil ditambahkan
    header("Location: datafoto.php?album_id=$album_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Foto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<style>
     body {
            background-color: #FFEBCD; 
        }
    .navbar {
        background-color: #725E42 ; 
    }
    .navbar-brand {
        color: #fff; /* Warna teks putih */
        font-weight: bold;
        font-size: 30px;
    }
    .navbar ul li a:hover {
        background-color: #3A2B2D;
    }

    .navbar-nav .nav-link {
        color: #fff; /* Warna teks putih */
        font-size: 20px;
    }
    .navbar-nav .nav-link:hover {
        color: #f8f9fa; /* Warna teks putih lebih terang saat hover */
        font-size: 20px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-#dd88dd">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="galeri.php">Galeri</a>
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

<style>
    /* Custom styles */
    .album {
        padding-top: 4rem;
    }
    .album .card {
        border: none;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .album .card:hover {
        transform: scale(1.05);
    }
    .modal-body img {
        width: 100%;
        height: auto;
    }
</style>

<div class="album py-5 bg-color: #FFEBCD">
    <div class="container">
        <h2 class="text-center mb-4"><span style='font-weight: bold;'> <?php echo $selected_album['nama_album']; ?></span></h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($foto = mysqli_fetch_assoc($result_foto)): ?>
                <div class="col">
                    <div class="card" style="max-height: 5000px; overflow:hidden;" data-bs-toggle="modal" data-bs-target="#modal<?php echo $foto['foto_id']; ?>">
                        <img src="img/<?php echo $foto['lokasi_file']; ?>" class="card-img-top" alt="<?php echo $foto['judul_foto']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $foto['judul_foto']; ?></h5>
                            <p class="card-text"><?php echo $foto['deskripsi_foto']; ?></p>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal<?php echo $foto['foto_id']; ?>" tabindex="-1" aria-labelledby="modal<?php echo $foto['foto_id']; ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal<?php echo $foto['foto_id']; ?>Label"><?php echo $foto['judul_foto']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="img/<?php echo $foto['lokasi_file']; ?>" class="img-fluid" alt="<?php echo $foto['judul_foto']; ?>">
                                <p><?php echo $foto['deskripsi_foto']; ?></p>

                                <?php
                                // Query untuk mengambil komentar berdasarkan foto_id
                                $query_komentar = "SELECT * FROM komentarfoto WHERE foto_id = ?";
                                $stmt_komentar = mysqli_prepare($conn, $query_komentar);
                                mysqli_stmt_bind_param($stmt_komentar, "i", $foto['foto_id']);
                                mysqli_stmt_execute($stmt_komentar);
                                $result_komentar = mysqli_stmt_get_result($stmt_komentar);

                                 // Menampilkan komentar dalam modal
while ($komentar = mysqli_fetch_assoc($result_komentar)) {
    if (isset($_SESSION['nama_lengkap'])) {
        $nama_pengguna = $_SESSION['nama_lengkap'];
    } else {
        $nama_pengguna = "Guest";
    }

    echo "<div class='comment'>";
    echo "<p><strong>" . $nama_pengguna . ": </strong>" . htmlspecialchars($komentar['isi_komentar']) . "</p>";
    echo "</div>";
}
                                
                                ?>
                                <!-- Form untuk komentar -->
                                <form id="form_<?php echo $foto['foto_id']; ?>" method="POST" action="datafoto.php?album_id=<?php echo $album_id; ?>">
                                    <div class="mb-3">
                                        <label for="isi_komentar<?php echo $foto['foto_id']; ?>" class="form-label">Your Comment:</label>
                                        <textarea class="form-control" id="isi_komentar<?php echo $foto['foto_id']; ?>" name="isi_komentar" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" name="foto_id" value="<?php echo $foto['foto_id']; ?>">
                                    <!-- Tombol "Submit" -->
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-comment"></i>Submit</button>
                                   <!-- Tombol "Like" -->
                                   <?php
$query_check_like = "SELECT * FROM likefoto WHERE foto_id = ? AND user_id = ?";
$stmt_check_like = mysqli_prepare($conn, $query_check_like);
mysqli_stmt_bind_param($stmt_check_like, "ii", $foto['foto_id'], $_SESSION['user_id']);
mysqli_stmt_execute($stmt_check_like);
$result_check_like = mysqli_stmt_get_result($stmt_check_like);
$liked = mysqli_num_rows($result_check_like) > 0;

if ($liked) {
    // Jika pengguna telah memberi like, tampilkan tombol "Liked"
    echo '<button class="btn btn-danger btn-sm mx-2" disabled><i class="fas fa-heart"></i> Liked</button>';
} else {
    // Jika pengguna belum memberi like, tampilkan tombol "Like"
    echo '<a href="datafoto.php?like=true&foto_id=' . $foto['foto_id'] . '&album_id=' . $selected_album['album_id'] . '" class="btn btn-danger btn-sm mx-2"><i class="far fa-heart"></i> Like</a>';
}
?>


</form>


                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
