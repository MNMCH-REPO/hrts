<?php
      $dsn = 'mysql:host=mnmch.com;dbname=mnmchcom_hrts;charset=utf8';
      $username = 'mnmchcom';
      $password = '&rh{Q.DYFE[O';


    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }