<?php 
include("./inc/connect.inc.php");
session_start();
if(!isset($_SESSION["user_login"])){
	$username = '';
}
else{
	//header("location: home.php");
	$username = $_SESSION["user_login"];
	$firstname = $_SESSION["fname"];
}
?>
<!doctype html>
<html>
<head>
	<title>Baatein</title>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script type="text/javascript" src="js/main.js"></script>
	<link href="http://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="headerMenu">
		<div class="wrapper">
			<div class="logo">
				<img src="img/mainlogo.gif">
				<p>BAATEIN</p>
			</div>
				<form class="form-container" action="" method="GET">
					<input type="text" class="search-field" placeholder="Type search text here..." />
					<div class="submit-container">
						<input type="submit" value="" class="hsubmit" />
					</div>
				</form>
			<?php
			if(!$username) {
				echo '
				<nav id="menu">&nbsp;
				<a href="index.php">Home</a>&nbsp;
				<a href="index.php">About</a>&nbsp;
				<a href="index.php">Signup</a>&nbsp;
				<a href="index.php">Signin</a>&nbsp;
				</nav>
				';
			}
			else
			{
				echo '
				<nav id="menu">&nbsp;
				<a href="home.php">Home</a>&nbsp;
				<a href="'.$username.'">Profile</a>&nbsp;
				<a href="account_settings.php">Account Settings</a>&nbsp;
				<a href="logout.php">Logout</a>&nbsp;
				</nav>
				';
			}
			
			?>
		</div>
	</div>
	<div class=" bg2">



