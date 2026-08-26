<?php
require_once __DIR__ . '/inc/common.php';
session_start();
include __DIR__ . '/inc/header.php';
?>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000">
<tr><td>
    <table width="100%" border="0" cellspacing="0" cellpadding="8" bgcolor="#002244">
        <tr>
            <td width="65%"><span class="header-title">Matkomp Retro</span><br><span class="header-sub">FAQ</span></td>
            <td width="35%" align="right"><font color="#FFFF00"><b>Lokalni čas:</b></font> <font color="#FFFFFF"><span id="liveClock">00:00:00</span></font></td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="4" cellpadding="0"><tr valign="top">
        <td width="160">
            <div class="panel">
                <b>Pogosto zastavljeno</b><br>
            </div>
        </td>
        <td width="630">
            <div class="panel">
                <h2>FAQ</h2>
                <b>Kako namestim?</b>
                <p>Kopirajte mapo v Apache htdocs in odprite test.php za diagnostiko.</p>
                <b>Ali potrebujem internet?</b>
                <p>Ne, osnovne funkcije delujejo offline; joke generator bo uporabil internet le če je na voljo.</p>
            </div>
        </td>
    </tr></table>

    <table width="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="#002244"><tr><td align="center"><font color="#FFFFFF" size="1">© Matkomp Retro FAQ</font></td></tr></table>

</td></tr></table>

<?php include __DIR__ . '/inc/footer.php'; ?>