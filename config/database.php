<?php
// config/database.php — Koneksi ke database db_aulaundry

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = null;

function db() {
    global $pdo;
    if ($pdo === null) {
        $host    = 'localhost';
        $dbname  = 'db_aulaundry';
        $user    = 'root';
        $pass    = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
    return $pdo;
}

// Langsung buat koneksi agar $pdo tersedia
$pdo = db();
