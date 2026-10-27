<?php
session_start();
include 'config/koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT * FROM tb_admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin_babuljannah'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Panti Asuhan Babul Jannah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background-color: #234e3e; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .login-card { background: white; border-radius: 16px; display: flex; overflow: hidden; width: 100%; max-width: 750px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .left-box { background: #17382c; color: white; padding: 40px 30px; width: 45%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; }
        .left-box img { width: 85px; height: 85px; object-fit: contain; border-radius: 50%; margin-bottom: 15px; background: white; padding: 3px; }
        .left-box h2 { font-size: 18px; font-weight: 800; margin-bottom: 5px; line-height: 1.2; letter-spacing: 0.5px; }
        .left-box p { font-size: 11px; color: #86efac; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; }
        
        .right-box { padding: 40px 35px; width: 55%; display: flex; flex-direction: column; justify-content: center; }
        .right-box h3 { font-size: 20px; font-weight: 800; color: #17382c; margin-bottom: 4px; text-transform: uppercase; }
        .right-box p.sub-title { font-size: 11px; color: #64748b; margin-bottom: 25px; text-transform: uppercase; font-weight: 600; }
        
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 11px; font-weight: 800; margin-bottom: 6px; color: #1e293b; letter-spacing: 0.5px; }
        .form-group input { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 20px; font-size: 12px; outline: none; }
        .form-group input:focus { border-color: #17382c; }
        
        .btn-login { background: #17382c; color: white; border: none; width: 100%; padding: 11px; border-radius: 20px; font-weight: 700; font-size: 12px; cursor: pointer; margin-top: 10px; letter-spacing: 0.5px; }
        .btn-login:hover { background: #234e3e; }
        .error-msg { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; padding: 8px; border-radius: 6px; font-size: 11px; margin-bottom: 15px; text-align: center; font-weight: 600; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="left-box">
            <img src="assets/logo" alt="Logo Panti" onerror="this.src='assets/logo.jpeg'">
            <h2>PANTI ASUHAN<br>BABUL JANNAH</h2>
            <p>LOGIN ADMIN</p>
        </div>
        <div class="right-box">
            <h3>SELAMAT DATANG!</h3>
            <p class="sub-title">SILAKAN MASUK UNTUK MELANJUTKAN</p>

            <?php if($error): ?><div class="error-msg"><?= $error; ?></div><?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label>USERNAME</label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="btn-login">MASUK</button>
            </form>
            <a href="index.php" style="display: block; text-align: center; margin-top: 20px; font-size: 11px; color: #17382c; text-decoration: none; font-weight: 700;">← Kembali ke Beranda Utama</a>
        </div>
    </div>

</body>
</html>