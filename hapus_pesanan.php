<?php
session_start();
// Gembok halaman: Pastikan hanya admin yang bisa hapus transaksi
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

// Panggil koneksi database
include 'koneksi.php';

// Ambil ID pesanan yang dikirim lewat URL
if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];

    // Perintah SQL untuk menghapus data berdasarkan id_pesanan
    $query = "DELETE FROM pesanan WHERE id_pesanan = '$id_pesanan'";
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        // Jika sukses, muncul pop-up lalu balik ke data pesanan
        echo "<script>
                alert('Transaksi laundry berhasil dihapus!');
                window.location='data_pesanan.php';
              </script>";
    } else {
        // Jika gagal
        echo "<script>
                alert('Gagal menghapus transaksi: " . mysqli_error($koneksi) . "');
                window.location='data_pesanan.php';
              </script>";
    }
} else {
    // Kalau tidak ada ID yang dilempar, kembalikan ke halaman utama
    header("Location: data_pesanan.php");
}
?>