<?php
session_start();
// Gembok halaman kurir
if (!isset($_SESSION['status_kurir']) || $_SESSION['status_kurir'] != true) {
    header("Location: login_kurir.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kurir - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: #070d19;
        }
        .welcome-banner {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 176, 155, 0.15);
        }
        .card-stat {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card-stat:hover {
            transform: translateY(-3px);
        }
        .badge-pickup { background-color: #ffeeba; color: #856404; }
        .badge-delivery { background-color: #b8daff; color: #004085; }
        .badge-success-custom { background-color: #c3e6cb; color: #155724; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="#">
                <i class="fa-solid fa-motorcycle me-2"></i>AuLaundry <span class="text-white fw-light">Kurir</span>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-white-50 me-3 small d-none d-sm-inline">Sesi: <strong>Aktif</strong></span>
                <a href="logout_kurir.php" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                </a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        
        <div class="welcome-banner mb-4">
            <div class="row align-items-center">
                <div class="col-8 col-md-9">
                    <h3 class="fw-bold mb-1">Semangat Kerja, Mas <?php echo $_SESSION['nama_kurir']; ?>! 🛵💨</h3>
                    <p class="mb-0 text-white-50 small">Cek daftar orderanmu hari ini, antarkan pakaian bersih dan kebahagiaan ke pelanggan!</p>
                </div>
                <div class="col-4 col-md-3 text-end text-white-50">
                    <i class="fa-solid fa-circle-user fa-4x text-white"></i>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="card card-stat p-3 bg-white text-center">
                    <div class="text-warning mb-2"><i class="fa-solid fa-box-open fa-2xl"></i></div>
                    <h6 class="text-muted small text-uppercase mb-1" style="font-size: 0.75rem;">Ambil</h6>
                    <h4 class="fw-bold text-dark mb-0">3</h4>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-stat p-3 bg-white text-center">
                    <div class="text-primary mb-2"><i class="fa-solid fa-truck-fast fa-2xl"></i></div>
                    <h6 class="text-muted small text-uppercase mb-1" style="font-size: 0.75rem;">Kirim</h6>
                    <h4 class="fw-bold text-dark mb-0">2</h4>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-stat p-3 bg-white text-center">
                    <div class="text-success mb-2"><i class="fa-solid fa-square-check fa-2xl"></i></div>
                    <h6 class="text-muted small text-uppercase mb-1" style="font-size: 0.75rem;">Selesai</h6>
                    <h4 class="fw-bold text-dark mb-0">8</h4>
                </div>
            </div>
        </div>

        <div class="card card-stat p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clipboard-list text-success me-2"></i>Tugas Pengiriman Anda</h5>
                <span class="badge bg-secondary rounded-pill">Hari Ini</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th>No. Order</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Tipe Tugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <tr>
                            <td class="fw-bold">#AUL-8801</td>
                            <td>Joko Susanto</td>
                            <td>Jl. Merdeka No. 12, Blok C</td>
                            <td><span class="badge badge-pickup px-2.5 py-1.5 rounded">Penjemputan</span></td>
                            <td><button class="btn btn-sm btn-success rounded-pill px-3 py-1">Ambil</button></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">#AUL-8795</td>
                            <td>Siti Rahma</td>
                            <td>Kost Bahagia, Kamar 2B</td>
                            <td><span class="badge badge-delivery px-2.5 py-1.5 rounded">Antar Laundry</span></td>
                            <td><button class="btn btn-sm btn-primary rounded-pill px-3 py-1">Selesai</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>