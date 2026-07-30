<?php

require_once "../classes/User.php";

session_start();

$message="";

if(isset($_POST['login']))
{

$email=$_POST['email'];

$password=$_POST['password'];

$user=new User();

$data=$user->login($email,$password);

if($data)
{

$_SESSION['user']=$data;

header("Location: dashboard.php");

exit;

}

else
{

$message="Email atau Password salah.";

}

}

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Lunara Login</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container">

<div class="login-card">

<div class="logo-area">

    <div class="logo-circle">

        🌸

    </div>

    <h1>Lunara</h1>

    <p>Menstrual Health Tracker</p>

</div>

<?php if($message!=""){ ?>

<div class="alert error">

<?= $message ?>

</div>

<?php } ?>

<form method="POST">

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
    autocomplete="current-password"
    required>
<button
type="submit"
name="login">

Login

</button>

</form>

<p class="register-text">

Belum punya akun?

<a href="register.php">

Daftar

</a>

</p>

</div>

</div>

</body>

</html>