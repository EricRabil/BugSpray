<?php
/* This file is used to change the text used on the page. It (should) cover all
 * elements on the website.
 8
 */
$lang = array();

//Top Level Strings are reserved for commonly called or generic strings.

$lang['lang'] = 'en_US';

$lang['submitButton'] = 'Submit';

$lang['email'] = 'E-Mail';
$lang['password'] = 'Password';
$lang['logout'] = "Sign Out";

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
    //Generic errors
    $lang['errors']['000'] = "Internal Error";

    //Login / Registration - User authentication is disabled
    $lang['errors']['A01'] = "Sorry! User authentication systems are currently down. Please check back later.";
    //Registration - Registrations, and only registrations, are disabled.
    $lang['errors']['A02'] = "Sorry! User registration has been disabled. If you would like an account, please contact the admins.";
    //Registration - The e-mail is taken
    $lang['errors']['A03'] = "Sorry! That e-mail is taken. Please use a different one.";
    //Registration - The e-mail is empty
    $lang['errors']['A04'] = "Sorry! The e-mail field cannot be empty and must be valid.";
    //Registration - The displayname is empty.
    $lang['errors']['A05'] = "Sorry! The displayname field cannot be empty.";
    //Registration - The password is empty
    $lang['errors']['A06'] = "Sorry! The password field cannot be empty.";
    //Registration - The passwords do not match
    $lang['errors']['A07'] = "Sorry! The passwords must match.";
    //Registration - The password does not score a level 3 or higher on the ZXCVBN scale
    $lang['errors']['A08'] = "Sorry! The password does not meet ZXCVBN requirements. Please make sure you have alternating caps and your password is nothing obvious (like your name, email, displayname, etc.)";
    //Registration - The password's characters are shorter than INT $config['security']['registration']['minimumCharacters']
    $lang['errors']['A09'] = "Sorry! The password must be at least ".$config['security']['registration']['minimumCharacters']." characters long.";
    //Registration - The password's characters are longer than 4096 characters
    $lang['errors']['A10'] = "Hey there, you cryptographically-savy user! Your password is too secure - Please make it 4096 characters or lower.";

    //Login - The password is empty
    $lang['errors']['C01'] = $lang['errors']['A06'];
    //Login - The email is empty
    $lang['errors']['C02'] = $lang['errors']['A04'];
    //Login - The password is incorrect
    $lang['errors']['C03'] = "Sorry! The email or password is incorrect.";

$lang['messages'] = array();
    //Registration - Successful, awaiting manual approval
    $lang['messages']['A01'] = "Thanks for registering! This bug tracker requires users to be manually approved by the admins. Please check back in a few days/hours to see your status.";
    //Registration - Successful, no approval needed
    $lang['messages']['A02'] = "Thanks for registering! Your account is now active and free to report bugs :)";
    //Registration - Registration (and only registration) is disabled
    $lang['messages']['A03'] = "Sorry, registration has been disabled.";

$lang['messageTitles'] = array();
    //Registration - Successful, awaiting manual approval
    $lang['messageTitles']['A01'] = "Registration submitted - Awaiting approval";
    //Registration - Successful, no approval needed
    $lang['messageTitles']['A02'] = "Registration Successful!";
    //Registration - Registration (and only registration) is disabled
    $lang['messageTitles']['A03'] = "Registration Disabled";
?>
