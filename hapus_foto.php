<?php
    include "backend.php";
    session_start();

    $foto_id=$_GET['foto_id'];

    $sql=mysqli_query($conn,"delete from foto where foto_id='$foto_id'");

    header("location:foto.php");
?>