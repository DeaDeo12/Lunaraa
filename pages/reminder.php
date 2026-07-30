<?php

session_start();

if(!isset($_SESSION['user'])){

    header("Location: login.php");

    exit;

}

require_once "../classes/Reminder.php";

$message = "";

$reminder = new Reminder();


if(isset($_POST['simpan'])){


    $userId = $_SESSION['user']['id'];

    $type = $_POST['type'];

    $time = $_POST['time'];



    if($reminder->save(
        $userId,
        $type,
        $time
    )){


        $message = "Reminder berhasil ditambahkan.";


    }else{


        $message = "Reminder gagal disimpan.";


    }


}

$data = $reminder->getReminder(

    $_SESSION['user']['id']

);


?>
<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Reminder | Lunara</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="dashboard">

<?php include "../includes/sidebar.php"; ?>

<div class="content">

<h1>⏰ Reminder Kesehatan</h1>

<p>
Atur pengingat untuk membantu menjaga kesehatan selama siklus menstruasi.
</p>



<?php if($message != ""){ ?>

<div class="alert success">

<?= $message ?>

</div>

<?php } ?>


<div class="reminder-container">


<div class="card reminder-form">

<h2>
🌸 Tambah Reminder
</h2>


<form method="POST">

<label>
Jenis Reminder
</label>

<select name="type" required>

<option value="🩸 Ganti Pembalut">
🩸 Ganti Pembalut
</option>

<option value="💧 Minum Air">
💧 Minum Air
</option>

<option value="💊 Tablet Tambah Darah">
💊 Tablet Tambah Darah
</option>

</select>

<label>
Waktu Pengingat
</label>

<input 
type="time"
name="time"
required>

<button 
type="submit"
name="simpan">

Simpan Reminder

</button>

</form>

</div>


<div class="reminder-list">

<h2>
📌 Reminder Aktif
</h2>

<?php if(count($data) > 0){ ?>

<?php foreach($data as $r){ ?>

<div class="reminder-card">

<div class="reminder-icon">

<?= mb_substr($r['type'],0,2); ?>

</div>

<div>

<h3>

<?= htmlspecialchars($r['type']); ?>

</h3>

<p>

⏰ <?= htmlspecialchars($r['time']); ?>

</p>

</div>

</div>

<?php } ?>

<?php }else{ ?>

<div class="card">

<p>

Belum ada reminder yang dibuat.

</p>

<small>

Tambahkan pengingat untuk membantu menjaga kesehatanmu 🌸

</small>

</div>


<?php } ?>

</div>

</div>

</div>

</div>

</body>

</html>