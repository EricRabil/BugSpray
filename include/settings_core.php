<?php
$config = array();
$config['security'] = array();
  $config['security']['registration'] = array();
    //Three types [Default 1]:
    //1 = Open registration - Users can signup and automatically have activated accounts
    //2 = Limited open registration - Users can signup but must be manually approved before
    //having an activated account
    //3 = Closed registration - Users cannot signup and must have an account made for them.
    $config['security']['registration']['registrationType'] = 1;
    $config['security']['registration']['minimumCharacters'] = 12;
    //0-4 - Do not change unless you know what you are doing
    //The lower this number is, the less complex passwords must be.
    $config['security']['registration']['zxcvbnRequirement'] = 3;

  $config['security']['login'] = array();
    //In seconds
    $config['security']['login']['userLoginDeactivationTime'] = 5400;

  //Setting disabled to true will result in the disappearance of login/signup elements
  //on the website.

  //The message must either be set to false or to a string. If set to false, there will be
  //no error message on the login screen and it will simply be greyed out.
  $config['security']['disableUserAuth'] = array(
    'disabled' => false,
    'message' => 'Logins are temporarily disabled while we resolve a security breach.'
  );

  $config['security']['rememberMeCookieKey'] = 'bstoken';
?>
