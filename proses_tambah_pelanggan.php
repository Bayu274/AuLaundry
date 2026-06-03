<?php
session_start();
// Gembok halaman
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}

// Panggil koneksi database
include 'koneksi.php';

// Cek apakah tombol simpan sudah diklik
if (isset($_POST['simpan'])) {
    
    // Tangkap data dari form dan amankan dari karakter aneh
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_hp          = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $username       = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password       = mysqli_real_escape_string($koneksi, $_POST['password']); 
    // Catatan: password sengaja disimpan text biasa/md5 sesuai kebutuhan awal login mu

    // Query untuk memasukkan data ke tabel pelanggan (Menggunakan nama kolom 'no_hp' yang sudah kita perbaiki)
    $query = "INSERT INTO pelanggan (nama_pelanggan, alamat, no_hp, username, password) 
              VALUES ('$nama_pelanggan', '$alamat', '$no_hp', '$username', '$password')";
              
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Pelanggan baru berhasil ditambahkan!');
                window.location='data_pelanggan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data: " . mysqli_error($koneksi) . "');
                window.location='tambah_pelanggan.php';
              </script>";
    }

} else {
    // Jika mencoba akses langsung tanpa isi form, tendang balik
    header("Location: data_pelanggan.php");
}
?>