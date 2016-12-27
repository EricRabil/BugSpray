<?php
$email = trim(cleanse($_POST['inputEmail']));
$password = $_POST['inputPassword'];

if(empty($password)){
  //Error handler C01
}

if(empty($email)){
  //Error handler C02
}

if(!validEmail($email)){
  //Error handler C03
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
?>
