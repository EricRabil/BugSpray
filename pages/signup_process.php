<?php
if($config['security']['disableUserAuth']['disabled']){
  //Terminate signup attempt; Authentication systems are disabled.
  $_SESSION['pages']['signup']['error'] = 'A01';
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
if($config['security']['registration']['registrationType'] == 3){
  //Terminate signup attempt; Registration (and only registration) is disabled.
  $_SESSION['pages']['signup']['error'] = 'A02';
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
$email = trim(cleanse($_POST['inputEmail']));
$manualApproval = ($config['security']['registration']['registrationType'] == 2) ? 1 : 0;
$displayname = trim(cleanse($_POST['inputDisplayname']));
$errorOccured = false;
if(!validEmail($email)){
  $_SESSION['pages']['signup']['error'] = 'A04';
  $errorOccured = true;
}
if(empty($displayname) && !$errorOccured){
  $_SESSION['pages']['signup']['error'] = 'A05';
  $errorOccured = true;
}
if(empty($_POST['inputPassword']) && !$errorOcurred){
  $_SESSION['pages']['signup']['error'] = 'A06';
  $errorOccured = true;
}
if($errorOccured){
  $_SESSION['pages']['signup']['error_fields'] = array(
    'inputEmail' => $email, 'inputDisplayname' => $displayname;
  );
  header('Location: '.$config['general']['host'].'/signup');
  exit();
}
$password = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
$sql = 'SELECT user_id FROM users WHERE user_email = ?';
$stmt = getConn()->prepare($sql);
$stmt->execute($email);
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
}else{
  $_SESSION['pages']['index']['message'] = 'A01';
  header('Location: '.$config['general']['host'].'/');
}
?>
