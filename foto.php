<?php
session_start();

// Periksa apakah sesi pengguna telah ditetapkan
if (!isset($_SESSION['user_id'])) {
    // Jika tidak, arahkan pengguna kembali ke halaman login
    header("Location: login.php");
    exit(); // Pastikan untuk keluar dari skrip setelah mengarahkan pengguna
}
    include "backend.php";

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $nama_lengkap = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : null;

    if(isset($_POST['submit'])) {
        include "upload_foto.php"; 
    }

    $foto_data = array();
    if($user_id) {   
        $sql = "SELECT foto.*, album.nama_album 
                FROM foto 
                INNER JOIN album ON foto.album_id = album.album_id
                WHERE foto.user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $foto_data [] = $row;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Foto</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Font keluarga Arial */
            margin: 0;
            padding: 0;
            background-color: #FFEBCD; 
        }

        /* Gaya untuk navbar */
        .navbar {
            background-color: 	#725E42;
            overflow: hidden;
            position: fixed;
            top: 0;
            width: 100%;
            height: 80px; 
        }
        .navbar-brand {
            color: #fff; 
            font-weight: bold;
            font-size: 25px ;
        }

        .navbar a {
            display: inline-block;
            color: #fff;
            text-align: center;
            padding: 28px 16px; /* Menaikkan posisi teks ke tengah navbar */
            text-decoration: none;
        }

        .navbar .right-menu {
            float: right;
        }

        .navbar ul li a:hover {
            background-color:  #3A2B2D;
        }

        /* Gaya untuk konten */
        .content {
            margin-top: 100px; 
            padding: 20px;
        }

        /* Gaya untuk form unggah */
        .upload-box {
            width: 50%;
            margin: 20px auto;
            background-color:  #93632D;
            padding: 20px;
            border-radius: 30px; /* Mengubah sudut menjadi oval */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .upload-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .upload-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #93632D; 
            border: none;
            border-radius: 30px; 
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .upload-box input[type="submit"]:hover {
            background-color: #3A2B2D; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFF7A9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #725E42; 
            color: #fff;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table img {
            max-width: 100px;
            height: auto;
        }

        .welcome-message {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="navbar">
<a class="navbar-brand" href="">Upload Foto</a>
    <div class="right-menu">
        <a href="dashboard.php" cgalerilass="active">Home</a>
        <a href="galeri.php">Galeri</a>
        <a href="album.php">Album</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

    <div class="content">
        <div class="upload-box">
        <p>Hallo <b><?=$_SESSION['nama_lengkap']?></b></p>
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Judul</td>
                        <td><input type="text" name="judul_foto"></td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td><input type="text" name="deskripsi_foto"></td>
                    </tr>
                    <tr>
                        <td>Lokasi File</td>
                        <td><input type="file" name="lokasi_file"></td>
                    </tr>
                    <tr>
                        <td>Album</td>
                        <td>
                            <select name="album_id">
                                <?php
                                    include "backend.php";
                                    $user_id = $_SESSION['user_id']; // Gunakan $_SESSION['user_id'] untuk mendapatkan ID pengguna
                                    $sql = mysqli_query($conn, "SELECT * FROM album WHERE user_id='$user_id'");
                                    while($data = mysqli_fetch_array($sql)){
                                ?>
                                    <option value="<?=$data['album_id']?>"><?=$data['nama_album']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Tambah"></td>
                    </tr>
                </table>
            </form>
        </div>

        <table border="1" cellpadding=5 cellspacing=0>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal Unggah</th>
                <th>Lokasi File</th>
                <th>Album</th>
                <th>Disukai</th>
                <th>Aksi</th>
            </tr>
            <?php
                include "backend.php";
                $sql = mysqli_query($conn, "SELECT * FROM foto,album WHERE foto.user_id='$user_id' AND foto.album_id=album.album_id");
                while($data = mysqli_fetch_array($sql)){
            ?>
                    <tr>
                        <td><?=$data['foto_id']?></td>
                        <td><?=$data['judul_foto']?></td>
                        <td><?=$data['deskripsi_foto']?></td>
                        <td><?=$data['tanggal_unggah']?></td>
                        <td>
                            <img src="img/<?=$data['lokasi_file']?>" width="100px">
                        </td>
                        <td><?=$data['nama_album']?></td>
                        <td>
                            <?php
                                $foto_id = $data['foto_id'];
                                $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE foto_id='$foto_id'");
                                echo mysqli_num_rows($sql2);
                            ?>
                        </td>
                        <td>
                            <a href="hapus_foto.php?foto_id=<?=$data['foto_id']?>"><button type="submit" style="background-color: #B22222; padding: 5px 10px; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Hapus</button> 
                            <a href="edit_foto.php?foto_id=<?=$data['foto_id']?>"><button type="submit" style="background-color: #778899; padding: 5px 10px; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Edit</button>
                        </td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>


