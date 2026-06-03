<?php
// Mulai sesi untuk menyimpan data login
session_start();

// Panggil jembatan koneksi yang sudah kamu buat
include 'koneksi.php';

// Tangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Cari data admin di database yang username-nya cocok
$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$hasil = mysqli_query($koneksi, $query);

// Cek apakah ada data yang cocok (jumlah baris > 0)
if (mysqli_num_rows($hasil) > 0) {
    // Jika cocok, ambil datanya
    $data = mysqli_fetch_assoc($hasil);
    
    // Simpan informasi penting ke dalam 'session' (seperti tanda pengenal)
    $_SESSION['status_login'] = true;
    $_SESSION['id_admin'] = $data['id_admin'];
    $_SESSION['nama_admin'] = $data['nama'];
    
    // Arahkan (lempar) langsung ke halaman Dashboard
    header("Location: dashboard_admin.php");
    exit();
} else {
    // Jika tidak cocok (salah username/password), lempar kembali ke halaman login
    // Sambil membawa pesan error di URL (?pesan=gagal)
    header("Location: login_admin.php?pesan=gagal");
    exit();
}
?>