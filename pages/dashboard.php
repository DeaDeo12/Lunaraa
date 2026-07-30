<?php

session_start();

if (!isset($_SESSION['user'])) {

    header("Location: login.php");

    exit;

}

$user = $_SESSION['user'];

require_once "../classes/MenstrualCycle.php";
require_once "../classes/DailyActivity.php";

$cycle = new MenstrualCycle();

$dataCycle = $cycle->getLatestCycle(
    $user['id']
);

$cycleStatus = $cycle->getCycleStatus(
    $user['id']
);

$activity = new DailyActivity();

/*SIMPAN AKTIVITAS*/

if(isset($_POST['activity'])){

    $activity->addActivity(
        $user['id'],
        $_POST['activity']

    );

    header("Location: dashboard.php");
    exit;

}

/*AKTIVITAS HARIAN*/

$dataActivity = $activity->getTodayActivity(

    $user['id']

);



/*DEFAULT STATUS*/

$water = 0;

$tablet = false;

$padCount = 0;


foreach($dataActivity as $item){

    if($item['activity_type'] == "💧 Minum Air"){

        $water++;

    }

    if($item['activity_type'] == "💊 Tablet Tambah Darah"){

        $tablet = true;

    }

    if($item['activity_type'] == "🩸 Ganti Pembalut"){

        $padCount++;

    }


}


include "../includes/header.php";

?>

<div class="dashboard">

<?php include "../includes/sidebar.php"; ?>

<div class="content">

<h1>
Halo, <?= htmlspecialchars($user['nama']); ?> 🌸
</h1>

<p>
Selamat datang di aplikasi Lunara.
</p>

<div class="alert success">

<?= htmlspecialchars($cycleStatus); ?>

</div>

<div class="cards">

<div class="card">

<h3>
🩸 Siklus Berikutnya
</h3>

<?php if($dataCycle){ ?>

<p>

<?= date(
"d F Y",
strtotime($dataCycle['next_period'])
); ?>

</p>

<small>

Siklus <?= $dataCycle['cycle_length']; ?> hari

</small>

<?php }else{ ?>

<p>
Belum ada data.
</p>


<?php } ?>

</div>

<div class="card">

<h3>
💧 Air Hari Ini
</h3>

<p>

<?= $water; ?> / 8 Gelas

</p>

<?php if($water < 8){ ?>

<form method="POST" action="dashboard.php">

<button
type="submit"
name="activity"
value="💧 Minum Air">

+ Tambah Gelas

</button>

</form>

<?php }else{ ?>

<p>
✅ Target air tercapai
</p>

<?php } ?>

</div>


<div class="card">

<h3>
💊 Tablet Tambah Darah
</h3>

<?php if($tablet){ ?>

<p>
✅ Sudah diminum hari ini
</p>

<?php }else{ ?>

<p>
❌ Belum diminum hari ini
</p>

<form method="POST" action="dashboard.php">

<button
type="submit"
name="activity"
value="💊 Tablet Tambah Darah">

Sudah Minum

</button>

</form>

<?php } ?>

</div>

<div class="card">

<h3>
🩹 Ganti Pembalut
</h3>

<?php if($padCount > 0){ ?>

<p>
✅ Sudah diganti
</p>


<p>
Jumlah hari ini:
<strong>
<?= $padCount; ?> kali
</strong>
</p>

<?php }else{ ?>

<p>
❌ Belum diganti
</p>

<?php } ?>

<form method="POST" action="dashboard.php">
<button
type="submit"
name="activity"
value="🩸 Ganti Pembalut">
Sudah Ganti
</button>

</form>
</div>
</div>
</div>
</div>
<?php include "../includes/footer.php"; ?>