<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

include 'koneksi.php';

if (isset($_POST['update'])) {
    $id_kurir   = $_POST['id_kurir'];
    $nama_kurir = mysqli_real_escape_string($koneksi, $_POST['nama_kurir']);
    $no_hp      = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password   = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query UPDATE data kurir
    $query = "UPDATE kurir SET 
                nama_kurir = '$nama_kurir', 
                no_hp = '$no_hp', 
                username = '$username', 
                password = '$password' 
              WHERE id_kurir = '$id_kurir'";
              
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Data kurir berhasil diperbarui!');
                window.location='data_kurir.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');
                window.location='edit_kurir.php?id=$id_kurir';
              </script>";
    }
} else {
    header("Location: data_kurir.php");
}
?>