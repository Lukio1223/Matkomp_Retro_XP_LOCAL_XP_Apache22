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
            @chmod($target, 0644);
            $success = 'Datoteka naložena: ' . e($safe);
        }
    }
}
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
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000">
<tr><td>
    <table width="100%" border="0" cellspacing="0" cellpadding="8" bgcolor="#002244">
        <tr>
            <td width="65%"><span class="header-title">TorrentZONE .net</span><br><span class="header-sub">Upload Center - Matkomp Retro</span></td>
            <td width="35%" align="right"><font color="#FFFF00"><b>Lokalni čas:</b></font> <font color="#FFFFFF"><span id="liveClock">00:00:00</span></font></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="nav-bar"><tr><td>
        <a href="index.php">[ DOMOV ]</a>
        <a href="torrents.php">[ TORRENTI ]</a>
        <a href="upload.php" class="active">[ DODAJ TORRENT ]</a>
    </td></tr></table>

    <table width="100%" border="0" cellspacing="4" cellpadding="0"><tr valign="top">
        <td width="160">
            <div class="panel">
                <b>Navodila</b><br>
                Naložite datoteke, ki jih imate pravico deliti. Maks 25MB.
            </div>
        </td>
        <td width="630">
            <div class="panel">
                <?php if ($success): ?><div class="success"><?php echo e($success); ?></div><?php endif; ?>
                <?php if (!empty($errors)): foreach ($errors as $er): ?><div class="errors"><?php echo e($er); ?></div><?php endforeach; endif; ?>
                <form method="post" enctype="multipart/form-data" action="upload.php">
                    <?php echo csrf_field(); ?>
                    Izberi datoteko: <input type="file" name="file" class="input-xp" /><br>
                    <input type="submit" value="Naloži" class="btn-xp">
                </form>
            </div>

            <div class="panel">
                <h3>Seznam naloženih datotek</h3>
                <?php if (empty($files)): ?><div>Ni datotek.</div><?php else: ?>
                    <ul>
                    <?php foreach ($files as $f): ?>
                        <li><a href="uploads/<?php echo rawurlencode($f); ?>"><?php echo e($f); ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </td>
    </tr></table>

    <table width="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="#002244"><tr><td align="center"><font color="#FFFFFF" size="1">© Matkomp Retro Uploads</font></td></tr></table>

</td></tr></table>

<?php include __DIR__ . '/inc/footer.php'; ?>