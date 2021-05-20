<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'berkahpe_tracking';

    $koneksi = mysqli_connect("$dbhost","$dbuser","$dbpass","$dbname");
    
    if (mysqli_connect_errno()){
        echo "Koneksi database gagal : " . mysqli_connect_error();
    }

?>