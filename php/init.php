<?php
session_start();
header('Content-Type: application/javascript');
include('dbaccess.php');
if(!$_SESSION["id"])die();
$userid=$_SESSION["id"];

$App=array(
	"list"=>db()->getAll("SELECT * FROM db WHERE owner=?i",$userid)
);

echo "App=".json_encode($App,JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE ).';';
?>