<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_POST['update'])) {
    $id_admin   = $_POST['id_admin'];
    $nama_admin = mysqli_real_escape_string($koneksi, $_POST['nama_admin']);
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password   = mysqli_real_escape_string($koneksi, $_POST['password']);

    if (empty($password)) {
        // Jika form password dikosongkan, ganti nama & username saja
        $query = "UPDATE admin SET nama_admin = '$nama_admin', username = '$username' WHERE id_admin = '$id_admin'";
    } else {
        // Jika password diisi, ikut update passwordnya
        $query = "UPDATE admin SET nama_admin = '$nama_admin', username = '$username', password = '$password' WHERE id_admin = '$id_admin'";
    }

    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Data admin berhasil diperbarui!');
                window.location='data_admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');
                window.location='edit_admin.php?id=$id_admin';
              </script>";
    }
} else {
    header("Location: data_admin.php");
}
?>