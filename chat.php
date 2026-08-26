<?php
require_once __DIR__ . '/inc/common.php';
session_start();

$file = __DIR__ . '/db/chat.txt';

// handle POST = new message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : 'Gost';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    if ($name === '') $name = 'Gost';
    if ($message !== '') {
        if (strlen($message) > 1000) $message = substr($message, 0, 1000);
        $entry = array(
          'time'=>date('H:i:s'),
          'author'=>$name,
          'message'=>$message
        );
        append_data_line($file, $entry);
        // redirect or return ok
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode(array('status'=>'ok'));
            exit;
        } else {
            header('Location: chat_page.php');
            exit;
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo 'Empty message';
        exit;
    }
}

// GET = return messages
$lines = read_json_lines($file);
$last = array_slice($lines, -200); // limit
if (function_exists('json_encode')) {
    header('Content-Type: application/json');
    echo json_encode($last);
    exit;
} else {
    // fallback: plain text separated
    header('Content-Type: text/plain');
    foreach ($last as $l) {
        echo $l['time'] . '|' . str_replace(array("\r","\n","|"),array('','','�'), $l['author']) . '|' . str_replace(array("\r","\n"),array(' ', ' '), $l['message']) . "\n";
    }
    exit;
}