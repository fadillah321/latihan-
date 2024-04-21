<?php
    include "backend.php";
    session_start();

    $album_id=$_GET['album_id'];
    
    $sql=mysqli_query($conn,"delete from album where album_id='$album_id'");

    header("location:album.php");
?>