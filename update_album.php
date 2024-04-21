<?php
session_start();

// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'dbgaleriw');

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Periksa apakah data yang diperlukan disertakan dalam permintaan
if(isset($_POST['album_id'], $_POST['nama_album'], $_POST['deskripsi'])) {
    $album_id = $_POST['album_id'];
    $nama_album = mysqli_real_escape_string($koneksi, $_POST['nama_album']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Query untuk memperbarui detail album dalam database
    $query_update_album = "UPDATE album SET nama_album='$nama_album', deskripsi='$deskripsi' WHERE album_id='$album_id'";
    
    // Eksekusi query
    if(mysqli_query($koneksi, $query_update_album)) {
        // Jika update berhasil, alihkan pengguna kembali ke halaman album.php atau tampilkan pesan berhasil
        header("Location: album.php");
        exit();
    } else {
        // Jika terjadi kesalahan saat menjalankan query, tampilkan pesan kesalahan
        echo "Terjadi kesalahan saat memperbarui album: " . mysqli_error($koneksi);
    }
} else {
    // Jika data yang diperlukan tidak disertakan dalam permintaan, alihkan pengguna kembali ke halaman album.php atau tampilkan pesan kesalahan
    header("Location: album.php");
    exit();
}
?>
