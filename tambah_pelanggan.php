<?php
session_start();
// Gembok halaman: Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - Admin AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; }
        .navbar-admin { background-color: #1a2035; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard_admin.php">
                <i class="fa-solid fa-desktop me-2 text-primary"></i>Panel Admin
            </a>
            <div class="ms-auto">
                <a href="data_pelanggan.php" class="btn btn-sm btn-outline-light rounded-pill"><i class="fa-solid fa-arrow-left me-1"></i> Batal</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <h4 class="fw-bold text-dark"><i class="fa-solid fa-user-plus text-primary me-2"></i>Tambah Pelanggan Baru</h4>
                </div>
                
                <div class="card card-custom p-4 bg-white">
                    <form action="proses_tambah_pelanggan.php" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama pelanggan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Rumah</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">No. Handphone (WhatsApp)</label>
                            <input type="number" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username Akun</label>
                            <input type="text" name="username" class="form-control" placeholder="Buat username unik" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Buat password akun" required>
                        </div>

                        <hr class="text-muted my-4">

                        <div class="d-grid gap-2">
                            <button type="submit" name="simpan" class="btn btn-primary rounded-pill fw-bold py-2 shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pelanggan
                            </button>
                            <a href="data_pelanggan.php" class="btn btn-light rounded-pill py-2 border">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>