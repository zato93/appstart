<?php
session_start();
if(!isset($_SESSION["id"])){
	header("Location: signin");
}
?>
<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="UTF-8">
	<title>New App</title>
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css">
	<script src="php/init.php"></script>
</head>
<body>
	<div class="container" ng-controller="MainCtrl">
		<p>Our app</p>
	</div>
</body>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/angular/angular.min.js"></script>
	<script src="bower_components/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="bower_components/sweetalert/dist/sweetalert.css">
</html>