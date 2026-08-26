<?php
require_once __DIR__ . '/inc/common.php';
session_start();
include __DIR__ . '/inc/header.php';
?>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000">
<tr><td>
    <table width="100%" border="0" cellspacing="0" cellpadding="8" bgcolor="#002244">
        <tr>
            <td width="65%"><span class="header-title">Matkomp Retro</span><br><span class="header-sub">About Matkomp</span></td>
            <td width="35%" align="right"><font color="#FFFF00"><b>Lokalni čas:</b></font> <font color="#FFFFFF"><span id="liveClock">00:00:00</span></font></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="4" cellpadding="0"><tr valign="top">
        <td width="160">
            <div class="panel">
                <b>Kontakt</b><br>
                Email: example@local
            </div>
        </td>
        <td width="630">
            <div class="panel">
                <h2>O Matkomp</h2>
                <p>Matkomp Retro je lokalni retro portal in servis, zasnovan za uporabo na starejših sistemih (Windows XP, Apache 2.2, PHP 5.x). Namenjen je testiranju, arhiviranju in lokalnemu delovanju.</p>
                <p>Vse funkcionalnosti (forum, chat, upload, seznam datotek) delujejo brez baze in so shranjene kot preproste .txt datoteke v db/ mapi.</p>
            </div>
        </td>
    </tr></table>

    <table width="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="#002244"><tr><td align="center"><font color="#FFFFFF" size="1">© Matkomp Retro</font></td></tr></table>

</td></tr></table>

<?php include __DIR__ . '/inc/footer.php'; ?>