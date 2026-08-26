<?php
require_once __DIR__ . '/inc/common.php';
session_start();
$file = __DIR__ . '/db/torrents.txt';
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) $errors[] = 'CSRF token';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    if ($title === '') $errors[] = 'Title required';
    if ($category === '') $errors[] = 'Category required';
    if ($url === '') $errors[] = 'URL required';
    if (strlen($title) > 200) $errors[] = 'Title too long';
    if (empty($errors)) {
        $entry = array('date'=>date('Y-m-d'),'title'=>$title,'category'=>$category,'url'=>$url);
        append_data_line($file, $entry);
        header('Location: torrents.php');
        exit;
    }
}

$list = array_reverse(read_json_lines($file));
include __DIR__ . '/inc/header.php';
?>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000">
<tr><td>
    <table width="100%" border="0" cellspacing="0" cellpadding="8" bgcolor="#002244">
        <tr>
            <td width="65%"><span class="header-title">TorrentZONE .net</span><br><span class="header-sub">Seznam Torrentov - Matkomp Retro</span></td>
            <td width="35%" align="right"><font color="#FFFF00"><b>Lokalni čas:</b></font> <font color="#FFFFFF"><span id="liveClock">00:00:00</span></font></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="nav-bar"><tr><td>
        <a href="index.php">[ DOMOV ]</a>
        <a href="torrents.php" class="active">[ TORRENTI ]</a>
        <a href="upload.php">[ DODAJ TORRENT ]</a>
    </td></tr></table>

    <table width="100%" border="0" cellspacing="4" cellpadding="0"><tr valign="top">
        <td width="160">
            <div class="panel">
                <b>Kategorije</b><br>
                <a href="torrents.php">Aplikacije</a><br>
                <a href="torrents.php">Igre</a><br>
                <a href="torrents.php">Operacijski sistemi</a>
            </div>
        </td>
        <td width="630">
            <div class="panel">
                <form method="post" action="torrents.php">
                    <?php echo csrf_field(); ?>
                    Naslov: <input type="text" name="title" class="input-xp" style="width:60%;"><br>
                    Kategorija: <input type="text" name="category" class="input-xp" style="width:200px;"><br>
                    URL: <input type="text" name="url" class="input-xp" style="width:60%;"><br>
                    <input type="submit" value="DODAJ" class="btn-xp">
                </form>
            </div>

            <table width="100%" border="1" cellspacing="0" cellpadding="4" bordercolor="#CCCCCC">
                <tr bgcolor="#003366"><td colspan="3"><font color="#FFFFFF"><b>Seznam</b></font></td></tr>
                <?php foreach ($list as $row): ?>
                <tr class="row-odd">
                    <td width="120"><?php echo e($row['date']); ?></td>
                    <td><?php echo e($row['title']); ?></td>
                    <td width="140"><?php echo e($row['category']); ?> - <a href="<?php echo e($row['url']); ?>">Link</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </td>
    </tr></table>

    <table width="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="#002244"><tr><td align="center"><font color="#FFFFFF" size="1">© Matkomp Retro Torrents</font></td></tr></table>

</td></tr></table>

<?php include __DIR__ . '/inc/footer.php'; ?>