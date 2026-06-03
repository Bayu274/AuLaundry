<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_POST['update'])) {
    $id_karyawan   = $_POST['id_karyawan'];
    $nama_karyawan = mysqli_real_escape_string($koneksi, $_POST['nama_karyawan']);
    $posisi        = mysqli_real_escape_string($koneksi, $_POST['posisi']);
    $no_hp         = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat        = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = "UPDATE karyawan SET 
                nama_karyawan = '$nama_karyawan', 
                posisi = '$posisi', 
                no_hp = '$no_hp', 
                alamat = '$alamat' 
              WHERE id_karyawan = '$id_karyawan'";
              
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Data karyawan berhasil diperbarui!');
                window.location='data_karyawan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');
                window.location='edit_karyawan.php?id=$id_karyawan';
              </script>";
    }
} else {
    header("Location: data_karyawan.php");
}
?>