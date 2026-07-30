<?php

require_once "../classes/User.php";

$message = "";
$messageType = "";

if (isset($_POST['register'])) {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];

    if ($password != $konfirmasi) {

        $message = "Password dan konfirmasi password tidak sama.";
        $messageType = "error";

    } else {

        $user = new User();
        $hasil = $user->register($nama, $email, $password);

        if ($hasil == "BERHASIL") {

            $message = "Registrasi berhasil! Silakan login.";
            $messageType = "success";

        } elseif ($hasil == "EMAIL_SUDAH_ADA") {

            $message = "Email sudah digunakan.";
            $messageType = "error";

        } else {

            $message = "Registrasi gagal.";
            $messageType = "error";
        }
    }
}
?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Register</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container">

<div class="login-card">

<h1>🌸 Lunara</h1>

<p>Buat akun baru</p>

<?php if ($message != "") : ?>

<div class="alert <?= $messageType ?>">
    <?= $message ?>
</div>

<?php endif; ?>

<form method="POST">

    <input
    type="text"
    name="nama"
    placeholder="Nama Lengkap"
    autocomplete="name"
    required>

    <input
    type="email"
    name="email"
    placeholder="Email"
    autocomplete="email"
    required>

    <input
    type="password"
    name="password"
    placeholder="Password"
    autocomplete="new-password"
    required>

    <input
    type="password"
    name="konfirmasi_password"
    placeholder="Konfirmasi Password"
    autocomplete="new-password"
    required>

    <button
        type="submit"
        name="register">
        Daftar
    </button>

</form>

<p class="register-text">

Sudah punya akun?

<a href="login.php">

Login

</a>

</p>

</div>

</div>

</body>

</html>