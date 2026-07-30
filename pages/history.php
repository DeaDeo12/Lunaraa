<?php

session_start();

if(!isset($_SESSION['user'])){

    header("Location: login.php");

    exit;

}

require_once "../classes/MenstrualCycle.php";

$cycle = new MenstrualCycle();

$dataHistory = $cycle->getHistory(
    $_SESSION['user']['id']
);


?>


<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Riwayat Siklus | Lunara</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="dashboard">

<?php include "../includes/sidebar.php"; ?>

<div class="content">

<h1>📅 Riwayat Menstruasi</h1>

<p>
Berikut adalah catatan siklus menstruasi Anda.
</p>


<?php if(count($dataHistory) > 0){ ?>

<?php foreach($dataHistory as $history){ ?>


<div class="card">


<h3>
🩸 
<?= date(
"d F Y",
strtotime($history['start_date'])
); ?>

</h3>


<p>

Lama siklus:

<?= $history['cycle_length']; ?>

hari

</p>


<p>

Lama menstruasi:

<?= $history['period_length']; ?>

hari

</p>


<p>

Prediksi menstruasi berikutnya:

<br>

<strong>

<?= date(
"d F Y",
strtotime($history['next_period'])
); ?>

</strong>

</p>

<small>

Dicatat:

<?= date(
"d F Y",
strtotime($history['created_at'])
); ?>

</small>

</div>

<?php } ?>

<?php }else{ ?>

<div class="card">

<h3>
Belum ada riwayat menstruasi
</h3>

<p>
Silakan tambahkan data siklus terlebih dahulu.
</p>

</div>

<?php } ?>

</div>

</div>

</body>

</html>