<?php
session_start();
// Cek apakah admin memiliki 'tanda pengenal' (Menggunakan status_login)
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
// Panggil koneksi database
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Admin AuLaundry</title>
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
                <a href="dashboard_admin.php" class="btn btn-sm btn-outline-light rounded-pill"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-users text-primary me-2"></i>Kelola Data Pelanggan</h4>
            <a href="tambah_pelanggan.php" class="btn btn-primary rounded-pill fw-bold px-4 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Tambah Pelanggan
            </a>
        </div>

        <div class="card card-custom p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Username</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Meminta data dari tabel pelanggan di database
                        $query = "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC";
                        $hasil = mysqli_query($koneksi, $query);
                        $no = 1;

                        // Looping (mengulang) data untuk ditampilkan di tabel
                        while ($data = mysqli_fetch_assoc($hasil)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td class="fw-bold"><?php echo $data['nama_pelanggan']; ?></td>
                            <td><?php echo $data['alamat']; ?></td>
                            <td><?php echo $data['no_hp']; ?></td>
                            <td><span class="badge bg-secondary"><?php echo $data['username']; ?></span></td>
                            <td class="text-center">
                                <a href="edit_pelanggan.php?id=<?php echo $data['id_pelanggan']; ?>" class="btn btn-sm btn-warning text-dark"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <a href="hapus_pelanggan.php?id=<?php echo $data['id_pelanggan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')"><i class="fa-solid fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>