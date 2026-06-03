<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

include 'koneksi.php';

if (isset($_POST['update'])) {
    $id_pelanggan   = $_POST['id_pelanggan'];
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_hp          = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $username       = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password       = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query UPDATE data ke database
    $query = "UPDATE pelanggan SET 
                nama_pelanggan = '$nama_pelanggan', 
                alamat = '$alamat', 
                no_hp = '$no_hp', 
                username = '$username', 
                password = '$password' 
              WHERE id_pelanggan = '$id_pelanggan'";
              
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Data pelanggan berhasil diperbarui!');
                window.location='data_pelanggan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');
                window.location='edit_pelanggan.php?id=$id_pelanggan';
              </script>";
    }
} else {
    header("Location: data_pelanggan.php");
}
?>