<?php include ("./inc/header.inc.php"); ?>
<?php
	$reg= @$_POST['reg'];
	//variables to prevent errors
	$fn = "";	//firstname
	$ln = "";	//lastname
	$un = "";	//username
	$em = "";	//email
	$pswd = "";	//password
	$pswd2 = "";//password2
	$d = "";	//date
	$u_check = "";	//check if username exists
	//registration form
	$fn = strip_tags(@$_POST['fname']);
	$ln = strip_tags(@$_POST['lname']);
	$un = strip_tags(@$_POST['username']);
	$em = strip_tags(@$_POST['email']);
	$pswd = strip_tags(@$_POST['password']);
	$pswd2 = strip_tags(@$_POST['password2']);
	$d = date("Y-m-d"); //year-month-day

	if($reg){
		//check if email already exists
		$e_check = mysql_query("SELECT email FROM users WHERE email='$em'");
		//count the amount of rows where email = $em
		$email_check = mysql_num_rows($e_check);
		if($email_check == 0){
			$u_check = mysql_query("SELECT username FROM users WHERE username='$un'");
			//count the amount of rows where username = $un
			$check = mysql_num_rows($u_check);
			if($check == 0){
				//check if all fields are filled in
				if($fn&&$ln&&$un&&$em&&$pswd&&$pswd2){
					if($pswd==$pswd2){
						if(strlen($un)>25||strlen($fn)>25||strlen($ln)>25){
							echo "The maximum limit for username/first name/last name is 25 chars";
						}
						else if(strlen($pswd)<5||strlen($pswd)>30){
							echo "The password must be between 5 to 30 characters";
						}
						else{
							$pswd = md5($pswd);
							$pswd2= md5($pswd2);
							$query = mysql_query("INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$pswd','$d','0','','','')");
							die("<h2>Welcome to Baatein</h2>Login to your account to get started.. <a href='index.php'>LOGIN</a>");
							//header("location: index.php");
						}
					}
					else
						echo "The Password doesn't match.Pls enter again";
				}
				else
					echo "One or More field is empty. Pls fill it up completely";
			}
			else
				echo "The username you entered already exists. Pls type a different user name";
		}
		else {
			echo "The email address is already registered !!";
		}
	}

	//User Login Code

	if(isset($_POST["user_login"])&&isset($_POST["password_login"])){
		$user_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["user_login"]);
		$password_login = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password_login"]);
		$password_login_md5 = md5($password_login);
		$sql =mysql_query("SELECT id FROM users WHERE username='$user_login' AND password='$password_login_md5' LIMIT 1");
		//check for their existense
		$userCount = mysql_num_rows($sql);
		if($userCount==1){
			while($row == mysql_fetch_array($sql)){
				$id=$row["id"];
			}
			$member= mysql_fetch_assoc($sql);
			$_SESSION["user_login"]=$user_login;
			$_SESSION["fname"]=$member['firstname'];
			header("location: home.php");
			exit();
		}
		else{
			echo "That information is incorrect, try again";
			exit();
		}
	}
?>
		<div style="width: 800px; height: auto; margin: 0px auto 0px auto;">
		<table id="indexbox">
			<tr>
				<td width="55%" valign="top" id="signin">
					<h2>Already a Member !! Sign in below !</h2>
					<form action="index.php" method="POST" class="mform">
						<input type="text" name="user_login" size="25" placeholder="Username"><br /> <br />
						<input type="password" name="password_login" size="25" placeholder="Password"><br /> <br />
						<input type="submit" name="login" value="Login" class="submitbutton">
					</form>
				</td>
				<td width="13%" valign="top" id="divider">
					<h1>OR</h1>
				</td>
				<td width="35%" valign="top" id="signup">
					<h2>Sign Up Below</h2>
					<form action="index.php" method="POST" class="mform">
						<input type="text" name="fname" size="25" placeholder="First Name"><br /> <br />
						<input type="text" name="lname" size="25" placeholder="Last Name"><br /> <br />
						<input type="text" name="username" size="25" placeholder="User Name"><br /> <br />
						<input type="text" name="email" size="25" placeholder="Email Address"><br /> <br />
						<input type="password" name="password" size="25" placeholder="Password "><br /> <br />
						<input type="password" name="password2" size="25" placeholder="Confirm Password"><br /> <br />
						<input type="submit" name="reg" value="Sign Up !" class="submitbutton">
					</form>
				</td>
			</tr>
		</table>
<?php include("./inc/footer.inc.php"); ?>