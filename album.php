<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Album</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFEBCD;
        }

        .navbar {
            background-color: #725E42;
            padding: 20px 0;
        }

        .navbar-brand {
            color: #fff;
            font-weight: bold;
            font-size: 25px;
            padding: 20px;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-left {
            flex: 1;
        }

        .navbar-right {
            flex: 1;
            text-align: right;
        }

        .nav-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu li {
            display: inline;
            margin-right: 10px;
        }

        .nav-menu li a {
            text-decoration: none;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 18px;
        }

        .navbar ul li a:hover {
            background-color: #3A2B2D;
        }

        .logout-btn {
            background-color: #3A2B2D;
            border: none;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #93632D;
        }

        .center-text {
            text-align: center;
        }

        .upload-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
        }

        .upload-form {
            background-color: #93632D;
            border-radius: 20px;
            padding: 20px;
            width: 40%;
            max-width: 600px;
        }

        .upload-form label,
        .upload-form input[type="text"],
        .upload-form input[type="submit"] {
            display: block;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .upload-form input[type="text"],
        .upload-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #FFF7A9;
            border: none;
            border-radius: 30px;
            color: #000000;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .upload-form input[type="submit"]:hover {
            background-color:  #725E42;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFF7A9;
        }

        table th,
        table td {
            border: 1px solid #FFF7A9;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #725E42;
            color: #fff;
        }

        .album-header,
        .desc-header {
            width: 150px;
        }

        .album-data,
        .desc-data {
            width: 250px;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .btn-edit {
            padding: 5px 10px;
            background-color:  #778899;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-edit {
            padding: 5px 10px;
            background-color:  #B22222;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-delete:hover,
        .btn-edit:hover {
            background-color:  #725E42;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-left">
                <a class="navbar-brand">Upload Album</a>
            </div>
            <div class="navbar-right">
                <ul class="nav-menu">
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="foto.php">Foto</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="center-text">
        <h4>Hallo <b><?=$_SESSION['nama_lengkap']?>!!</b></h4>
    </div>

    <div class="upload-container">
        <form action="tambah_album.php" method="post" class="upload-form">
            <label for="nama_album">Nama Album:</label>
            <input type="text" id="nama_album" name="nama_album">
            <label for="deskripsi">Deskripsi:</label>
            <input type="text" id="deskripsi" name="deskripsi">
            <input type="submit" value="Tambah">
        </form>
    </div>

    <table border="1" cellpadding=5 cellspacing=0>
        <?php
            include "backend.php";
            
            // Menampilkan data dalam tabel
            $sql = mysqli_query($conn, "SELECT * FROM album");
            echo "<table border='1'>
            <tr>
            <th>ID</th>
            <th>Nama Album</th> 
            <th>Deskripsi</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
            </tr>";
            
            while ($row = mysqli_fetch_assoc($sql)) {
                echo "<tr>";
                echo "<td>" . $row['album_id'] . "</td>";
                echo "<td>" . $row['nama_album'] . "</td>";
                echo "<td>" . $row['deskripsi'] . "</td>";
                echo "<td>" . $row['tanggal_dibuat'] . "</td>";
                echo "<td> 
                <a href='hapus_album.php?album_id=" . $row['album_id'] . "' class='btn-edit'>Hapus</a>
                        <a href='edit_album.php?album_id=" . $row['album_id'] . "' class='btn-edit'>Edit</a>
                    </td>";
                echo "</tr>";
            }
            
            echo "</table>";
            
            mysqli_close($conn);
        ?>
    </table>
</body>
</html>
