<!doctype HTML>
<html>
<head>
<title>Hello</title>
</head>
<body>

<?php

{
	if(isset($_FILES['abc'])) {
		echo "COOL";
	}
	
}
?>
<h2>Edit your Account Settings Below</h2>
<form action="" method="POST" enctype="multipart/form-data">
		<legend>CHANGE YOUR PROFILE PICTURE</legend>
		<img src="img/default.jpg" width="150" height="175" alt="Profile Picture">
		<input type="file" name="abc">
		<input type="submit">
</form>
</body>
</html>