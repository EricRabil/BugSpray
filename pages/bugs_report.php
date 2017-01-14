<?php
if(!$_SESSION['user']['session_active']){
  $_SESSION['pages']['index']['message'] = "001";
  header('Location: '.$config['general']['host'].'/');
  exit();
}
?>
