<?php

    // Database connection settings
    $useHosted = false; // Set to true if using hosted database
    
    if ($useHosted) {
      $dsn = 'mysql:host=mnmch.com;dbname=mnmchcom_hrts;charset=utf8';
      $username = 'mnmchcom';
      $password = '&rh{Q.DYFE[O';
    }
    else {
      $dsn = 'mysql:host=localhost;dbname=mnmch_hrts_db;charset=utf8';
      $username = 'root';
      $password = '';
    }

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }