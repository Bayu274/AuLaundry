<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil role pengguna dari session
$role = $_SESSION['role'] ?? '';
?>

<nav id="sidebar">
    <div class="sidebar-header">
        <span>Panel <?= ucfirst($role); ?></span>
        <button class="close-btn" id="sidebarClose" aria-label="Close sidebar">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <ul class="nav flex-column px-0" style="list-style:none; padding:0; margin:0;">
        <?php if ($role === 'admin'): ?>
            <li><a href="/aulaundry/pages/admin/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="/aulaundry/pages/admin/data_pesanan.php"><i class="fas fa-clipboard-list me-2"></i> Data Pesanan</a></li>
            <li><a href="/aulaundry/pages/admin/data_pelanggan.php"><i class="fas fa-users me-2"></i> Data Pelanggan</a></li>
            <li><a href="/aulaundry/pages/admin/data_kurir.php"><i class="fas fa-motorcycle me-2"></i> Data Kurir</a></li>
            <li><a href="/aulaundry/pages/admin/data_karyawan.php"><i class="fas fa-user-tie me-2"></i> Data Karyawan</a></li>
            <li><a href="/aulaundry/pages/admin/data_admin.php"><i class="fas fa-user-shield me-2"></i> Data Admin</a></li>
        <?php elseif ($role === 'karyawan'): ?>
            <li><a href="/aulaundry/pages/karyawan/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="/aulaundry/pages/karyawan/data_pesanan.php"><i class="fas fa-clipboard-list me-2"></i> Data Pesanan</a></li>
        <?php elseif ($role === 'kurir'): ?>
            <li><a href="/aulaundry/pages/kurir/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="/aulaundry/pages/kurir/pesanan_antar.php"><i class="fas fa-truck me-2"></i> Pesanan Antar</a></li>
        <?php elseif ($role === 'pelanggan'): ?>
            <li><a href="/aulaundry/pages/pelanggan/dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
            <li><a href="/aulaundry/pages/pelanggan/buat_pesanan.php"><i class="fas fa-plus-circle me-2"></i> Buat Pesanan</a></li>
            <li><a href="/aulaundry/pages/pelanggan/riwayat_pesanan.php"><i class="fas fa-history me-2"></i> Riwayat Pesanan</a></li>
            <li><a href="/aulaundry/pages/pelanggan/edit_profil.php"><i class="fas fa-user-edit me-2"></i> Edit Profil</a></li>
        <?php endif; ?>
        <li style="margin-top: 30px;">
            <a href="/aulaundry/logout.php" style="color: #ff6b6b;"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </li>
    </ul>
</nav>

<!-- Overlay untuk mobile -->
<div id="sidebarOverlay"></div>
