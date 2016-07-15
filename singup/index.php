<?php
session_start();
if(isset($_SESSION["id"])&&$_SESSION["id"]!=0){
	header("Location: ../");
}


include("../php/dbaccess.php");
if(isset($_POST["email"])&&isset($_POST["password"])){
	echo 1;
	$password_hash=password_hash($_POST["password"],PASSWORD_DEFAULT);

	$result=db()->query("INSERT INTO users SET email=?s,password=?s",$_POST["email"], $password_hash);
	$userid=db()->insertId();
	if($result&&$userid){
		$_SESSION["id"]=$userid;
		header("Location: ../");
	}
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign in</title>
	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap-theme.min.css">

</head>
<body>
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<br>
		<br>
		<form class="panel panel-default" action="./" method="post">
			<div class="panel-body">
				<div class="form-group">
					<label>Email</label>
					<input type="text" class="form-control" name="email" placeholder="Enter email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"/>
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password" placeholder="Enter password" value=""/>
				</div>
			</div>
			<div class="panel-footer">
				<input type="submit" class="btn btn-primary" value="Register">
			</div>
		</form>
	</div>
	<div class="col-sm-3"></div>
</body>
</html>