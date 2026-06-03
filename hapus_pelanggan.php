<?php
session_start();
// Gembok halaman: Pastikan hanya admin yang bisa hapus
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

// Panggil koneksi database
include 'koneksi.php';

// Ambil ID pelanggan yang dikirim lewat URL
if (isset($_GET['id'])) {
    $id_pelanggan = $_GET['id'];

    // Perintah SQL untuk menghapus data berdasarkan ID
    $query = "DELETE FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'";
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        // Jika berhasil, munculkan notifikasi lalu balikkan ke halaman data pelanggan
        echo "<script>
                alert('Data pelanggan berhasil dihapus!');
                window.location='data_pelanggan.php';
              </script>";
    } else {
        // Jika gagal
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location='data_pelanggan.php';
              </script>";
    }
} else {
    // Jika tidak ada ID yang dikirim, lempar balik
    header("Location: data_pelanggan.php");
}
?>