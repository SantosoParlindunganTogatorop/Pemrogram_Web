<?php
session_start();
require 'db.php'; // koneksi ke database

// Pastikan user login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$produk = isset($_GET['produk']) ? $_GET['produk'] : '';
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = false;
$order = null;

// Jika ada ID, ambil data lama (mode edit)
if ($order_id > 0) {
    $sql = "SELECT * FROM orders WHERE id = :id AND username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $order_id, ':username' => $username]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $editing = true;
        $produk = $order['shoeType']; // supaya tetap tampil di field produk
    }
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = $_POST['name'];
    $phone    = $_POST['phone'];
    $shoeType = $_POST['shoeType'];
    $size     = $_POST['size'];
    $address  = $_POST['address'];
    $notes    = $_POST['notes'];

    if ($editing) {
        // Mode EDIT → Update data berdasarkan ID
        $sql = "UPDATE orders
                SET name = :name,
                    no_telp = :no_telp,
                    shoeType = :shoeType,
                    ukuran = :ukuran,
                    alamat = :alamat,
                    catatan = :catatan
                WHERE id = :id AND username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name'     => $name,
            ':no_telp'  => $phone,
            ':shoeType' => $shoeType,
            ':ukuran'   => $size,
            ':alamat'   => $address,
            ':catatan'  => $notes,
            ':id'       => $order_id,
            ':username' => $username
        ]);
        header('Location: myorder.php');
        exit;
    } else {
        // Mode TAMBAH → Insert data baru
        $sql = "INSERT INTO orders (username, name, no_telp, shoeType, ukuran, alamat, catatan)
                VALUES (:username, :name, :no_telp, :shoeType, :ukuran, :alamat, :catatan)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':name'     => $name,
            ':no_telp'  => $phone,
            ':shoeType' => $shoeType,
            ':ukuran'   => $size,
            ':alamat'   => $address,
            ':catatan'  => $notes
        ]);
        header('Location: myorder.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $editing ? 'Edit Pesanan' : 'Form Pemesanan' ?></title>
  <link rel="stylesheet" href="order.css">
</head>
<body>
  <div class="c">
    <h2 class="t"><?= $editing ? 'Edit Pesanan' : 'Form Pemesanan Produk' ?></h2>

    <form id="orderForm" class="f" method="POST">
      <div class="g">
        <label for="name" class="l">Nama Lengkap</label>
        <input type="text" id="name" name="name" required class="i" 
               value="<?= htmlspecialchars($order['name'] ?? '') ?>">
      </div>

      <div class="g">
        <label for="phone" class="l">Nomor Telepon</label>
        <input type="tel" id="phone" name="phone" required class="i"
               value="<?= htmlspecialchars($order['no_telp'] ?? '') ?>">
      </div>

      <div class="g">
        <label for="shoeType" class="l">Jenis Sepatu</label>
        <input type="text" id="shoeType" name="shoeType" readonly class="i bg-gray" 
               value="<?= htmlspecialchars($produk) ?>">
      </div>

      <div class="g">
        <label for="size" class="l">Ukuran Sepatu</label>
        <select id="size" name="size" required class="i">
          <option value="" disabled <?= empty($order['ukuran']) ? 'selected' : '' ?>>Pilih Ukuran</option>
          <?php for ($i = 25; $i <= 46; $i++): ?>
            <option value="<?= $i ?>" <?= (isset($order['ukuran']) && $order['ukuran'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="g">
        <label for="address" class="l">Alamat Pengiriman</label>
        <textarea id="address" name="address" required class="i"><?= htmlspecialchars($order['alamat'] ?? '') ?></textarea>
      </div>

      <div class="g">
        <label for="notes" class="l">Catatan Tambahan</label>
        <textarea id="notes" name="notes" class="i"><?= htmlspecialchars($order['catatan'] ?? '') ?></textarea>
      </div>

      <button type="submit" class="b"><?= $editing ? 'Simpan Perubahan' : 'Pesan' ?></button>

      <p style="text-align:center; margin-top:10px; font-size:0.875rem;">
        <a href="dashboard.php" style="color:#2563eb; text-decoration:none;">Kembali ke Dashboard</a>
      </p>
    </form>
  </div>
</body>
</html>
