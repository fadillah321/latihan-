<?php
    include "backend.php";
    session_start();

    $judul_foto = $_POST['judul_foto'];
    $deskripsi_foto = $_POST['deskripsi_foto'];
    $album_id = $_POST['album_id'];
    $tanggal_unggah = date("Y-m-d");
    $user_id = $_SESSION['user_id'];

    $rand = rand();
    $ekstensi =  array('png','jpg','jpeg','gif');
    $filename = $_FILES['lokasi_file']['name'];
    $ukuran = $_FILES['lokasi_file']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
    if(!in_array($ext, $ekstensi)) {
        header("location: foto.php");
    } else {
        if($ukuran < 1044070) {		
            $xx = $rand.'_'.$filename;
            move_uploaded_file($_FILES['lokasi_file']['tmp_name'], 'img/'.$rand.'_'.$filename);
            mysqli_query($conn, "INSERT INTO foto VALUES(NULL, '$judul_foto', '$deskripsi_foto', '$tanggal_unggah', '$xx', '$album_id', '$user_id')");
            header("location: foto.php");
        } else {
            header("location: foto.php");
        }
    }
?>
