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
?>
