<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

// Fitur otomatisasi: Generate Nomor Pesanan Unik (Contoh: AUL-260001)
$tahun_bulan = date('ym'); // Format: 2606 (Tahun 2026, Bulan Juni)
$query_nota = mysqli_query($koneksi, "SELECT MAX(no_pesanan) as max_nota FROM pesanan WHERE no_pesanan LIKE '#AUL-$tahun_bulan%'");
$data_nota = mysqli_fetch_assoc($query_nota);
$nota_terakhir = $data_nota['max_nota'];

if ($nota_terakhir) {
    $no_urut = substr($nota_terakhir, 9, 3);
    $no_urut = (int)$no_urut + 1;
} else {
    $no_urut = 1;
}
$nota_otomatis = "#AUL-" . $tahun_bulan . sprintf("%03d", $no_urut);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan - AuLaundry</title>
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
            <h2 class="fw-bold text-dark">Tambah Pesanan Baru</h2>
            <p class="text-muted">Input transaksi laundry masuk dari konsumen.</p>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card card-custom p-4 bg-white">
                    <form action="proses_tambah_pesanan.php" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. Pesanan / Nota (Otomatis)</label>
                            <input type="text" name="no_pesanan" class="form-control bg-light fw-bold text-primary" value="<?php echo $nota_otomatis; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Pelanggan</label>
                            <select name="id_pelanggan" class="form-select" required>
                                <option value="">-- Pilih Konsumen --</option>
                                <?php
                                $query_pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY nama_pelanggan ASC");
                                while ($p = mysqli_fetch_assoc($query_pelanggan)) {
                                    echo "<option value='".$p['id_pelanggan']."'>".$p['nama_pelanggan']." - ".$p['alamat']."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Layanan Laundry</label>
                            <select name="jenis_layanan" class="form-select" required>
                                <option value="Cuci Komplit (Wangi)">Cuci Komplit (Wangi)</option>
                                <option value="Sprei & Selimut">Sprei & Selimut</option>
                                <option value="Cuci Kering Saja">Cuci Kering Saja</option>
                                <option value="Setrika Premium">Setrika Premium</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Berat Beban (Kg)</label>
                                <input type="number" step="0.1" name="berat" class="form-control" placeholder="Contoh: 3.5" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Total Harga (Rp)</label>
                                <input type="number" name="total_harga" class="form-control" placeholder="Contoh: 24000" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Metode Pembayaran</label>
                                <select name="metode_bayar" class="form-select">
                                    <option value="Cash">Cash / Tunai</option>
                                    <option value="E-Wallet">E-Wallet (Dana/OVO/QRIS)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status Awal</label>
                                <select name="status_pesanan" class="form-select">
                                    <option value="Menunggu">Menunggu / Antrian</option>
                                    <option value="Diproses">Diproses Cuci</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="simpan" class="btn btn-primary px-4 py-2 rounded-3 fw-bold me-2">
                                <i class="fa-solid fa-calculator me-1"></i> Simpan Transaksi
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