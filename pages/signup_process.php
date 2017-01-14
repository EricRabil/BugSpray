<?php
if(empty($_POST)){
  $_SESSION['pages']['signup']['error'] = 'A11';
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
if( !isset($_POST['inputEmail']) && !isset($_POST['inputPassword']) && !isset($_POST['inputDisplayname']) && !isset($_POST['inputPasswordConfirm']) && !empty($_POST)){
  $_SESSION['pages']['signup']['error'] = '000';
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
use ZxcvbnPhp\Zxcvbn;
if($config['security']['disableUserAuth']['disabled']){
  //Terminate signup attempt; Authentication systems are disabled.
  $_SESSION['pages']['signup']['error'] = 'A01';
  $_SESSION['pages']['signup']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname
  );
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
if($config['security']['registration']['registrationType'] == 3){
  //Terminate signup attempt; Registration (and only registration) is disabled.
  $_SESSION['pages']['signup']['error'] = 'A02';
  $errorOccured = true;
}
if($_SESSION['user']['session_active']){
  //Terminate signup attempt; User already logged in.
  header('Location: '.$config['general']['host'].'/');
  exit();
}
$email = trim(cleanse($_POST['inputEmail']));
$manualApproval = ($config['security']['registration']['registrationType'] == 2) ? 1 : 0;
$displayname = trim(cleanse($_POST['inputDisplayname']));
$userDataForSecComparison = array($email, $displayname);
$zxcvbn = new Zxcvbn();
$passwordRating = $zxcvbn->passwordStrength($_POST['inputPassword'], $userDataForSecComparison);
$errorOccured = false;
if($passwordRating < $config['security']['registration']['zxcvbnRequirement']){
  $_SESSION['pages']['signup']['error'] = 'A08';
  $errorOccured = true;
}
if (strlen($_POST['inputPassword']) < $config['security']['registration']['minimumCharacters']){
  $_SESSION['pages']['signup']['error'] = 'A09';
  $errorOccured = true;
}
if (strlen($_POST['inputPassword']) > 4096){
  $_SESSION['pages']['signup']['error'] = 'A10';
  $errorOccured = true;
}
if(!validEmail($email)){
  $_SESSION['pages']['signup']['error'] = 'A04';
  $errorOccured = true;
}
if(!$errorOccured && empty($displayname)){
  $_SESSION['pages']['signup']['error'] = 'A05';
  $errorOccured = true;
}
if(!$errorOccured && empty($_POST['inputPassword'])){
  $_SESSION['pages']['signup']['error'] = 'A06';
  $errorOccured = true;
}
if(!$errorOccured && empty($_POST['inputPasswordConfirm'])){
  $_SESSION['pages']['signup']['error'] = 'A06';
  $errorOccured = true;
}
if(!$errorOccured && $_POST['inputPassword'] != $_POST['inputPasswordConfirm']){
  $_SESSION['pages']['signup']['error'] = 'A07';
  $errorOccured = true;
}
if($errorOccured){
  $_SESSION['pages']['signup']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname
  );
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
$password = password_hash( base64_encode( hash('sha256', $_POST['inputPassword'], true) ), PASSWORD_DEFAULT);
$sql = 'SELECT user_id FROM users WHERE user_email = ?';
$stmt = getConn()->prepare($sql);
$stmt->execute(array($email));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(isset($result['user_id'])){
  //Terminate signup attempt; E-Mail is taken.
  $_SESSION['pages']['signup']['error'] = 'A03';
  $_SESSION['pages']['signup']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname
  );
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
$sql = 'INSERT INTO users (user_dname, user_email, user_password, manual_approval) VALUES (?, ?, ?, ?)';
$stmt = getConn()->prepare($sql);
$stmt->execute(array($displayname, $email, $password, $manualApproval));
if($manualApproval == 0){
  $_SESSION['user'] = array(
    'email' => $email,
    'displayname' => $displayname,
    'rank' => 'reporter',
    'session_active' => true,
    'login_activation_time' => time()
  );
  $_SESSION['pages']['index']['message'] = 'A02';
  header('Location: '.$config['general']['host'].'/');
}else{
  $_SESSION['pages']['index']['message'] = 'A01';
  header('Location: '.$config['general']['host'].'/');
}
?>
