<?php
/* This file is used to change the text used on the page. It (should) cover all
 * elements on the website.
 8
 */
$lang = array();
$lang['lang'] = 'en_US';

$lang['submitButton'] = 'Submit';

$lang['email'] = 'E-Mail';
$lang['password'] = 'Password';

$lang['signup']['titles'] = array(
  'registration' => "Registration",
  'tAndC' => "Terms and Conditions"
);
$lang['signup']['registrationForm'] = array(
  'dnameLabel' => "Display Name",
  'pass2Label' => "Repeat ".$lang['password'],
  'notifyMe' => "Send notifications to this email",
  'submit' => "Register"
);

$lang['login']['loginForm'] = array(
  'forgotPassword' => "Forgot your password?",
  'signupPlaintextHelper' => "Don't have an account?",
  'signupAttrHyperlink' => 'Join Us',
  'rememberMe' => 'keep me logged-in'
);

$lang['signup']['tAndC'] = <<<'EOT'
<p>
  By clicking on "Register" you agree to BugSpray's Terms and Conditions
</p>
<p>
  BugSpray and its data is proprietary. Making a request for your data does not have to be filled.
</p>
<p>
  Users are expected to be polite and listen to other users along with their complaints. The violation of this rule means you are subject to a suspension or termination, with no exceptions or explanations needed (although you may receive an e-mail explaining why.)
</p>
<p>
  Circumvention of bans from BugSpray may result in the blacklisting of your IP altogether, or resulting in registrations requiring moderator approval.
</p>
<p>
  BugSpray's terms may be updated without notice; it is your responsibility to check these terms regularly for changes. Failure to check the terms on your part does not result in an exemption of user discipline.
</p>
EOT;

$lang['page']['names'] = array(
  'home' => "Home",
  'recentbugs' => "Recent Bugs",
  'login' => "Sign In"
);

//Error ID assignment is as follows:
//A = Authentication - This is a large scope that covers logins, registrations, and user permissions.

$lang['errors'] = array();
    //Login / Registration - User authentication is disabled
    $lang['errors']['A01'] = "Sorry! User authentication systems are currently down. Please check back later.";
    //Registration - Registrations, and only registrations, are disabled.
    $lang['errors']['A02'] = "Sorry! User registration has been disabled. If you would like an account, please contact the admins.";
    //Registration - The e-mail is taken
    $lang['errors']['A03'] = "Sorry! That e-mail is taken. Please use a different one.";
    //Registration - The e-mail is empty
    $lang['errors']['A04'] = "Sorry! The e-mail field cannot be empty.";
    //Registration - The displayname is empty.
    $lang['errors']['A05'] = "Sorry! The displayname field cannot be empty.";
    //Registration - The password is empty
    $lang['errors']['A06'] = "Sorry! The password field cannot be empty.";

$lang['messages'] = array();
    $lang['messages']['A01'] = "Thanks for registering! This bug tracker requires users to be manually approved by the admins. Please check back in a few days/hours to see your status.";

$lang['messageTitles'] = array();
    $lang['messageTitles']['A01'] = "Registration Successful";
?>
