<?php
// db.php — koneksi ke database MySQL Workbench
$host = 'localhost';     // atau 127.0.0.1
$user = 'root';          // username default MySQL
$pass = ''; // ganti sesuai password MySQL Workbench kamu
$db   = 'aerostreet_db'; // nama database yang kamu buat

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
