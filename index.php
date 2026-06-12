<?php
session_start();
// Jika sudah login, redirect ke dashboard sesuai role
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    switch ($_SESSION['role']) {
        case 'admin':
            header('Location: pages/admin/dashboard.php');
            exit;
        case 'karyawan':
            header('Location: pages/karyawan/dashboard.php');
            exit;
        case 'kurir':
            header('Location: pages/kurir/dashboard.php');
            exit;
        case 'pelanggan':
            header('Location: pages/pelanggan/dashboard.php');
            exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Landing Page - Aulaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { padding-top: 60px; }
        .hero { background: #007bff; color: white; padding: 60px 20px; text-align: center; }
        .login-buttons .btn { margin: 10px; min-width: 150px; }
        footer { margin-top: 60px; padding: 20px 0; background: #f8f9fa; text-align: center; }
    </style>
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Aulaundry</a>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1>Selamat Datang di Aulaundry</h1>
            <p>Layanan laundry terpercaya dengan kualitas terbaik dan harga bersahabat.</p>
            <p>Dapatkan promo menarik dan layanan cepat untuk kebutuhan laundry Anda.</p>
        </div>
    </section>

    <section class="container text-center login-buttons">
        <h2>Login Sebagai</h2>
        <a href="login.php?role=admin" class="btn btn-outline-primary btn-lg">Admin</a>
        <a href="login.php?role=karyawan" class="btn btn-outline-success btn-lg">Karyawan</a>
        <a href="login.php?role=kurir" class="btn btn-outline-warning btn-lg">Kurir</a>
        <a href="login.php?role=pelanggan" class="btn btn-outline-info btn-lg">Pelanggan</a>
    </section>

    <footer>
        &copy; 2026 Aulaundry. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
