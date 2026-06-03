<?php
// Mulai sesi
session_start();

// Cek apakah admin memiliki 'tanda pengenal' (sudah login)
// Jika tidak ada status_login atau statusnya bukan true, maka tendang keluar!
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    // Arahkan kembali ke halaman login
    header("Location: login_admin.php");
    exit(); // Hentikan proses agar kode di bawahnya tidak dieksekusi
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #070d19;
            color: white;
            padding-top: 20px;
            z-index: 100;
        }
        .sidebar .brand {
            padding: 10px 25px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #00d2ff;
            border-bottom: 1px solid #1a2536;
            margin-bottom: 20px;
        }
        .sidebar a {
            padding: 12px 25px;
            text-decoration: none;
            font-size: 1rem;
            color: #a3b1cc;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            color: white;
            background-color: #1a2536;
            border-left: 4px solid #00d2ff;
        }
        .sidebar a i {
            margin-right: 10px;
            width: 20px;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card-custom:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">
            <i class="fa-solid fa-soap"></i> AuLaundry
        </div>
        <a href="dashboard_admin.php" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        <a href="data_pelanggan.php"><i class="fa-solid fa-users"></i> Data Pelanggan</a>
        <a href="data_pesanan.php"><i class="fa-solid fa-file-invoice-dollar"></i> Data Pesanan</a>
        <a href="data_kurir.php"><i class="fa-solid fa-motorcycle"></i> Data Kurir</a>
        <a href="data_admin.php"><i class="fa-solid fa-user-shield"></i> Data Admin</a>
        <a href="data_karyawan.php"><i class="fa-solid fa-user-tie"></i> Data Karyawan</a>
        <a href="logout.php" class="text-danger mt-5"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Dashboard Overview</h2>
                <p class="text-muted">Selamat datang kembali, Admin AuLaundry!</p>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-2 fw-semibold">Administrator</span>
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin" class="rounded-circle" width="40" height="40">
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small">Total Karyawan</h6>
                            <h3 class="fw-bold text-dark mb-0">12</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fa-solid fa-user-tie fa-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small">Total Order Hari Ini</h6>
                            <h3 class="fw-bold text-dark mb-0">45</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fa-solid fa-basket-shopping fa-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small">Total Transaksi</h6>
                            <h3 class="fw-bold text-dark mb-0">Rp 1.250.000</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="fa-solid fa-wallet fa-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-custom p-4 bg-white">
            <h5 class="fw-bold text-dark mb-4"><i class="fa-solid fa-chart-line text-primary me-2"></i> Grafik Transaksi Masuk</h5>
            <div style="height: 300px; position: relative;">
                <canvas id="transaksiChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('transaksiChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Transaksi (Rp)',
                    data: [500000, 700000, 650000, 900000, 1200000, 1500000, 1300000, 1600000, 1800000, 1750000, 2000000, 2500000],
                    borderColor: '#0066ff',
                    backgroundColor: 'rgba(0, 102, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>