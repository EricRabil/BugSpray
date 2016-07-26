<?php
require_once '../include/init.php';
require_once '../include/settings.php';
function render($page, $title, $context = array(), $styles = array(), $scripts = array()) {
	extract ( $context );
	require_once '../templates/layout.phtml';
}
if ($settings ["showErrors"]) {
	ini_set ( 'display_errors', '0' );
	error_reporting ( E_ALL | E_STRICT );
}
$path = array_key_exists ( "PATH_INFO", $_SERVER ) ? $_SERVER ["PATH_INFO"] : "/index";
$path = preg_replace ( "/[^a-z0-9_\\/]+/i", "", $path );
$components = array_slice ( explode ( "/", $path ), 1 );
$errCode = false;
if ($settings ["runSetup"] && strpos ($components[0], "setup" !== false)) {
	require_once '../pages/setup.php';
}
if ($settings ["maintenance"]) {
	require_once $settings ["maintenancedir"];
} else {
	if ($components [0] == "error" || (strpos ( $components [0], "error" ) !== false)) {
		$errCode = $components [1];
		
		require_once "../pages/index.php";
		exit ();
	}
	$uri = explode ( ".", $_SERVER ['HTTP_HOST'] );
	if (array_shift ( $uri ) == "m") {
		$settings ["mobile"] = true;
		$_SESSION ["mobile"] = true;
	} else {
		$settings ["mobile"] = false;
		$_SESSION ["mobile"] = false;
	}
	if ($components [0] == "code" || (strpos ( $components [0], "code" ) !== false)) {
		$errCode = $components [1];
		require_once "../pages/index.php";
		exit ();
	}
	$page = "../pages/" . implode ( "_", $components ) . ".php";
	if (! file_exists ( $page )) {
		header ( 'Location: /error/404' );
		exit ();
	}
	
	require_once $page;
}
