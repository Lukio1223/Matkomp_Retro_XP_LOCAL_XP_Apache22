// Simple JS compatible with old browsers (IE6/7 friendly)
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
      html += '<div><strong>['+time+'] '+author+':</strong> '+escapeHtml(msg)+'</div>';
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
  setInterval(function(){
    var now = new Date();
    // optional: show time somewhere
  }, 1000);
  fetch();
}