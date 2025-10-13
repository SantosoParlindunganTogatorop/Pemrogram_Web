<?php
session_start();
require 'db.php';

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password'];
    $confirm_pw = $_POST['confirm_pw'];

    if ($password !== $confirm_pw) {
        $error = "Password dan konfirmasi tidak sama!";
    } else {
        // Cek apakah username sudah ada
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Simpan user baru ke database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);

            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    .password-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }
    .password-wrapper input {
      width: 100%;
      padding-right: 35px;
    }
    .toggle-password {
      position: absolute;
      right: 10px;
      cursor: pointer;
      color: #777;
      transition: 0.3s;
    }
    .toggle-password:hover {
      color: #000;
    }
  </style>
</head>

<body>
  <div class="container">
    <form action="register.php" method="POST" class="login-form" autocomplete="off">
      <h2><b>REGISTER</b></h2>

      <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      <?php if (isset($_SESSION['success'])) { echo "<p style='color:green;'>".$_SESSION['success']."</p>"; unset($_SESSION['success']); } ?>

      <div class="input-group">
        <input type="text" name="username" placeholder="Username" required autocomplete="off">
      </div>

      <div class="input-group">
        <input type="email" name="email" placeholder="Email" required autocomplete="off">
      </div>

      <div class="input-group password-wrapper">
        <input id="password" type="password" name="password" placeholder="Password" required autocomplete="new-password">
        <i data-feather="eye-off" class="toggle-password" data-target="password"></i>
      </div>

      <div class="input-group password-wrapper">
        <input id="confirm_pw" type="password" name="confirm_pw" placeholder="Konfirmasi Password" required autocomplete="new-password">
        <i data-feather="eye-off" class="toggle-password" data-target="confirm_pw"></i>
      </div>

      <div class="submit-section">
        <input type="submit" value="Daftar" class="btn">
      </div>

      <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
  </div>
<script>
  function setupToggleIcons() {
    document.querySelectorAll('.toggle-password').forEach(icon => {
      icon.addEventListener('click', () => {
        const input = document.getElementById(icon.dataset.target);
        const isHidden = input.type === 'password';

        // ubah tipe input
        input.type = isHidden ? 'text' : 'password';

        // buat elemen ikon baru sesuai status
        const newIcon = document.createElement('i');
        newIcon.setAttribute('data-feather', isHidden ? 'eye' : 'eye-off');
        newIcon.classList.add('toggle-password');
        newIcon.setAttribute('data-target', icon.dataset.target);

        // ganti ikon lama dengan ikon baru
        icon.parentNode.replaceChild(newIcon, icon);

        // render ulang ikon Feather
        feather.replace();

        // panggil ulang fungsi supaya listener-nya aktif lagi
        setupToggleIcons();
      });
    });
  }

  // render awal
  feather.replace();
  setupToggleIcons();
</script>



</body>
</html>
