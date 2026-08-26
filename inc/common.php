<?php
// common functions - PHP 5.x compatible
if (!defined('MATKOMP_COMMON')) define('MATKOMP_COMMON', 1);

function e($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function read_data_lines($file) {
    $out = array();
    if (!file_exists($file)) return $out;
    $fh = @fopen($file, 'r');
    if (!$fh) return $out;
    while (!feof($fh)) {
        $line = fgets($fh);
        if ($line === false) break;
        $line = trim($line);
        if ($line === '') continue;
        $out[] = $line;
    }
    fclose($fh);
    return $out;
}

function read_json_lines($file) {
    $out = array();
    if (!file_exists($file)) return $out;
    $lines = read_data_lines($file);
    foreach ($lines as $l) {
        $obj = null;
        if (function_exists('json_decode')) {
            $dec = json_decode($l, true);
            if ($dec !== null) $obj = $dec;
        }
        if ($obj === null) {
            // fallback to unserialize
            $maybe = @unserialize($l);
            if ($maybe !== false && is_array($maybe)) $obj = $maybe;
            else {
                // try pipe-splitting
                $parts = explode("\t", $l);
                if (count($parts) >= 3) {
                    $obj = array('time'=>$parts[0],'author'=>isset($parts[1])?$parts[1]:'','message'=>isset($parts[2])?$parts[2]:'');
                } else {
                    $obj = array('raw'=>$l);
                }
            }
        }
        $out[] = $obj;
    }
    return $out;
}

function append_data_line($file, $data) {
    $dir = dirname($file);
    if (!is_dir($dir)) @mkdir($dir, 0755, true);
    $use_json = function_exists('json_encode');
    $line = $use_json ? json_encode($data) : serialize($data);
    $fh = fopen($file, 'a');
    if ($fh) {
        if (flock($fh, LOCK_EX)) {
            fwrite($fh, $line . "\n");
            fflush($fh);
            flock($fh, LOCK_UN);
        } else {
            // still try
            fwrite($fh, $line . "\n");
        }
        fclose($fh);
        return true;
    }
    return false;
}

function get_counter() {
    $file = __DIR__ . '/../db/counter.txt';
    if (!file_exists($file)) return 0;
    $val = intval(@file_get_contents($file));
    return $val;
}

function increment_counter() {
    $file = __DIR__ . '/../db/counter.txt';
    $dir = dirname($file);
    if (!is_dir($dir)) @mkdir($dir,0755,true);
    $fh = fopen($file, 'c+');
    if (!$fh) return false;
    if (flock($fh, LOCK_EX)) {
        $contents = stream_get_contents($fh);
        $num = intval($contents);
        $num++;
        ftruncate($fh, 0);
        rewind($fh);
        fwrite($fh, (string)$num);
        fflush($fh);
        flock($fh, LOCK_UN);
        fclose($fh);
        return true;
    }
    fclose($fh);
    return false;
}

// CSRF
function csrf_token() {
    if (!isset($_SESSION)) @session_start();
    if (empty($_SESSION['matkomp_csrf'])) {
        $_SESSION['matkomp_csrf'] = md5(uniqid('', true));
    }
    return $_SESSION['matkomp_csrf'];
}

function csrf_field() {
    $t = csrf_token();
    return '<input type="hidden" name="csrf_token" value="'.e($t).'" />';
}

function verify_csrf() {
    if (!isset($_SESSION)) @session_start();
    if (!isset($_POST['csrf_token'])) return false;
    return ($_POST['csrf_token'] === @$_SESSION['matkomp_csrf']);
}

// small helpers
function get_uptime() {
    // try Windows: no /proc, so use script start time approximated by filemtime
    $startfile = __DIR__ . '/../db/counter.txt';
    if (file_exists($startfile)) {
        $t = filemtime($startfile);
        $diff = time() - $t;
        $h = floor($diff/3600);
        $m = floor(($diff%3600)/60);
        return $h . 'h ' . $m . 'm';
    }
    return 'n/a';
}

function random_quote() {
    $q = array(
      "Welcome to Matkomp - retro portal!",
      "Best viewed with Internet Explorer 6 (just kidding).",
      "Remember to backup your floppy disks.",
      "MSN nostalgia: add matkomp@local to your buddylist."
    );
    return $q[array_rand($q)];
}