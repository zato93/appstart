<?php
session_start();
if(isset($_SESSION["id"])&&$_SESSION["id"]!=0){
	header("Location: ../");
}
$login_fail=false;
include("../php/dbaccess.php");
if(isset($_POST["email"])&&isset($_POST["password"])){
	$found = db()->getRow("SELECT id,password FROM users WHERE email=?s",$_POST["email"]);
	if($found && isset($found["password"]) && isset($found["id"])){
		if(password_verify($_POST["password"], $found["password"])){
			header("Location: ../");
		}
	}
} 

if (isset($_POST["email"])){
	$login_fail=true;
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
					<input type="password" class="form-control" password="password" placeholder="Enter password" value=""/>
				</div>
			</div>
			<div class="panel-footer">
				<input type="submit" class="btn btn-primary" value="Signin">
			</div>
		</form>
		<?php
			if($login_fail){
				echo '<div class="alert alert-danger" role="alert">Wrong email or password</div>';
			}
		?>
	</div>
	<div class="col-sm-3"></div>
</body>
</html>