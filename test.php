<?php
require_once __DIR__ . '/inc/common.php';
session_start();
include __DIR__ . '/inc/header.php';

$checks = array(
  'PHP DELA' => function(){ return true; },
  'PHP VERZIJA' => function(){ return phpversion(); },
  'PHP SAPI' => function(){ return php_sapi_name(); },
  'OS' => function(){ return PHP_OS; },
  'json_encode' => function(){ return function_exists('json_encode'); },
  'session_start' => function(){ return function_exists('session_start'); },
  'file_put_contents' => function(){ return function_exists('file_put_contents'); },
  'fopen' => function(){ return function_exists('fopen'); },
);

?>
<div class="container">
  <div class="nav"><a href="index.php">Domov</a> | <a href="test.php">Test</a></div>
  <div class="panel">
    <h2>Test PHP / Apache</h2>
    <table class="testtable">
      <?php foreach ($checks as $k => $fn): 
          $res = $fn();
      ?>
      <tr>
        <td><?php echo e($k); ?></td>
        <td><?php if ($res === true) echo '<span class="ok">DA</span>'; elseif ($res === false) echo '<span class="no">NE</span>'; else echo '<span class="info">'.e($res).'</span>'; ?></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <h3>Navodila</h3>
    <p>If PHP code is shown as text on this page, PHP is not connected to Apache. See SETUP_XP_APACHE.txt.</p>
  </div>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>