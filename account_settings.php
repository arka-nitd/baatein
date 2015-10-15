<?php include ("inc/header.inc.php");

if($username) {
}
else {
	die ("You must be logged in to view this page !!");
}

$senddata = @$_POST['senddata'];
if ($senddata) {
	//if the form is submitted properly
	$password_query = mysql_query("SELECT * FROM users WHERE username='$username'");
	$oldpassword = strip_tags(@$_POST['oldpassword']);
	$newpassword = strip_tags(@$_POST['newpassword']);
	$newpassword2 = strip_tags(@$_POST['newpassword2']);
	$oldpassword_md5 = md5($oldpassword);

	$members = mysql_fetch_assoc($password_query);
	$db_password = $members['password'];

	if ($oldpassword_md5 == $db_password) {
		if ($newpassword == $newpassword2) {
			if(strlen($newpassword) >=4) {
				$newpassword_md5 = md5($newpassword);
				$query = mysql_query("UPDATE users SET password='$newpassword_md5' WHERE username='$username'");
				
			}
			else {
				echo "Password Entered must be atleast 4 characters or more";
			}
		}
		else {
			echo "Entered New Passwords don't match. Please Re-Enter !!";
		}
	}
	else {
		echo "Entered Old Password is incorrect !!";
	}
}
$query = mysql_query("SELECT firstname, lastname, bio FROM users WHERE username='$username'");
$getrow = mysql_fetch_assoc($query);
$db_fname = $getrow['firstname'];
$db_lname = $getrow['lastname'];
$db_bio = $getrow['bio'];

$updateprofile = @$_POST['updateprofile'];

if($updateprofile) {
	$fname = @$_POST['fname'];
	$lname = @$_POST['lname'];
	$bio = @$_POST['aboutu'];

	if( (strlen($fname) >= 0)&&(strlen($lname) >=0) ) {
		$query = mysql_query("UPDATE users SET firstname='$fname', lastname='$lname', bio='$bio' WHERE username='$username'");
		
	}
	else {
		echo "Entered Names must not be blank !!";
	}

}
// checking if user previously uploaded any image
$profile_query = mysql_query("SELECT profile_pic FROM users WHERE username='$username'");
$get_pic_row = mysql_fetch_assoc($profile_query);
$pic_address = $get_pic_row['profile_pic'];
if($pic_address) {
	$userpic = 'userdata/profilepics/'.$pic_address;
}
else{
	$userpic = 'img/default.jpg';
}
// Changing profile pic
if(isset($_POST["uploadpic"])) {
	$image = $_FILES['profilepic'];
	if(!empty($image)) {
		$pictype = @$_FILES['profilepic']['type'];
		if((($pictype=='image/jpeg')||($pictype=='image/png')||($pictype=='image/gif'))&&(@$_FILES['profilepic']['size']<1048576)) {
			$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$foldername = substr(str_shuffle($characters), 0, 15);
			if($pic_address) {
					$foldername = substr($pic_address, 0, 15);
			}
			else{
			mkdir('userdata/profilepics/'.$foldername);	
			}
			//if the file exists
			if(file_exists('userdata/profilepics/$foldername'.@$_FILES['profilepic']['name'])) {
				echo @$_FILES['profilepic']['name']." Already Exists";
			}
			else {
				$profile_pic_name=@$_FILES['profilepic']['name'];
				move_uploaded_file($_FILES['profilepic']['tmp_name'], 'userdata/profilepics/'.$foldername.'/'.@$_FILES['profilepic']['name']);
				mysql_query("UPDATE users SET profile_pic = '$foldername/$profile_pic_name' WHERE username='$username'");
				$pquery = mysql_query("SELECT profile_pic FROM users WHERE username='$username'");
				$get_current_pic = mysql_fetch_assoc($pquery);
				$userpic = 'userdata/profilepics/'.$get_current_pic['profile_pic'];
				header("location: account_settings.php");			
			}
		}
		else {
		echo"The image must be gif/jpg/png and less than 1MB";
		}
	}
	else {
		echo "Please Select an image and click upload";
	}
}

?>
<h2>Edit your Account Settings Below</h2>
<div id="acwrapper">
<form action="account_settings.php" method="POST" class="acsettings" enctype="multipart/form-data">
	<fieldset class="mform acfset">
		<legend>CHANGE YOUR PROFILE PICTURE</legend>
		<img src="<?php echo $userpic ?>" width="150" height="175" alt="Profile Picture">
		<div id="profpic">
		<label for="inpfile">
		<input type="file" name="profilepic">
		</label>
		<input type="submit" class="submitbutton" name="uploadpic" value="Upload">
		</div>
	</fieldset>
</form>
<form action="account_settings.php" method="POST" class="acsettings" >
	<fieldset class="mform acfset">
		<legend>CHANGE YOUR PASSWORD</legend>
		<label for=:"oldpassword">Your Old Password :</label>
		<input type="password" name="oldpassword" id="oldpassword" class="acinput" size="30"><br/>

		<label for=:"newpassword">Your New Password :</label>
		<input type="password" name="newpassword" id="newpassword" class="acinput" size="30"><br/>

		<label for=:"newpassword2">Repeat Password :</label>
		<input type="password" name="newpassword2" id="newpassword2" class="acinput" size="30"><br/>
		<input type="submit" class="submitbutton" name="senddata" value="Update your Password">
	</fieldset>
	<fieldset class="mform acfset2">
		<legend>UPDATE YOUR PROFILE INFO</legend>
		<label for=:"fname">First Name :</label>
		<input type="text" name="fname" id="fname" class="acinput" size="30" value="<?php echo $db_fname ?>"><br/>
		<label for=:"lname">Last Name :</label>
		<input type="text" name="lname" id="lname" class="acinput" size="30" value="<?php echo $db_lname ?>"><br/>
		<label for=:"aboutu">About You :</label>
		<textarea name="aboutu" id="aboutu" class="post" rows="5" cols="60"><?php echo $db_bio ?></textarea><br/>
		<input type="submit" class="submitbutton" name="updateprofile" value="Update your Profile">
	</fieldset>
</form>
</div>

