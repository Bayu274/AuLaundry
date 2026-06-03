<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: login_admin.php");
    exit();
}
include 'koneksi.php';

if (isset($_POST['update'])) {
    $id_pesanan     = $_POST['id_pesanan'];
    $berat          = mysqli_real_escape_string($koneksi, $_POST['berat']);
    $total_harga    = mysqli_real_escape_string($koneksi, $_POST['total_harga']);
    $status_pesanan = mysqli_real_escape_string($koneksi, $_POST['status_pesanan']);

    // Jalankan Query UPDATE data pesanan
    $query = "UPDATE pesanan SET 
                berat = '$berat', 
                total_harga = '$total_harga', 
                status_pesanan = '$status_pesanan' 
              WHERE id_pesanan = '$id_pesanan'";
              
    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        echo "<script>
                alert('Status Transaksi Berhasil Diperbarui!');
                window.location='data_pesanan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui transaksi: " . mysqli_error($koneksi) . "');
                window.location='edit_pesanan.php?id=$id_pesanan';
              </script>";
    }
} else {
    header("Location: data_pesanan.php");
}
?>