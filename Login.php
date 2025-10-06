<?php
session_start();

// redirect di dashboard kalau masih login
if (isset($_SESSION['username'])) {
  header("Location: dashboard.php");
  exit;
}

// Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // simpan username dan password
  if ($username == 'santoso' && $password == 'spt06520') {
    $_SESSION['username'] = $username;
    // Redirect ke dashboard
    header("Location: dashboard.php?status=success");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <form action="login.php" method="post" class="login-form">
        <h2><b>LOGIN</b></h2>

        <!-- cek error -->
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <div class="input-group">
          <span>👤</span>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Username"
            required
          />
        </div>

        <div class="input-group">
          <span>🔒</span>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Password"
            required
          />
        </div>

        <div class="options">
          <div>
            <input type="checkbox" id="remember" name="remember" />
            <label for="remember">Remember me</label>
          </div>
          <div>
            <a href="forgot.html">Lupa Password?</a>
          </div>
        </div>

        <div class="submit-section">
          <input type="submit" value="Login" class="btn" />
        </div>

        <a href="Form.html" class="register-link">Daftar akun</a>

        <p class="terms">
          Telah menyetujui
          <a href="syarat.html">syarat & ketentuan</a>
        </p>
      </form>
    </div>
  </body>
</html>
