<?php
// error_reporting(E_ALL | E_STRICT);
// ini_set("display_errors", "1");
session_start ();
header ( 'Content-type: text/html; charset=utf8' );

$paypalEndpoint = "api.paypal.com";
$paypalClientId = "AVkPX5Wdm-i3rYZ6gCU3siZrpNPaaQXSrV2j80MfgDPV-kDo1HOAJ7cfZgrKmPHZbwCk_19XCJLRvASj";
$paypalSecret = "EOGj5eAgnWoUGKDCJ_FGpkGsh2RqzeXfFTu1_bET7mmaXtUw5w_gpFse2VMYB_kYobu-7LFCPdS1jPmC";

$enableMysql = false;
$dsn = 'mysql:dbname=database;host=host;port=port';
$user = 'user';
$password = 'password';
if ($enableMysql) {
	try {
		$conn = new PDO ( $dsn, $user, $password );
		$conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$conn->setAttribute ( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
		
		$conn->exec ( "SET NAMES utf8" );
	} catch ( PDOException $e ) {
		echo 'Connection failed: ' . $e->getMessage ();
	}
}
require_once ("settings.php");