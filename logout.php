<?php
session_start();

// Menghapus semua variabel session
session_unset(); 

// Menghapus session sepenuhnya
session_destroy(); 
header("Location: login.php?status=logout");
exit;
?>
