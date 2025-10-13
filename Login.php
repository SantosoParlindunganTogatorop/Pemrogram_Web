<?php
session_start();
require_once 'db.php';

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['username'])) {
  header("Location: dashboard.php");
  exit;
}

$error = "";

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = htmlspecialchars(trim($_POST['username']));
  $password = $_POST['password'];

  if (empty($username) || empty($password)) {
    $error = "Harap isi semua kolom!";
  } else {
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      session_regenerate_id(true);
      $_SESSION['username'] = $user['username'];
      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Username atau password salah!";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Sistem</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: #f7f9fc;
    }
    .container {
      width: 100%;
      max-width: 400px;
      margin: auto;
    }
    .alert {
      background: #ffdddd;
      color: #a33;
      padding: 8px;
      border: 1px solid #e5a2a2;
      border-radius: 5px;
      font-size: 13px;
    }
    .alert.success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
  </style>
</head>
<body>
  <div class="container">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="login-form">
      <h2><b>LOGIN</b></h2>

      <?php if (!empty($error)): ?>
        <p class="alert"><?= $error; ?></p>
      <?php endif; ?>

      <?php if (isset($_GET['status']) && $_GET['status'] === 'logout'): ?>
        <p class="alert success">Anda telah logout dengan aman.</p>
      <?php endif; ?>

      <div class="input-group">
        <input 
          type="text" 
          name="username" 
          placeholder="Username" 
          value="<?= isset($username) ? htmlspecialchars($username) : ''; ?>" 
          required 
          autocomplete="off"
        >
      </div>

      <div class="input-group">
        <input 
          type="password" 
          name="password" 
          placeholder="Password" 
          required 
          autocomplete="off"
        >
      </div>

      <div class="submit-section">
        <input type="submit" value="Login" class="btn">
      </div>

      <a href="register.php" class="register-link">Belum punya akun? Daftar</a>
    </form>
  </div>
</body>
</html>
