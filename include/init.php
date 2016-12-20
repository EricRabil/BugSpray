<?php
session_start();
header('Content-type: text/html; charset=utf8');
require "settings.php";
require "UUID.php";
require "lib/htmlpurifier/HTMLPurifier.auto.php";
$pconfig = HTMLPurifier_Config::createDefault();
$pconfig->set('URI.MakeAbsolute', true); // make all URLs absolute using the base URL set above
$pconfig->set('AutoFormat.RemoveEmpty', true); // remove empty elements
$pconfig->set('HTML.Doctype', 'XHTML 1.0 Strict'); // valid XML output (?)
$pconfig->set('HTML.AllowedElements', array('p', 'div', 'a', 'br', 'table', 'thead', 'tbody', 'tr', 'th', 'td', 'ul', 'ol', 'li', 'b', 'i'));
$pconfig->set('HTML.AllowedAttributes', array('a.href')); // remove all attributes except a.href
$pconfig->set('CSS.AllowedProperties', array()); // remove all CSS
$purifier = new HTMLPurifier($pconfig);

function cleanse($string){
	global $purifier;
	return $purifier->purify($string);
}

function createConn(){
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
?>
