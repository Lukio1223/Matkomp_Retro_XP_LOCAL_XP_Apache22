<?php
require_once __DIR__ . '/inc/common.php';
session_start();
include __DIR__ . '/inc/header.php';
?>
<div class="container">
  <div class="nav"><a href="index.php">Domov</a> | <a href="chat_page.php">MSN Chat</a></div>
  <div class="panel chat-panel">
    <h2>MATKOMP MESSENGER</h2>
    <div id="chatbox" class="chatbox">
      <div class="loading">Loading chat...</div>
    </div>

    <div class="chat-form">
      Ime: <input type="text" id="chat_name" value="Gost" />
      Sporočilo: <input type="text" id="chat_msg" style="width:50%;" />
      <button id="chat_send">POŠLJI</button>
    </div>
  </div>
</div>

<script src="js/script.js"></script>
<script type="text/javascript">
initChat({
  pollUrl: 'chat.php',
  postUrl: 'chat.php',
  containerId: 'chatbox',
  nameField: 'chat_name',
  msgField: 'chat_msg',
  sendBtn: 'chat_send'
});
</script>

<?php include __DIR__ . '/inc/footer.php'; ?>