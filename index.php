<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuLaundry - Sistem Manajemen Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #0d233a, #1a4a7b);
            color: white;
            padding: 80px 0 60px;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            margin-bottom: 50px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .role-card {
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            text-align: center;
            padding: 40px 20px;
            text-decoration: none;
            display: block;
            background-color: white;
        }
        .role-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
        }
        /* Warna Khusus Masing-masing Role */
        .card-admin .icon-wrapper { background-color: #e0f2fe; color: #0284c7; }
        .card-kurir .icon-wrapper { background-color: #dcfce7; color: #16a34a; }
        .card-pelanggan .icon-wrapper { background-color: #e0e7ff; color: #4f46e5; }
        
        .role-title {
            color: #334155;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .role-desc {
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="hero-section">
        <div class="container">
            <i class="fa-solid fa-hands-bubbles fa-4x mb-3 text-info"></i>
            <h1 class="fw-bold display-5">Selamat Datang di AuLaundry</h1>
            <p class="lead text-white-50 max-w-2xl mx-auto">Sistem manajemen laundry cerdas, cepat, dan terpercaya. Silakan pilih portal masuk sesuai dengan peran Anda di bawah ini.</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4 justify-content-center">
            
            <div class="col-md-4">
                <a href="login_pelanggan.php" class="role-card card-pelanggan">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-shirt"></i>
                    </div>
                    <h4 class="role-title">Portal Pelanggan</h4>
                    <p class="role-desc">Pesan layanan cuci, cek status order, dan riwayat transaksi dengan mudah.</p>
                </a>
            </div>

            <div class="col-md-4">
                <a href="login_kurir.php" class="role-card card-kurir">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-motorcycle"></i>
                    </div>
                    <h4 class="role-title">Portal Kurir</h4>
                    <p class="role-desc">Cek tugas penjemputan dan pengantaran laundry pakaian pelanggan hari ini.</p>
                </a>
            </div>

            <div class="col-md-4">
                <a href="login_admin.php" class="role-card card-admin">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-desktop"></i>
                    </div>
                    <h4 class="role-title">Portal Admin</h4>
                    <p class="role-desc">Manajemen penuh data pelanggan, kurir, pesanan, dan laporan keuangan.</p>
                </a>
            </div>

        </div>
    </div>

    <div class="text-center text-muted small pb-4">
        &copy; 2026 AuLaundry System. All rights reserved.
    </div>

</body>
</html>