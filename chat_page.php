<?php
require_once __DIR__ . '/inc/common.php';
session_start();
include __DIR__ . '/inc/header.php';
?>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000">
<tr><td>
    <table width="100%" border="0" cellspacing="0" cellpadding="8" bgcolor="#002244">
        <tr>
            <td width="65%">
                <span class="header-title">TorrentZONE .net</span><br>
                <span class="header-sub">IRC Webchat - Matkomp Retro</span>
            </td>
            <td width="35%" align="right" valign="bottom">
                <font color="#FFFF00"><b>Lokalni čas:</b></font>
                <font color="#FFFFFF"><span id="liveClock">00:00:00</span></font>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="nav-bar">
        <tr><td>
            <a href="index.php">[ DOMOV ]</a>
            <a href="torrents.php">[ TORRENTI ]</a>
            <a href="chat_page.php" class="active">[ IRC CHAT ]</a>
        </td></tr>
    </table>

    <table width="100%" border="0" cellspacing="4" cellpadding="0">
        <tr valign="top">
            <td width="160">
                <div class="panel">
                    <b>Uporabniški seznam</b><br>
                    <select size="10" style="width:100%; background:#000; color:#fff; font-family:monospace;">
                        <option>@Admin_Luka</option>
                        <option>@Op_Matkomp</option>
                        <option>Leecher99</option>
                        <option>SloTech_Fan</option>
                        <option>Guest_402</option>
                    </select>
                </div>
            </td>
            <td width="630">
                <div class="panel">
                    <h2>IRC WEBCHAT (#matkomp)</h2>
                    <textarea id="chatBox" readonly class="input-xp" style="width:100%; height:260px; background:#000; color:#0f0; font-family:'Courier New', monospace;">*** Connected to #matkomp
*** Welcome to Matkomp Retro Chat
</textarea>
                    <div style="margin-top:6px;">
                        Ime: <input type="text" id="chat_name" class="input-xp" value="Gost" />
                        Sporočilo: <input type="text" id="chat_msg" class="input-xp" style="width:50%;" />
                        <button id="chat_send" class="btn-xp">POŠLJI</button>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="6" bgcolor="#002244">
        <tr><td align="center"><font color="#FFFFFF" size="1">© Matkomp Retro Chat</font></td></tr>
    </table>

</td></tr>
</table>

<script src="js/script.js"></script>
<script type="text/javascript">
initChat({
  pollUrl: 'chat.php',
  postUrl: 'chat.php',
  containerId: 'chatBox',
  nameField: 'chat_name',
  msgField: 'chat_msg',
  sendBtn: 'chat_send'
});
</script>

<?php include __DIR__ . '/inc/footer.php'; ?>