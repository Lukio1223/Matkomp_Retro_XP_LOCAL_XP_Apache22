/* TorrentZONE 2003 Classic JavaScript + Matkomp AJAX chat */
function updateClock() {
    var now = new Date();
    var h = now.getHours();
    var m = now.getMinutes();
    var s = now.getSeconds();
    if (h < 10) h = "0" + h;
    if (m < 10) m = "0" + m;
    if (s < 10) s = "0" + s;
    var clockElem = document.getElementById('liveClock');
    if (clockElem) {
        clockElem.innerHTML = h + ":" + m + ":" + s;
    }
    setTimeout(updateClock, 1000);
}

function downloadTorrent(filename) {
    alert("== BITTORRENT DOWNLOAD ==\n\nDatoteka: " + filename + "\nTracker: http://tracker.torrentzone.net:6969/announce\n\nZa prenos potrebujete odjemalec (BitTornado, ABC ali Azureus)!");
}

function sendChatMessage() {
    var msgInput = document.getElementById('chatInput');
    var chatBox = document.getElementById('chatBox');
    if (msgInput && chatBox && trim(msgInput.value) !== '') {
        var user = "Uporabnik_" + Math.floor(Math.random() * 899 + 100);
        chatBox.value += "\n<" + user + "> " + msgInput.value;
        msgInput.value = '';
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

function trim(s) {
    return s.replace(/^\s+|\s+$/g, '');
}

// Simple JS compatible with old browsers (IE6/7 friendly) - Matkomp initChat
function xhrCreate() {
  try { return new XMLHttpRequest(); } catch(e) {}
  try { return new ActiveXObject('Msxml2.XMLHTTP'); } catch(e) {}
  try { return new ActiveXObject('Microsoft.XMLHTTP'); } catch(e) {}
  return null;
}

function initChat(opts) {
  var pollUrl = opts.pollUrl;
  var postUrl = opts.postUrl;
  var container = document.getElementById(opts.containerId);
  var nameField = document.getElementById(opts.nameField);
  var msgField = document.getElementById(opts.msgField);
  var sendBtn = document.getElementById(opts.sendBtn);

  function renderLines(lines) {
    var html = '';
    if (!lines || lines.length === 0) {
      container.innerHTML = '<div class="empty">No messages</div>';
      return;
    }
    for (var i=0;i<lines.length;i++) {
      var l = lines[i];
      var time = l.time || '';
      var author = l.author || '';
      var msg = l.message || '';
      html += '<div><strong>['+time+'] '+escapeHtml(author)+':</strong> '+escapeHtml(msg)+'</div>';
    }
    container.innerHTML = html;
    container.scrollTop = container.scrollHeight;
  }

  function fetch() {
    var xhr = xhrCreate();
    if (!xhr) return;
    xhr.open('GET', pollUrl, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        var txt = xhr.responseText;
        if (!txt) { return; }
        try {
          var data = (window.JSON && JSON.parse) ? JSON.parse(txt) : eval(txt);
          renderLines(data);
        } catch(e) {
          // fallback parse plain lines
          var lines = txt.split("\n");
          var out = [];
          for (var i=0;i<lines.length;i++) {
            if (lines[i].indexOf('|') !== -1) {
              var parts = lines[i].split('|');
              out.push({time:parts[0], author:parts[1], message:parts[2]});
            }
          }
          renderLines(out);
        }
      }
    };
    xhr.send(null);
  }

  function send() {
    var name = nameField.value || 'Gost';
    var msg = msgField.value || '';
    if (msg === '') return;
    var xhr = xhrCreate();
    if (!xhr) return;
    var data = 'name=' + encodeURIComponent(name) + '&message=' + encodeURIComponent(msg);
    xhr.open('POST', postUrl, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        msgField.value = '';
        fetch();
      }
    };
    xhr.send(data);
  }

  function escapeHtml(s) {
    if (!s) return '';
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  sendBtn.onclick = send;
  setInterval(fetch, 3000);
  setInterval(function(){}, 1000);
  fetch();
}
