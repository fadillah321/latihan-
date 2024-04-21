<?php

// Connection
$conn = mysqli_connect('localhost', 'root', '', 'dbgaleriw');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Login
if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    
    $check = mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
   
    if(mysqli_num_rows($check) > 0){
        $user = mysqli_fetch_assoc($check);
        // Verify password
        if(password_verify($password, $user['password'])){
            $_SESSION['slogin'] = true;
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['status'] = 'login';
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Password salah
            $error_message = "Password salah";
        }
    } else{
        // Username tidak ditemukan
        $error_message = "Username atau Password salah";
    }

    // Tampilkan pesan kesalahan (jika ada)
    if(isset($error_message)){
        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
    }
}

// Register
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password']; // Password belum di-hash
    $email = $_POST['email'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];

    // Hash password (disarankan)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert = mysqli_query($conn, "INSERT INTO user (username, password, email, nama_lengkap, alamat) VALUES ('$username', '$hashed_password', '$email', '$namalengkap', '$alamat')");

    if($insert){
        echo '<script>alert("Pendaftaran berhasil. Silakan login."); window.location.href="login.php";</script>';
        exit();
    } else {
        echo '<script>alert("Gagal Meregistrasi"); window.location.href="register.php";</script>';
        exit();
    }
    
}

?>
