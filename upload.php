<?php
require_once __DIR__ . '/inc/common.php';
session_start();
$upload_dir = __DIR__ . '/uploads/';
$maxSize = 25 * 1024 * 1024; // 25 MB
$allowed = array('zip','rar','7z','iso','img','bin','cue','txt','pdf','jpg','jpeg','png');

$errors = array();
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    if (!verify_csrf()) $errors[] = 'CSRF token invalid';
    $f = $_FILES['file'];
    if ($f['error'] !== 0) $errors[] = 'Upload error code: ' . intval($f['error']);
    if ($f['size'] > $maxSize) $errors[] = 'Datoteka prevelika (max 25MB).';
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) $errors[] = 'Tip datoteke ni dovoljen.';
    if (empty($errors)) {
        $safe = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $f['name']);
        $target = $upload_dir . $safe;
        if (!move_uploaded_file($f['tmp_name'], $target)) {
            $errors[] = 'Neuspešno premikanje datoteke.';
        } else {
            // set safe permissions if possible
            @chmod($target, 0644);
            $success = 'Datoteka naložena: ' . e($safe);
        }
    }
}

// list files
$files = array();
$dh = @opendir($upload_dir);
if ($dh) {
  while (($file = readdir($dh)) !== false) {
    if ($file === '.' || $file === '..') continue;
    $files[] = $file;
  }
  closedir($dh);
}
include __DIR__ . '/inc/header.php';
?>
<div class="container">
  <div class="nav"><a href="index.php">Domov</a> | <a href="upload.php">Upload</a></div>
  <div class="panel">
    <h2>Upload center (lokalno)</h2>
    <?php if ($success): ?><div class="success"><?php echo e($success); ?></div><?php endif; ?>
    <?php if (!empty($errors)): foreach ($errors as $er): ?><div class="errors"><?php echo e($er); ?></div><?php endforeach; endif; ?>
    <form method="post" enctype="multipart/form-data" action="upload.php">
      <?php echo csrf_field(); ?>
      Izberi datoteko: <input type="file" name="file" /><br/>
      <input type="submit" value="Naloži" />
    </form>

    <h3>Seznam naloženih datotek</h3>
    <?php if (empty($files)): ?><div>Ni datotek.</div><?php else: ?>
      <ul>
      <?php foreach ($files as $f): ?>
        <li><a href="uploads/<?php echo rawurlencode($f); ?>"><?php echo e($f); ?></a></li>
      <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>