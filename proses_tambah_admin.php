<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_admin = mysqli_real_escape_string($koneksi, $_POST['nama_admin']);
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password   = mysqli_real_escape_string($koneksi, $_POST['password']); 

    // Query simpan ke database tabel admin
    $query = "INSERT INTO admin (nama_admin, username, password) VALUES ('$nama_admin', '$username', '$password')";
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Admin baru berhasil ditambahkan!');
                window.location='data_admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan admin: " . mysqli_error($koneksi) . "');
                window.location='tambah_admin.php';
              </script>";
    }
} else {
    header("Location: data_admin.php");
}
?>