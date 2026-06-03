<?php
session_start();
// Gembok halaman: Pastikan hanya admin yang bisa hapus kurir
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

// Panggil koneksi database
include 'koneksi.php';

// Ambil ID kurir yang dikirim lewat URL tombol hapus
if (isset($_GET['id'])) {
    $id_kurir = $_GET['id'];

    // Perintah SQL untuk menghapus data berdasarkan id_kurir
    $query = "DELETE FROM kurir WHERE id_kurir = '$id_kurir'";
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        // Jika sukses, muncul pop-up lalu balik ke data kurir
        echo "<script>
                alert('Data kurir berhasil dihapus!');
                window.location='data_kurir.php';
              </script>";
    } else {
        // Jika gagal karena bentrok relasi database
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location='data_kurir.php';
              </script>";
    }
} else {
    // Kalau tidak ada ID yang dilempar, kembalikan ke halaman utama
    header("Location: data_kurir.php");
}
?>