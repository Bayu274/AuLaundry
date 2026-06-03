<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $no_pesanan     = mysqli_real_escape_string($koneksi, $_POST['no_pesanan']);
    $id_pelanggan   = mysqli_real_escape_string($koneksi, $_POST['id_pelanggan']);
    $jenis_layanan  = mysqli_real_escape_string($koneksi, $_POST['jenis_layanan']);
    $berat          = mysqli_real_escape_string($koneksi, $_POST['berat']);
    $total_harga    = mysqli_real_escape_string($koneksi, $_POST['total_harga']);
    $metode_bayar   = mysqli_real_escape_string($koneksi, $_POST['metode_bayar']);
    $status_pesanan = mysqli_real_escape_string($koneksi, $_POST['status_pesanan']);

    // Query INSERT data ke tabel pesanan
    $query = "INSERT INTO pesanan (no_pesanan, id_pelanggan, jenis_layanan, berat, total_harga, metode_bayar, status_pesanan) 
              VALUES ('$no_pesanan', '$id_pelanggan', '$jenis_layanan', '$berat', '$total_harga', '$metode_bayar', '$status_pesanan')";
              
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Transaksi Baru Berhasil Disimpan!');
                window.location='data_pesanan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menyimpan transaksi: " . mysqli_error($koneksi) . "');
                window.location='tambah_pesanan.php';
              </script>";
    }
} else {
    header("Location: data_pesanan.php");
}
?>