<?php
header('Content-type: text/html; charset=utf8');
require "settings_core.php";
require "lang.php";
require "settings.php";
require "UUID.php";
require "lib/htmlpurifier/HTMLPurifier.auto.php";
require "../vendor/autoload.php";
$pconfig = HTMLPurifier_Config::createDefault();
$pconfig->set('URI.MakeAbsolute', true); // make all URLs absolute using the base URL set above
$pconfig->set('AutoFormat.RemoveEmpty', true); // remove empty elements
$pconfig->set('HTML.Doctype', 'XHTML 1.0 Strict'); // valid XML output (?)
$pconfig->set('HTML.AllowedElements', array()); // remove all elements
$pconfig->set('HTML.AllowedAttributes', array()); // remove all attributes except a.href
$pconfig->set('CSS.AllowedProperties', array()); // remove all CSS
$purifier = new HTMLPurifier($pconfig);
ini_set('session.use_strict_mode', '1');
ini_set('session.save_handler', 'files');
ini_set('use_cookies', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.hash_function', 'sha256');
ini_set('session.hash_bits_per_character', '5');
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
//CTIP = Session protection information
if (!isset($_SESSION['ctip'])) {
    session_regenerate_id(true);
    $_SESSION['ctip'] = array(
			'creationTime' => time()
		);
}
// Regenerate session ID every five minutes
if($_SESSION['ctip']['creationTime'] < time() - 300){
	session_regenerate_id(true);
	$_SESSION['ctip']['creationTime'] = time();
}

//User Login security
if(isset($_SESSION['user']) && $_SESSION['user']['session_active']){
	if($user['login_activation_time'] < time() - $config['security']['login']['userLoginDeactivationTime']){
		//The user's login has timed out. Deactivate and remove all data from $_SESSION['user']
		$_SESSION['pages']['login']['timeoutMessage'] = array('code' => 'B01', 'name' => $user['displayname']);
		$_SESSION['user']['session_active'] = false;
		$_SESSION['user']['expiredAt'] = time();
		unset($_SESSION['user']['email']);
		unset($_SESSION['user']['displayname']);
		unset($_SESSION['user']['rank']);
	}
}else{
	$_SESSION['user'] = array('session_active' => false);
}


function cleanse($string){
	global $purifier;
	return $purifier->purify($string);
}

function getConn(){
  global $config;
  try {
    $conn = new PDO ('mysql:dbname='.$config['db']['dbname'].';host='.$config['db']['ip'].';port='.$config['db']['port'], $config['db']['username'], $config['db']['password'], array(PDO::ATTR_PERSISTENT => TRUE));
    $conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$conn->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
		$conn->exec ( "SET NAMES utf8" );
		return $conn;
  } catch (PDOException $e){
    die($e);
  }
}

function generateFatalError($title, $description, $extra, $scriptName) {
	global $config;
	echo "A fatal " . $title . " error has occured in " . $scriptName;
	echo "<hr>";
	echo "AUTO-GENERATED CRASH REPORT - TIMESTAMP: " . date_format ( create_date (), 'Y-m-d H:i:s' );
	echo "CRASH HEADER: " . $title;
	echo "CRASH DESCRIPTION: " . $description;
	echo "DIAGNOSTIC INFORMATION: " . $extra;
	echo "This crash occured in " . $scriptName;
	echo "<hr>";
	echo "Please copy and paste this page into an email to " . $config['general']['supportEmail'];
}

function createInputField($faClass, $inputType, $placeholder, $id){
	return '<span class="input-group-addon" id="basic-addon1"><i class="'.$faClass.'" aria-hidden="true"></i></span> <input type="'.$inputType.'" class="form-control" placeholder="'.$placeholder.'" id="'.$id.'" name="'.$id.'" required autofocus>';
}

function createInputFieldWithValue($faClass, $inputType, $placeholder, $value, $id){
	return '<span class="input-group-addon" id="basic-addon1"><i class="'.$faClass.'" aria-hidden="true"></i></span> <input type="'.$inputType.'" class="form-control" placeholder="'.$placeholder.'" id="'.$id.'" name="'.$id.'" required autofocus>';
}

//These functinos exist to have standardized validation.
function validEmail($email){
	if(!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match('/\s/',$email)){
		return false;
	}else{
		return true;
	}
}
?>
