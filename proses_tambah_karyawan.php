<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_karyawan = mysqli_real_escape_string($koneksi, $_POST['nama_karyawan']);
    $posisi        = mysqli_real_escape_string($koneksi, $_POST['posisi']);
    $no_hp         = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat        = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // Pastikan nama kolom database (nama_karyawan, posisi, no_hp, alamat) sesuai dengan tabel 'karyawan' milikmu
    $query = "INSERT INTO karyawan (nama_karyawan, posisi, no_hp, alamat) VALUES ('$nama_karyawan', '$posisi', '$no_hp', '$alamat')";
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Karyawan baru berhasil ditambahkan!');
                window.location='data_karyawan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "');
                window.location='tambah_karyawan.php';
              </script>";
    }
} else {
    header("Location: data_karyawan.php");
}
?>