<?php
session_start();
if (!isset($_SESSION['status_pelanggan']) || $_SESSION['status_pelanggan'] != true) {
    header("Location: login_pelanggan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f9f9; font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background-color: #0d233a; }
        .welcome-banner {
            background: linear-gradient(135deg, #007bff, #00d2ff);
            color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.1);
        }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-info" href="#">
                <i class="fa-solid fa-shirt me-2"></i>AuLaundry <span class="text-white fw-light">Pelanggan</span>
            </a>
            <a href="logout_pelanggan.php" class="btn btn-sm btn-outline-danger rounded-pill px-3">Keluar</a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="welcome-banner mb-4">
            <h3 class="fw-bold mb-1">Halo, Kak <?php echo $_SESSION['nama_pelanggan']; ?>! 👋✨</h3>
            <p class="mb-0 text-white-50 small">Selamat datang di layanan laundry kilat digital kami. Pakaian kotormu, biar kami yang urus!</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-custom p-4 bg-white text-center">
                    <div class="text-info mb-3"><i class="fa-solid fa-basket-shopping fa-3x"></i></div>
                    <h5 class="fw-bold">Mau Cuci Baju?</h5>
                    <p class="text-muted small">Klik tombol di bawah untuk meminta kurir menjemput pakaian kotormu langsung ke rumah.</p>
                    <button class="btn btn-info text-white w-100 fw-bold rounded-pill py-2.5">
                        <i class="fa-solid fa-motorcycle me-2"></i>Pesan Penjemputan
                    </button>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-custom p-4 bg-white">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-clock-rotate-left text-info me-2"></i>Status Cucian Anda</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light small text-muted">
                                <tr>
                                    <th>No. Nota</th>
                                    <th>Tanggal</th>
                                    <th>Berat/Pcs</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td class="fw-bold">#ORD-9902</td>
                                    <td>03 Juni 2026</td>
                                    <td>3.5 Kg</td>
                                    <td><span class="badge bg-warning text-dark px-2.5 py-1.5 rounded">Sedang Dicuci</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>