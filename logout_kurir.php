<?php
// Mulai sesi
session_start();

// Hancurkan semua sesi kurir
session_destroy();

// Arahkan kembali ke halaman login kurir
header("Location: login_kurir.php");
exit();
?>