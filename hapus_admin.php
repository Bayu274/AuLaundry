<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_admin = $_GET['id'];

    // Keamanan Ganda: Mencegah penghapusan akun super_admin melalui URL bypass
    $cek_admin = mysqli_query($koneksi, "SELECT level FROM admin WHERE id_admin = '$id_admin'");
    $data = mysqli_fetch_assoc($cek_admin);

    if ($data['level'] == 'super_admin') {
        echo "<script>
                alert('Bahaya! Akun Super Admin/Owner tidak boleh dihapus!');
                window.location='data_admin.php';
              </script>";
        exit();
    }

    // Eksekusi Hapus jika lolos sensor keamanan
    $query = "DELETE FROM admin WHERE id_admin = '$id_admin'";
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Akun admin berhasil dihapus!');
                window.location='data_admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus admin: " . mysqli_error($koneksi) . "');
                window.location='data_admin.php';
              </script>";
    }
} else {
    header("Location: data_admin.php");
}
?>