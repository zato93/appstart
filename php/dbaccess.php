<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$mysqli=new mysqli("127.0.0.1","usr","pwd","db");
mysqli_query($mysqli,"SET NAMES 'utf8mb4'");
include_once(__DIR__."/classes/safemysql.class.php");
$db=new SafeMySQL(array(
	'mysqli'=>$mysqli
));

function db(){
	global $db;
	return $db;
}
?>