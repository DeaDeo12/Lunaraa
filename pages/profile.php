<?php

session_start();

if(!isset($_SESSION['user'])){

    header("Location: login.php");

    exit;
}

require_once "../classes/User.php";

$userObject = new User();

$userData = $userObject->getProfile(
    $_SESSION['user']['id']
);

$message = "";


if(isset($_POST['simpan'])){

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);


    if($userObject->updateProfile(

        $_SESSION['user']['id'],
        $nama,
        $email

    )){

        $_SESSION['user']['nama'] = $nama;

        $_SESSION['user']['email'] = $email;

        $message = "Profil berhasil diperbarui.";

        $userData = $userObject->getProfile(
            $_SESSION['user']['id']
        );

    }else{

        $message = "Profil gagal diperbarui.";

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Profil | Lunara</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="dashboard">

<?php include "../includes/sidebar.php"; ?>

<div class="content">

<h1>👤 Profil Pengguna</h1>

<p>
Kelola informasi akun Lunara Anda.
</p>

<?php if($message!=""){ ?>

<div class="alert success">

<?= $message ?>

</div>

<?php } ?>

<div class="profile-card">

<div class="profile-header">

<div class="logo-circle">

🌸

</div>


<h2>

Profil Lunara

</h2>

<p>

Informasi akun pengguna

</p>

</div>


<form method="POST">

<label>

Nama Lengkap

</label>

<input

type="text"

name="nama"

value="<?= htmlspecialchars($userData['nama']); ?>"

required>

<label>

Email

</label>


<input

type="email"

name="email"

value="<?= htmlspecialchars($userData['email']); ?>"

required>


<label>

Tanggal Bergabung

</label>

<input

type="text"

value="<?= date(
"d F Y",
strtotime($userData['created_at'])
); ?>"

readonly>


<button

type="submit"

name="simpan">

Simpan Perubahan

</button>

</form>

</div>

</div>

</div>

</body>

</html>