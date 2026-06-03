<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM pelanggan WHERE username='$username' AND password='$password'";
$hasil = mysqli_query($koneksi, $query);

if (mysqli_num_rows($hasil) > 0) {
    $data = mysqli_fetch_assoc($hasil);
    
    $_SESSION['status_pelanggan'] = true;
    $_SESSION['id_pelanggan'] = $data['id_pelanggan'];
    $_SESSION['nama_pelanggan'] = $data['nama_pelanggan'];
    $_SESSION['alamat_pelanggan'] = $data['alamat'];
    
    header("Location: dashboard_pelanggan.php");
    exit();
} else {
    header("Location: login_pelanggan.php?pesan=gagal");
    exit();
}
?>