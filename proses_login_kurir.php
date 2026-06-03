<?php
// Mulai sesi untuk menyimpan tanda pengenal kurir
session_start();

// Panggil jembatan koneksi ke database
include 'koneksi.php';

// Tangkap data dari form login kurir
$username = $_POST['username'];
$password = $_POST['password'];

// Cari data di tabel kurir yang cocok
$query = "SELECT * FROM kurir WHERE username='$username' AND password='$password'";
$hasil = mysqli_query($koneksi, $query);

// Cek apakah data kurir ditemukan
if (mysqli_num_rows($hasil) > 0) {
    $data = mysqli_fetch_assoc($hasil);
    
    // Simpan data login kurir ke dalam session
    $_SESSION['status_kurir'] = true;
    $_SESSION['id_kurir'] = $data['id_kurir'];
    $_SESSION['nama_kurir'] = $data['nama_kurir'];
    
    // Alihkan ke halaman dashboard khusus kurir
    header("Location: dashboard_kurir.php");
    exit();
} else {
    // Jika salah, kembalikan ke halaman login dengan pesan gagal
    header("Location: login_kurir.php?pesan=gagal");
    exit();
}
?>