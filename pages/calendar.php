<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "../classes/MenstrualCycle.php";

$message = "";

if (isset($_POST['simpan'])) {

    $userId = $_SESSION['user']['id'];
    $startDate = $_POST['start_date'];
    $cycleLength = $_POST['cycle_length'];
    $periodLength = $_POST['period_length'];

    $cycle = new MenstrualCycle();

    if ($cycle->save($userId, $startDate, $cycleLength, $periodLength)) {
        $message = "Data siklus berhasil disimpan.";
    } else {
        $message = "Gagal menyimpan data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Siklus Menstruasi | Lunara</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="dashboard">

<?php include "../includes/sidebar.php"; ?>

<div class="content">

<h1>🩸 Input Siklus Menstruasi</h1>

<p>Silakan isi data menstruasi Anda.</p>

<?php if($message!=""){ ?>

<div class="alert success">

<?= $message ?>

</div>

<?php } ?>

<form method="POST">

<label>Tanggal Hari Pertama Menstruasi</label>

<input
type="date"
name="start_date"
required>

<label>Lama Siklus (Hari)</label>

<input
type="number"
name="cycle_length"
min="20"
max="40"
required>

<label>Lama Menstruasi (Hari)</label>

<input
type="number"
name="period_length"
min="1"
max="10"
required>

<button
type="submit"
name="simpan">

Simpan

</button>

</form>

</div>

</div>

</body>

</html>