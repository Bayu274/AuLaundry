<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

// Ambil ID pesanan dari URL
if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];
    
    // Ambil data transaksi lama beserta nama pelanggannya
    $query = mysqli_query($koneksi, "SELECT pesanan.*, pelanggan.nama_pelanggan 
                                     FROM pesanan 
                                     INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.id_pelanggan 
                                     WHERE id_pesanan = '$id_pesanan'");
    $data = mysqli_fetch_assoc($query);
    
    if (!$data) {
        header("Location: data_pesanan.php");
        exit();
    }
} else {
    header("Location: data_pesanan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status Pesanan - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background-color: #070d19; color: white; padding-top: 20px; z-index: 100; }
        .sidebar .brand { padding: 10px 25px; font-size: 1.5rem; font-weight: bold; color: #00d2ff; border-bottom: 1px solid #1a2536; margin-bottom: 20px; }
        .sidebar a { padding: 12px 25px; text-decoration: none; font-size: 1rem; color: #a3b1cc; display: block; }
        .sidebar a.active { color: white; background-color: #1a2536; border-left: 4px solid #00d2ff; }
        .main-content { margin-left: 260px; padding: 30px; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-soap"></i> AuLaundry</div>
        <a href="dashboard_admin.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        <a href="data_pelanggan.php"><i class="fa-solid fa-users"></i> Data Pelanggan</a>
        <a href="data_pesanan.php" class="active"><i class="fa-solid fa-file-invoice-dollar"></i> Data Pesanan</a>
        <a href="data_kurir.php"><i class="fa-solid fa-motorcycle"></i> Data Kurir</a>
        <a href="data_admin.php"><i class="fa-solid fa-user-shield"></i> Data Admin</a>
        <a href="data_karyawan.php"><i class="fa-solid fa-user-tie"></i> Data Karyawan</a>
    </div>

    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold text-dark">Update Status Pesanan</h2>
            <p class="text-muted">Perbarui status pengerjaan atau detail transaksi nota <?php echo $data['no_pesanan']; ?>.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom p-4 bg-white">
                    <form action="proses_edit_pesanan.php" method="POST">
                        
                        <input type="hidden" name="id_pesanan" value="<?php echo $data['id_pesanan']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. Pesanan</label>
                            <input type="text" class="form-control bg-light fw-bold" value="<?php echo $data['no_pesanan']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pelanggan</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $data['nama_pelanggan']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Layanan</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $data['jenis_layanan']; ?>" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Berat (Kg)</label>
                                <input type="number" step="0.1" name="berat" class="form-control" value="<?php echo $data['berat']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Total Harga (Rp)</label>
                                <input type="number" name="total_harga" class="form-control" value="<?php echo $data['total_harga']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status Pengerjaan</label>
                            <select name="status_pesanan" class="form-select">
                                <option value="Menunggu" <?php echo ($data['status_pesanan'] == 'Menunggu') ? 'selected' : ''; ?>>Menunggu / Antrian</option>
                                <option value="Diproses" <?php echo ($data['status_pesanan'] == 'Diproses') ? 'selected' : ''; ?>>Diproses Cuci</option>
                                <option value="Selesai" <?php echo ($data['status_pesanan'] == 'Selesai') ? 'selected' : ''; ?>>Selesai / Siap Ambil</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="update" class="btn btn-warning px-4 py-2 rounded-3 fw-bold text-dark me-2">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Simpan Perubahan
                            </button>
                            <a href="data_pesanan.php" class="btn btn-light px-4 py-2 border rounded-3">Batal</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>