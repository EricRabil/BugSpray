<?php
$_SESSION['user']['session_active'] = false;
unset($_SESSION['user']['email']);
unset($_SESSION['user']['displayname']);
unset($_SESSION['user']['rank']);
$rememberMeData = explode(':', $_COOKIE[$config['security']['rememberMeCookieKey']]);
$sql = "DELETE FROM persistence_tokens WHERE selector = ?";
$stmt = getConn()->prepare($sql);
$stmt->execute(array($rememberMeData[0]));
setcookie($config['security']['rememberMeCookieKey'], "invalidated-by-user-action", 1);
header('Location: '.$config['general']['host'].'/');
?>
