<?php
session_start();
// Gembok halaman
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

include 'koneksi.php';

// Ambil ID kurir dari URL
if (isset($_GET['id'])) {
    $id_kurir = $_GET['id'];
    
    // Tarik data kurir tersebut dari database
    $query = mysqli_query($koneksi, "SELECT * FROM kurir WHERE id_kurir = '$id_kurir'");
    $data = mysqli_fetch_assoc($query);
    
    if (!$data) {
        header("Location: data_kurir.php");
        exit();
    }
} else {
    header("Location: data_kurir.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kurir - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            top: 0; left: 0;
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
        }
        .sidebar a.active {
            color: white;
            background-color: #1a2536;
            border-left: 4px solid #00d2ff;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">
            <i class="fa-solid fa-soap"></i> AuLaundry
        </div>
        <a href="dashboard_admin.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        <a href="data_pelanggan.php"><i class="fa-solid fa-users"></i> Data Pelanggan</a>
        <a href="data_pesanan.php"><i class="fa-solid fa-file-invoice-dollar"></i> Data Pesanan</a>
        <a href="data_kurir.php" class="active"><i class="fa-solid fa-motorcycle"></i> Data Kurir</a>
        <a href="data_admin.php"><i class="fa-solid fa-user-shield"></i> Data Admin</a>
        <a href="data_karyawan.php"><i class="fa-solid fa-user-tie"></i> Data Karyawan</a>
    </div>

    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold text-dark">Edit Data Kurir</h2>
            <p class="text-muted">Perbarui informasi data armada kurir di bawah ini.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom p-4 bg-white">
                    <form action="proses_edit_kurir.php" method="POST">
                        
                        <input type="hidden" name="id_kurir" value="<?php echo $data['id_kurir']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap Kurir</label>
                            <input type="text" name="nama_kurir" class="form-control" value="<?php echo $data['nama_kurir']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. HP / WhatsApp</label>
                            <input type="number" name="no_hp" class="form-control" value="<?php echo $data['no_hp']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username Akun Kurir</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $data['username']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="text" name="password" class="form-control" value="<?php echo $data['password']; ?>" required>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="update" class="btn btn-warning px-4 py-2 rounded-3 fw-bold text-dark me-2">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Simpan Perubahan
                            </button>
                            <a href="data_kurir.php" class="btn btn-light px-4 py-2 border rounded-3">Batal</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>