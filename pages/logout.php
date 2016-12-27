<?php
$_SESSION['user']['session_active'] = false;
unset($_SESSION['user']['email']);
unset($_SESSION['user']['displayname']);
unset($_SESSION['user']['rank']);
header('Location: '.$config['general']['host'].'/');
?>
