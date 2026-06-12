<?php
// includes/auth.php — Autentikasi dan otorisasi

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/flash.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Cek apakah user sudah login
 */
function isLoggedIn() {
    return isset($_SESSION['role']);
}

/**
 * Paksa login — redirect jika belum login
 * (Kompatibilitas dengan halaman lama yang masih pakai requireLogin)
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Silakan login terlebih dahulu.'];
        header('Location: /aulaundry/login.php');
        exit;
    }
}

/**
 * Cek role user, redirect jika tidak sesuai
 * @param string $role — 'admin', 'pelanggan', 'karyawan'
 */
function checkRole($role) {
    if (!isLoggedIn()) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Silakan login terlebih dahulu.'];
        header('Location: /aulaundry/login.php');
        exit;
    }

    if ($_SESSION['role'] !== $role) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Anda tidak memiliki akses ke halaman ini.'];
        header('Location: /aulaundry/login.php');
        exit;
    }
}

/**
 * Ambil base URL
 * (Kompatibilitas dengan halaman lama yang masih pakai getBaseUrl)
 */
function getBaseUrl() {
    return '/aulaundry';
}

/**
 * Ambil data user yang sedang login
 */
function currentUser() {
    if (!isLoggedIn()) return null;

    $role = $_SESSION['role'];

    switch ($role) {
        case 'admin':
            $stmt = db()->prepare("SELECT * FROM admin WHERE id_admin = ?");
            $stmt->execute([$_SESSION['id_admin'] ?? 0]);
            return $stmt->fetch();

        case 'pelanggan':
            $stmt = db()->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
            $stmt->execute([$_SESSION['id_pelanggan'] ?? 0]);
            return $stmt->fetch();

        case 'karyawan':
            $stmt = db()->prepare("SELECT * FROM karyawan WHERE id_karyawan = ?");
            $stmt->execute([$_SESSION['id_karyawan'] ?? 0]);
            return $stmt->fetch();

        default:
            return null;
    }
}
