<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_karyawan = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Eksekusi penghapusan data berdasarkan id_karyawan
    $query = "DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Data staf karyawan berhasil dihapus!');
                window.location='data_karyawan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location='data_karyawan.php';
              </script>";
    }
} else {
    header("Location: data_karyawan.php");
}
?>