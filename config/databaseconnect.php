<?php
//Ce code crée la connexion PDO avec ta base MySQL.
// config/databaseconnect.php

require_once(__DIR__ . '/mysql.php');

try {
    $mysqlClient = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
//fin du code connexion pdo
