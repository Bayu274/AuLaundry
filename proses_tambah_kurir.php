<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // Tangkap data form
    $nama_kurir = mysqli_real_escape_string($koneksi, $_POST['nama_kurir']);
    $no_hp      = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $username   = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password   = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Perintah SQL INSERT disesuaikan dengan struktur kolom database kamu
    $query = "INSERT INTO kurir (nama_kurir, no_hp, username, password) 
              VALUES ('$nama_kurir', '$no_hp', '$username', '$password')";
              
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Kurir baru berhasil didaftarkan!');
                window.location='data_kurir.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mendaftarkan kurir: " . mysqli_error($koneksi) . "');
                window.location='tambah_kurir.php';
              </script>";
    }
} else {
    header("Location: data_kurir.php");
}
?>