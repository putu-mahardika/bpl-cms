<?php

    // $dbhost = 'localhost';
    // $dbuser = 'root';
    // $dbpass = '';
    // $dbname = 'berkahpe_tracking2';
    
    // SETTING HOST UBAH BAGIAN management-tracking-dev
    $base_url = $_SERVER['HTTP_HOST'] == 'berkahpermatalogistik.com' ? $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/management-tracking-dev' : $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/management-tracking-dev';
    $dbhost = 'srv155.niagahoster.com';
    $dbuser = 'u1732795_berkahpe';
    $dbpass = 'tog57588';
    $dbname = 'u1732795_berkahpe_tracking_demo';

    $timeout = 1000;

    $koneksi = mysqli_init();
    if (!$koneksi) {
        die("mysqli_init failed");
    }

    $koneksi->options(MYSQLI_OPT_CONNECT_TIMEOUT, $timeout);

    // $koneksi = mysqli_connect("$dbhost","$dbuser","$dbpass","$dbname");
    
    // if (mysqli_connect_errno()){
    //     echo "Koneksi database gagal : " . mysqli_connect_error();
    // }

    $koneksi->real_connect("$dbhost","$dbuser","$dbpass","$dbname");

    if ($koneksi->connect_errno){
        echo "Koneksi database gagal : " . mysqli_connect_error();
        exit();
    }

?> 