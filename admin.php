<?php
require_once __DIR__ . '/inc/common.php';
session_start();
$adminPassword = 'CHANGE_ME'; // <-- change here

$loggedIn = false;
if (isset($_SESSION['matkomp_admin']) && $_SESSION['matkomp_admin'] === true) $loggedIn = true;

$errors = array();
if (isset($_POST['password'])) {
    if ($_POST['password'] === $adminPassword) {
        $_SESSION['matkomp_admin'] = true;
        $loggedIn = true;
    } else {
        $errors[] = 'Napačno geslo.';
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION['matkomp_admin']);
    header('Location: admin.php');
    exit;
}

include __DIR__ . '/inc/header.php';
?>
<div class="container">
  <div class="nav"><a href="index.php">Domov</a> | <a href="admin.php">Admin</a></div>
  <div class="panel">
    <h2>Admin panel</h2>
    <?php if (!$loggedIn): ?>
      <?php if (!empty($errors)): foreach ($errors as $e): ?><div class="errors"><?php echo e($e); ?></div><?php endforeach; endif; ?>
      <form method="post" action="admin.php">
        Admin geslo: <input type="password" name="password" /><br/>
        <input type="submit" value="PRIJAVA" />
      </form>
      <div class="note">Geslo najdete v admin.php spremenljivki <code>$adminPassword</code></div>
    <?php else: ?>
      <div class="admin-stats">
        <ul>
          <li>Obiskovalci: <?php echo e(get_counter()); ?></li>
          <li>Forum objave: <?php echo e(count(read_json_lines(__DIR__ . '/db/forum.txt'))); ?></li>
          <li>Chat sporočila: <?php echo e(count(read_json_lines(__DIR__ . '/db/chat.txt'))); ?></li>
          <li>Datoteke: <?php echo e(count(read_json_lines(__DIR__ . '/db/torrents.txt'))); ?></li>
        </ul>
      </div>
      <div><a href="admin.php?logout=1">ODJAVA</a></div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>