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
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000">
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="8" bgcolor="#002244">
                <tr>
                    <td width="65%">
                        <span class="header-title">TorrentZONE .net</span><br>
                        <span class="header-sub">Slovenski IT, Hardware & BitTorrent Portal | Edicija Retro</span>
                    </td>
                    <td width="35%" align="right" valign="bottom">
                        <font color="#FFFF00"><b>Lokalni čas:</b></font>
                        <font color="#FFFFFF"><span id="liveClock">00:00:00</span></font><br>
                        <font color="#CCCCCC" size="1">Uporabnikov na liniji: <b>1,429</b></font>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="nav-bar">
                <tr>
                    <td>
                        <a href="index.php">[ DOMOV ]</a>
                        <a href="torrents.php">[ TORRENTI ]</a>
                        <a href="upload.php">[ DODAJ TORRENT ]</a>
                        <a href="forum.php" class="active">[ FORUM ]</a>
                        <a href="chat_page.php">[ IRC CHAT ]</a>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFCC">
                <tr>
                    <td style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                        <marquee scrollamount="3" scrolldelay="60">
                            <b>[NOVOSTI RETRO]:</b> Dobrodošli na Matkomp Retro forum - deluje localno in brez MySQL!
                        </marquee>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" cellspacing="4" cellpadding="0">
                <tr valign="top">

<td width="160">
    <table width="100%" border="1" cellspacing="0" cellpadding="2" bordercolor="#999999">
        <tr><td class="cat-title">PRIJAVA</td></tr>
        <tr class="row-odd">
            <td>
                <form style="margin:0px;">
                    Uporabnik:<br>
                    <input type="text" class="input-xp" style="width:140px;"><br>
                    Geslo:<br>
                    <input type="password" class="input-xp" style="width:140px;"><br>
                    <input type="checkbox"> Zapomni si<br>
                    <input type="button" value="Prijava" class="btn-xp" onclick="alert('Prijava uspešna!');">
                </form>
            </td>
        </tr>
    </table>
    <br>

    <table width="100%" border="1" cellspacing="0" cellpadding="2" bordercolor="#999999">
        <tr><td class="cat-title">KATEGORIJE</td></tr>
        <tr class="row-odd">
            <td>
                &bull; <a href="torrents.php">Aplikacije</a><br>
                &bull; <a href="torrents.php">Igre</a><br>
                &bull; <a href="torrents.php">Operacijski sistemi</a><br>
                &bull; <a href="torrents.php">Filmi & Anime</a><br>
                &bull; <a href="torrents.php">Glasba / MP3</a>
            </td>
        </tr>
    </table>
    <br>

</td>

<td width="630">
    <table width="100%" border="1" cellspacing="0" cellpadding="4" bordercolor="#999999">
        <tr><td class="cat-title">FORUM - Objavi novo sporočilo</td></tr>
        <tr class="row-odd">
            <td>
                <?php if (!empty($errors)): ?>
                    <div class="errors"><?php foreach ($errors as $er) echo e($er) . '<br/>'; ?></div>
                <?php endif; ?>
                <form method="post" action="forum.php">
                    <?php echo csrf_field(); ?>
                    Ime:<br>
                    <input type="text" name="name" class="input-xp" style="width:300px;" value="<?php echo e(isset($_POST['name'])?$_POST['name']:''); ?>"><br>
                    Naslov:<br>
                    <input type="text" name="title" class="input-xp" style="width:300px;" value="<?php echo e(isset($_POST['title'])?$_POST['title']:''); ?>"><br>
                    Sporočilo:<br>
                    <textarea name="message" class="input-xp" rows="6" style="width:100%;"><?php echo e(isset($_POST['message'])?$_POST['message']:''); ?></textarea><br>
                    <input type="submit" value="OBJAVI" class="btn-xp">
                </form>
            </td>
        </tr>
    </table>
    <br>

    <table width="100%" border="1" cellspacing="0" cellpadding="4" bordercolor="#CCCCCC">
        <tr bgcolor="#003366"><td colspan="3"><font color="#FFFFFF"><b>Zadnje objave</b></font></td></tr>
        <?php if (empty($posts)): ?>
            <tr class="row-odd"><td colspan="3">Ni objav</td></tr>
        <?php else: foreach ($posts as $p): ?>
            <tr class="row-odd">
                <td width="140"><b><?php echo e($p['title']); ?></b><br><font size="1"><?php echo e($p['author']); ?> - <?php echo e($p['date']); ?> <?php echo e($p['time']); ?></font></td>
                <td><?php echo nl2br(e($p['message'])); ?></td>
            </tr>
        <?php endforeach; endif; ?>
    </table>

</td>

                </tr>
            </table>

            <table width="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="#002244">
                <tr>
                    <td align="center">
                        <font color="#FFFFFF" size="1">
                            Copyright &copy; Matkomp Retro. Local build.
                        </font>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

<?php include __DIR__ . '/inc/footer.php'; ?>