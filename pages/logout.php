<?php
$_SESSION['user']['session_active'] = false;
unset($_SESSION['user']['email']);
unset($_SESSION['user']['displayname']);
unset($_SESSION['user']['rank']);
setcookie($config['security']['rememberMeCookieKey'], "invalidated-by-user-action", 1);
header('Location: '.$config['general']['host'].'/');
?>
