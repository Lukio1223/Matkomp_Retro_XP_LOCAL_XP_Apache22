<?php
require_once __DIR__ . '/inc/common.php';
session_start();
increment_counter();
$counter = get_counter();
$forum_posts = count(read_json_lines(__DIR__ . '/db/forum.txt'));
$chat_posts = count(read_json_lines(__DIR__ . '/db/chat.txt'));
$torrents = count(read_json_lines(__DIR__ . '/db/torrents.txt'));
$uptime = get_uptime();
$quote = random_quote();
include __DIR__ . '/inc/header.php';
?>
<div class="container">
  <div class="titlebar">
    <h1>MATKOMP</h1>
    <div class="subtitle">XP // WEB 2.0 // SERVICE PORTAL</div>
  </div>

  <div class="statusbar">
    <div class="status-left">
      Admin: <strong>Luka</strong> |
      Lokacija: <strong>Šentvid, Ljubljana</strong> |
      Status: <span class="online">ONLINE</span>
    </div>
    <div class="status-right">
      Visitor count: <strong><?php echo e($counter); ?></strong> |
      Uptime: <?php echo e($uptime); ?>
    </div>
  </div>

  <div class="main">
    <div class="nav">
      <a href="index.php">Domov</a> |
      <a href="services.php">Storitve</a> |
      <a href="forum.php">Forum</a> |
      <a href="chat_page.php">MSN Chat</a> |
      <a href="torrents.php">ISO / Datoteke</a> |
      <a href="upload.php">Upload</a> |
      <a href="admin.php">Admin</a> |
      <a href="jokes.php">Jokes</a>
    </div>

    <div class="columns">
      <div class="col-left">
        <div class="panel news">
          <h2>Matkomp News</h2>
          <div class="news-item">
            <div class="news-date">26. 08. 2026</div>
            <div class="news-title">Matkomp XP Portal je online!</div>
            <div class="news-body">Dobrodošli na retro izdaji Matkomp portala.</div>
          </div>
          <div class="news-item">
            <div class="news-date">25. 08. 2026</div>
            <div class="news-title">Retro chat z MSN vibe</div>
            <div class="news-body">Preizkusite lokalni chat in forum.</div>
          </div>
        </div>

        <div class="panel services-home">
          <h2>Oprema</h2>
          <ul>
            <li>Ryzen 9 9900X rig</li>
            <li>i7-950 Data Recovery Rig</li>
            <li>HP ML310e Gen8 v2 server</li>
            <li>LGA775 retro zbirka</li>
          </ul>
        </div>

        <div class="panel partners">
          <h2>Partnerji</h2>
          <div class="badge-box"><b>Winamp 2.91</b><br>It really whips the llama's ass!</div>
          <div class="badge-box" style="background-color:#FFCC00;"><b>GET Internet Explorer 6.0</b><br>Designed for XP</div>
          <div class="badge-box" style="background-color:#00CC00; color:#FFF;"><b>Nero Burning ROM</b><br>v5.5 Ready</div>
        </div>

        <div class="panel extra">
          <h2>PC of the day</h2>
          <div class="pc">Compaq Presario V2000 - restored</div>
          <h2>Retro hardware of the week</h2>
          <div class="pc">Intel Pentium 4 Northwood</div>
        </div>
      </div>

      <div class="col-right">
        <div class="panel stats">
          <h2>Statistika</h2>
          <table class="stattable">
            <tr><td>Obiskovalci:</td><td><?php echo e($counter); ?></td></tr>
            <tr><td>Forum objave:</td><td><?php echo e($forum_posts); ?></td></tr>
            <tr><td>Chat sporočila:</td><td><?php echo e($chat_posts); ?></td></tr>
            <tr><td>Datoteke:</td><td><?php echo e($torrents); ?></td></tr>
          </table>
        </div>

        <div class="panel quote">
          <h2>Random retro quote</h2>
          <div class="quote-text"><?php echo e($quote); ?></div>
        </div>

        <div class="panel status">
          <h2>Server status</h2>
          <ul>
            <li>PHP verzija: <?php echo e(phpversion()); ?></li>
            <li>PHP SAPI: <?php echo e(php_sapi_name()); ?></li>
            <li>OS: <?php echo e(PHP_OS); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-note">
    Best viewed with Internet Explorer 6 (joke). Local retro portal.
  </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>