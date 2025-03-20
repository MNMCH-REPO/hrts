<?php
     $dsn = 'mysql:host=srv1632.hstgr.io;dbname=u643738716_mnmch_hrts_db;charset=utf8';
     $username = 'u643738716_root';
     $password = 'MNMCH&db00';

    //  $dsn = 'mysql:host=localhost;dbname=mnmch_hrts_db;charset=utf8';
    //  $username = 'root';
    //  $password = '';


    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }