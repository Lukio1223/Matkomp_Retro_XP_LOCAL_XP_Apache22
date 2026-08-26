<?php
require_once __DIR__ . '/inc/common.php';
include __DIR__ . '/inc/header.php';
$services = array(
  array('title'=>'Sestava PC-jev','icon'=>'🖥','desc'=>'Sestavimo sistem po meri, retro build, modern upgrade.'),
  array('title'=>'Nadgradnja računalnikov','icon'=>'🔧','desc'=>'RAM, HDD, SSD, BIOS posodobitve.'),
  array('title'=>'Reševanje podatkov','icon'=>'💽','desc'=>'Recover lost partitions, filesystem repair.'),
  array('title'=>'CD/DVD peka','icon'=>'📀','desc'=>'Peka varnostnih kopij, ISO creation.'),
  array('title'=>'Arhiviranje','icon'=>'🗄','desc'=>'Optična in fizična arhiva.'),
  array('title'=>'Postavitev strežnikov','icon'=>'🖧','desc'=>'Lokalni in domači strežniki, Windows Server 2003/2008.'),
  array('title'=>'Diagnostika','icon'=>'🔍','desc'=>'Stres testi, POST diagnostika.'),
  array('title'=>'Retro računalništvo','icon'=>'🎮','desc'=>'Obnavljanje starih sistemov in programske opreme.'),
  array('title'=>'Windows XP pomoč','icon'=>'🪟','desc'=>'Konfiguracija, aktivacija, update pack.'),
  array('title'=>'BIOS/UEFI pomoč','icon'=>'⚙','desc'=>'BIOS flash, recovery, CMOS.'),
  array('title'=>'Čiščenje računalnikov','icon'=>'🧹','desc'=>'Fizično čiščenje in termalna menjava.'),
  array('title'=>'Testiranje komponent','icon'=>'📊','desc'=>'Testi za stabilnost in error reporting.'),
);
?>
<div class="container">
  <?php include __DIR__ . '/inc/header.php'; ?>
  <div class="main">
    <div class="nav"><a href="index.php">Domov</a> | <a href="services.php">Storitve</a></div>
    <h2>Naše storitve</h2>
    <div class="service-grid">
      <?php foreach ($services as $s): ?>
      <div class="service">
        <div class="service-icon"><?php echo e($s['icon']); ?></div>
        <div class="service-title"><?php echo e($s['title']); ?></div>
        <div class="service-desc"><?php echo e($s['desc']); ?></div>
        <form method="post" action="mailto:example@local">
          <input type="button" value="Več" onclick="alert('Za naročilo nas kontaktirajte: example@local');" />
        </form>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php include __DIR__ . '/inc/footer.php'; ?>
</div>