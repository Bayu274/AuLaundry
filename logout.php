<?php
// Mulai sesi agar bisa menghapusnya
session_start();

// Hancurkan semua sesi login yang tersimpan di browser
session_destroy();

// Tendang kembali ke halaman login admin
header("Location: login_admin.php");
exit();
?>