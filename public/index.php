<?php
ini_set ( 'display_errors', '1' );
error_reporting ( E_ALL | E_STRICT );
require '../include/init.php';

function render($page, $pageTitle, $context = array(), $styles = array(), $scripts = array(), $headerselect) {
	global $config, $lang;
	$path = '../templates/' . $page;
	$context ['headerSelect'] = $headerselect;
	$context ['config'] = $config;
	extract ( $context );
	require '../templates/layout.phtml';
}

$path = array_key_exists ( "PATH_INFO", $_SERVER ) ? $_SERVER ["PATH_INFO"] : "/index";
$path = preg_replace ( "/[^a-z0-9_\\/]+/i", "", $path );
$components = array_slice ( explode ( "/", $path ), 1 );

if (empty ( $components [0] )) {
	require "../pages/index.php";
	exit ();
}

$page = "../pages/" . implode ( "_", $components ) . ".php";

if (! file_exists ( $page )) {
	//header ( 'Location: /error/404' );
	echo $page." not found";
	exit ();
}

require $page;
?>
