<?php
session_start();
unset($_SESSION['matkomp_admin']);
header('Location: index.php');
exit;