<?php 
//sleep(1);
session_start();
require_once('json_headers.php');
require_once('dbaccess.php');


$userid=$_SESSION["id"];
if(!$userid)die();
require_once('classes/crud.class.php');

$modules=array();

$userData=db()->getRow("SELECT * FROM users WHERE id=?i",$userid);


if(!array_key_exists("command",$_REQUEST)||!array_key_exists("method",$_REQUEST)){
	die(json_encode(array("error"=>1,"code"=>"INVALID_REQUEST")));

}

$command=$_REQUEST["command"];
$method=$_REQUEST["method"];

if($command&&$method){
	switch($command){
		case "projects": 
			//your action group
			require_once('classes/projects.php');
			$active_module=new PROJECTS();
			break;
	}

	if(isset($active_module)){
		echo json_encode($active_module->$method($_POST), JSON_NUMERIC_CHECK);
	} else {
		die(json_encode(array("error"=>1,"code"=>"INVALID_REQUEST")));
	}
} else {
	die(json_encode(array("error"=>1,"code"=>"INVALID_REQUEST")));
}
?>