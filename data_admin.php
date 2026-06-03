<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Admin - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .sidebar { height: 100vh; width: 260px; position: fixed; top: 0; left: 0; background-color: #070d19; color: white; padding-top: 20px; z-index: 100; }
        .sidebar .brand { padding: 10px 25px; font-size: 1.5rem; font-weight: bold; color: #00d2ff; border-bottom: 1px solid #1a2536; margin-bottom: 20px; }
        .sidebar a { padding: 12px 25px; text-decoration: none; font-size: 1rem; color: #a3b1cc; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { color: white; background-color: #1a2536; border-left: 4px solid #00d2ff; }
        .sidebar a i { margin-right: 10px; width: 20px; }
        .main-content { margin-left: 260px; padding: 30px; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .btn-tambah { background-color: #0066ff; color: white; border-radius: 8px; font-weight: 500; }
        .btn-tambah:hover { background-color: #0052cc; color: white; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-soap"></i> AuLaundry</div>
        <a href="dashboard_admin.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        <a href="data_pelanggan.php"><i class="fa-solid fa-users"></i> Data Pelanggan</a>
        <a href="data_pesanan.php"><i class="fa-solid fa-file-invoice-dollar"></i> Data Pesanan</a>
        <a href="data_kurir.php"><i class="fa-solid fa-motorcycle"></i> Data Kurir</a>
        <a href="data_admin.php" class="active"><i class="fa-solid fa-user-shield"></i> Data Admin</a>
        <a href="data_karyawan.php"><i class="fa-solid fa-user-tie"></i> Data Karyawan</a>
        <a href="index.php" class="text-danger mt-5"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Data Pengelola Admin</h2>
                <p class="text-muted">Kelola akun administrator pengawas sistem.</p>
            </div>
            <a href="tambah_admin.php" class="btn btn-tambah px-3 py-2">
                <i class="fa-solid fa-plus me-2"></i> Tambah Admin Baru
            </a>
        </div>

        <div class="card card-custom p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0">Daftar Admin Sistem</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" width="60">No</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Username</th>
                            <th scope="col">Level Otoritas</th>
                            <th scope="col" width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id_admin ASC");
    $no = 1;

    while ($data = mysqli_fetch_assoc($query)) {
        // Membaca level langsung dari database
        $level = $data['level'];
        
        // Menentukan label tampilan level berdasarkan isi database
        if ($level == 'super_admin') {
            $label_level = 'Pemilik / Owner';
            $badge_class = 'bg-dark';
        } else {
            $label_level = 'Staff Admin';
            $badge_class = 'bg-secondary';
        }
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td class="fw-semibold"><?php echo $data['nama_admin']; ?> <?php echo ($level == 'super_admin') ? '(Kamu)' : ''; ?></td>
        <td><span class="badge <?php echo $badge_class; ?>"><?php echo $data['username']; ?></span></td>
        <td><span class="text-primary fw-medium"><?php echo $label_level; ?></span></td>
        <td class="text-center">
            <a href="edit_admin.php?id=<?php echo $data['id_admin']; ?>" class="btn btn-sm btn-outline-warning me-1"><i class="fa-solid fa-pen"></i></a>
            
            <?php if ($level == 'super_admin') { ?>
                <button class="btn btn-sm btn-outline-secondary" disabled title="Super admin utama tidak bisa dihapus"><i class="fa-solid fa-trash"></i></button>
            <?php } else { ?>
                <a href="hapus_admin.php?id=<?php echo $data['id_admin']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus admin ini?')"><i class="fa-solid fa-trash"></i></a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>