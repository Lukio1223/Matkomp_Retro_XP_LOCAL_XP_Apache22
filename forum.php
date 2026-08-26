<?php
require_once __DIR__ . '/inc/common.php';
session_start();

$file = __DIR__ . '/db/forum.txt';

$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors[] = 'CSRF token missing or invalid.';
    } else {
        $name = isset($_POST['name']) ? trim($_POST['name']) : 'Gost';
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';
        if ($name === '') $name = 'Gost';
        if ($title === '') $errors[] = 'Naslov je obvezen.';
        if ($message === '') $errors[] = 'Sporočilo je obvezno.';
        if (strlen($title) > 200) $errors[] = 'Naslov pre dolg.';
        if (strlen($message) > 2000) $errors[] = 'Sporočilo pre dolgo.';
        if (empty($errors)) {
            $entry = array(
              'date'=>date('Y-m-d'),
              'time'=>date('H:i:s'),
              'author'=>$name,
              'title'=>$title,
              'message'=>$message
            );
            append_data_line($file, $entry);
            header('Location: forum.php');
            exit;
        }
    }
}

$posts = read_json_lines($file);
$posts = array_reverse($posts);
include __DIR__ . '/inc/header.php';
?>
<div class="container">
  <div class="nav"><a href="index.php">Domov</a> | <a href="forum.php">Forum</a></div>
  <div class="panel">
    <h2>Forum</h2>
    <?php if (!empty($errors)): ?>
      <div class="errors">
        <?php foreach ($errors as $e): ?><div><?php echo e($e); ?></div><?php endforeach; ?>
      </div>
    <?php endif; ?>
    <form method="post" action="forum.php" class="forum-form">
      <?php echo csrf_field(); ?>
      Ime: <input type="text" name="name" value="<?php echo e(isset($_POST['name']) ? $_POST['name'] : ''); ?>" /><br/>
      Naslov: <input type="text" name="title" value="<?php echo e(isset($_POST['title']) ? $_POST['title'] : ''); ?>" /><br/>
      Sporočilo:<br/>
      <textarea name="message" rows="6" cols="60"><?php echo e(isset($_POST['message']) ? $_POST['message'] : ''); ?></textarea><br/>
      <input type="submit" value="OBJAVI" />
    </form>

    <h3>Zadnje objave</h3>
    <?php if (empty($posts)): ?><div>Ni objav</div><?php else: ?>
      <?php foreach ($posts as $p): ?>
        <div class="forum-post">
          <div class="fmeta"><?php echo e($p['date']); ?> <?php echo e($p['time']); ?> - <strong><?php echo e($p['author']); ?></strong> - <?php echo e($p['title']); ?></div>
          <div class="fbody"><?php echo nl2br(e($p['message'])); ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>