<?php
if($config['security']['registration']['registrationType'] == 3){
  //Terminate signup attempt; Registration (and only registration) is disabled.
  $_SESSION['pages']['index']['message'] = 'A03';
  header('Location: '.$config['general']['host'].'/');
  exit();
}
render("signup.phtml", "Signup for BugSpray", $context = array(), $styles = array(), $scripts = array(), "HS::Null");
?>
