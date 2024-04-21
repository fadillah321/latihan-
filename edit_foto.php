<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFEBCD; /* Ganti dengan warna latar belakang yang Anda inginkan */
        }

        .navbar {
            background-color: #725E42;
        }

        .navbar ul li a:hover {
            background-color: #3A2B2D;
        }

        .form-container {
            background-color: #725E42;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            color: #fff;
            max-width: 500px; /* Menambahkan batasan lebar maksimum untuk form */
            margin: 50px auto; /* Memposisikan form di tengah halaman */
        }

        .form-container h1 {
            color: #fff;
            margin-top: 0;
            margin-bottom: 20px; /* Menambahkan ruang di bawah judul */
        }

        input[type="text"],
        select {
            width: calc(100% - 22px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="file"] {
            width: calc(100% - 22px);
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #fff;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3A2B2D;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand">Halaman Edit Foto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
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
                </ul>
            </div>
        </div>
    </nav>

        
        <div class="container text-center">
    <p>Selamat datang <b><?=$_SESSION['nama_lengkap']?></b></p>
    
    <div class="form-container">
        <form action="update_foto.php" method="post" enctype="multipart/form-data">
            <?php
                include "backend.php";
                $foto_id=$_GET['foto_id'];
                $sql=mysqli_query($conn,"select * from foto where foto_id='$foto_id'");
                while($data=mysqli_fetch_array($sql)){
            ?>
            <input type="text" name="foto_id" value="<?=$data['foto_id']?>" hidden>
            <table>
                <tr>
                    <td>Judul</td>
                    <td><input type="text" name="judul_foto" value="<?=$data['judul_foto']?>"></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><input type="text" name="deskripsi_foto" value="<?=$data['deskripsi_foto']?>"></td>
                </tr>
                <tr>
                    <td>Foto Saat Ini</td>
                    <td>
                        <?php 
                            if (!empty($data['lokasi_file'])) {
                                echo '<img src="img/' . $data['lokasi_file'] . '" width="100">';
                            } else {
                                echo 'Foto tidak tersedia';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Upload Foto Baru</td>
                    <td><input type="file" name="lokasi_file"></td>
                </tr>
                <tr>
                    <td>Album</td>
                    <td>
                        <select name="album_id">
                        <?php
                            $user_id=$_SESSION['user_id'];
                            $sql2=mysqli_query($conn,"select * from album where user_id='$user_id'");
                            while($data2=mysqli_fetch_array($sql2)){
                        ?>
                                <option value="<?=$data2['album_id']?>" <?php if($data2['album_id']==$data['album_id']){echo 'selected';}?>><?=$data2['nama_album']?></option>
                        <?php
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Ubah"></td>
                </tr>
            </table>
            <?php
                }
            ?>
        </form>
    </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
