<?php
session_start();
require 'db.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Pastikan ada parameter id
if (!isset($_GET['id'])) {
    header('Location: myorder.php');
    exit;
}

$order_id = (int) $_GET['id'];

// Hapus pesanan berdasarkan id & username (biar aman, user cuma bisa hapus pesanan sendiri)
$sql = "DELETE FROM orders WHERE id = :id AND username = :username";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':id' => $order_id,
    ':username' => $username
]);

// Kembali ke halaman daftar pesanan
header('Location: myorder.php');
exit;
?>
