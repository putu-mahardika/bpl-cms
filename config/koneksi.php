<?php

$dbhost = '192.168.100.226';
$dbuser = 'devuser';
$dbpass = 'tog57588';
$dbname = 'devuser_bpl';

    // $koneksi = mysqli_connect("$dbhost","$dbuser","$dbpass","$dbname");
    
    // if (mysqli_connect_errno()){
    //     echo "Koneksi database gagal : " . mysqli_connect_error();
    // }

    $timeout = 150;

    $koneksi = mysqli_init();
    if (!$koneksi) {
        die("mysqli_init failed");
    }

    $koneksi->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

    $koneksi->real_connect("$dbhost","$dbuser","$dbpass","$dbname");

    if ($koneksi->connect_errno){
        echo "Koneksi database gagal : " . mysqli_connect_error();
        exit();
    }

?>
