<?php
session_start();
require 'db.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

$sql = "SELECT id, name, no_telp, shoeType, ukuran, alamat, catatan, created_at
        FROM orders
        WHERE username = :username
        ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([':username' => $username]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Pesanan Saya — <?=htmlspecialchars($username)?></title>
  <link rel="stylesheet" href="myorder.css">
</head>
<body>
  <div class="c">
    <h2 class="t">Halo, <?=htmlspecialchars($username)?> — Pesanan Anda</h2>
    <?php if (empty($orders)): ?>
      <p class="s" style="display:block;">Belum ada pesanan.</p>
    <?php else: ?>
      <div class="orders-container">
        <?php foreach ($orders as $o): ?>
            <div class="order-card">
            <div class="order-header">
                <h3><?= htmlspecialchars($o['shoeType']) ?> — <span class="size">Ukuran <?= htmlspecialchars($o['ukuran']) ?></span></h3>
                <p class="date"><?= htmlspecialchars($o['created_at'] ?? '-') ?></p>
            </div>

            <div class="order-body">
                <p><strong class="label">Nama</strong>: <?= htmlspecialchars($o['name']) ?></p>
                <p><strong class="label">No Hp</strong>: <?= htmlspecialchars($o['no_telp']) ?></p>
                <p><strong class="label">Alamat</strong>: <?= htmlspecialchars($o['alamat']) ?></p>
                <p><strong class="label">Catatan</strong>: <?= htmlspecialchars($o['catatan']) ?></p>

                <style>
                .label {
                display: inline-block;
                width: 60px;
                }
                </style>
            </div>

            <div class="order-actions">
                <a href="order.php?id=<?= $o['id'] ?>" class="btn-edit">Ubah</a>
                <a href="delete.php?id=<?= $o['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</a>
            </div>
            </div>
        <?php endforeach; ?>
    </div>


    <?php endif; ?>

    <p style="text-align:center; margin-top:10px; font-size:0.875rem;">
      <a href="dashboard.php" style="color:#2563eb; text-decoration:none;">Kembali ke Dashboard</a>
    </p>
  </div>
</body>
</html>
