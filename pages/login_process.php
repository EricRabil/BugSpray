<?php
$email = trim(cleanse($_POST['inputEmail']));
$password = $_POST['inputPassword'];
$rememberMe = isset($_POST['rememberMe']) ? true : false;
$errorOcurred = false;
if(empty($password)){
  //Error handler C01
  $_SESSION['pages']['login']['error'] = 'C01';
  $errorOcurred = true;
}

if(!$errorOcurred && empty($email) || !validEmail($email)){
  //Error handler C02
  $_SESSION['pages']['login']['error'] = 'C02';
  $errorOccured = true;
}

if($errorOcurred){
  $_SESSION['pages']['login']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname
  );
  header('Location: '.$config['general']['host'].'/login');
  exit();
}

$sql = "SELECT user_password FROM users WHERE user_email = ?";
$stmt = getConn()->prepare($sql);
$stmt->execute(array($email));

$results = $stmt->fetch(PDO::FETCH_ASSOC);

if(!isset($results['user_password'])){
  //E-mail not found
  $_SESSION['pages']['login']['error'] = 'C03';
  $_SESSION['pages']['login']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname
  );
  header('Location: '.$config['general']['host'].'/login');
  exit();
}

$storedPassword = $results['user_password'];
if(!password_verify($password, $storedPassword)){
  //Password is incorrect
  $_SESSION['pages']['login']['error'] = 'C03';
  $_SESSION['pages']['login']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname
  );
  header('Location: '.$config['general']['host'].'/login');
  exit();
}

$sql = "SELECT user_id, user_dname, user_rank FROM users WHERE user_email = ?";
$stmt = getConn()->prepare($sql);
$stmt->execute(array($email));

$results = $stmt->fetch(PDO::FETCH_ASSOC);
$userid = $results['user_id'];

if(!isset($results['user_dname']) || !isset($results['user_rank'])){
  //Internal error
  $_SESSION['pages']['login']['error'] = '000';
  $_SESSION['pages']['login']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname
  );
  header('Location: '.$config['general']['host'].'/login');
  exit();
}

if($rememberMe){
  //Cookie data
  $cookie = array();
  $cookie['selector'] = UUID::generateUUID();
  $cookie['validator'] = hash('sha256', $cookie['selector']);
  //Table data
  $selector = $cookie['selector'];
  $expires = date('Y-m-d H:i:s', strtotime('+7 days'));

  //Insert
  $sql = "INSERT INTO persistence_tokens (selector, validator, userid, expires) VALUES (?, ?, ?, ?)";
  $stmt = getConn()->prepare($sql);
  $stmt->execute(array($selector, $selector.':'.$cookie['validator'], $userid, $expires));

  //Set
  setcookie($config['security']['rememberMeCookieKey'], $cookie['selector'].':'.urldecode($cookie['validator']), strtotime('+7 days'), '/');
}

//Activate user!
$_SESSION['user'] = array(
  'email' => $email,
  'displayname' => $results['user_dname'],
  'rank' => $results['user_rank'],
  'session_active' => true,
  'login_activation_time' => time()
);

header('Location: '.$config['general']['host'].'/');
exit();
?>
