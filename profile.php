<?php include ("inc/header.inc.php"); ?>
<?php
if(!$username) {
	echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/website/index.php\">";
	exit();
}



if (isset($_GET['u'])) {
	$current_username = mysql_real_escape_string($_GET['u']);
	if (ctype_alnum($current_username)) {
		//check if user exists
		$check = mysql_query("SELECT * FROM users WHERE username= '$current_username'");
		if (mysql_num_rows($check)==1) {
			$get = mysql_fetch_assoc($check);
			$current_username = $get['username'];
			$firstname = $get['firstname'];
			$lastname = $get['lastname'];
			$bio = $get['bio'];
			$userpic = $get['profile_pic'];
			if(!$userpic)
				$userpic = 'img/default.jpg';
			else
				$userpic = 'userdata/profilepics/'.$userpic;
		}
		else {
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/website/$username\">";
			exit();
		}
	}
}
if(isset($_POST['post'])) {
	$post = $_POST['post_area'];
	$date_added = date("Y-m-d");
	$added_by = $username;
	$user_posted_to = $current_username;
	$sqlCommand = "INSERT INTO posts VALUES('', '$post', '$date_added', '$added_by', '$user_posted_to')";
	$query = mysql_query($sqlCommand) or die(mysql_error());
}

$result ='';

if (isset($_POST['addfriend']))
{
	$friend_request = $_POST['addfriend'];
	$user_to = $current_username;
	$user_from = $username;
	$create_request = "INSERT INTO friend_requests VALUES('', '$user_from', '$user_to')";
	$friend_query = mysql_query($create_request) or die(mysql_error());
	$result = "Your friend request has been sent <br>";
	
}

if (isset($_POST['removefriend'])){

	$user_query = mysql_query("SELECT friend_array FROM users WHERE username='$username'");
	$get_user_friend = mysql_fetch_assoc($user_query);
	$friend_array_user = $get_user_friend['friend_array'];

	$user_friend_query = mysql_query("SELECT friend_array FROM users WHERE username='$current_username'");
	$get_friend_of_user = mysql_fetch_assoc($user_friend_query);
	$friend_array_of_user = $get_friend_of_user['friend_array'];

	$username1 = ','.$username;
	$username2 = $username.',';

	$current_username1 = ','.$current_username;
	$current_username2 = $current_username.',';


	if (strstr($friend_array_user, $current_username1)){
		$friend_array_user = str_replace($current_username1, "", $friend_array_user);
	}
	elseif (strstr($friend_array_user, $current_username2)) {
		$friend_array_user = str_replace($current_username2, "", $friend_array_user);
	}
	elseif (strstr($friend_array_user, $current_username)) {
		$friend_array_user = str_replace($current_username, "", $friend_array_user);
	}

	if (strstr($friend_array_of_user, $username1)){
		$friend_array_of_user = str_replace($username1, "", $friend_array_of_user);
	}
	elseif (strstr($friend_array_of_user, $username2)) {
		$friend_array_of_user = str_replace($username2, "", $friend_array_of_user);
	}
	elseif (strstr($friend_array_of_user, $username)) {
		$friend_array_of_user = str_replace($username, "", $friend_array_of_user);
	}

	$remove_query1 = mysql_query("UPDATE users SET friend_array='$friend_array_user' WHERE username='$username'");
	$remove_query2 = mysql_query("UPDATE users SET friend_array='$friend_array_of_user' WHERE username='$current_username'");

	header("Location: $current_username");
}

if (isset($_POST['sendmsg'])){
	header("Location: send_message.php?u=$current_username");
}

?>
<div class="postForm">
 	<form action="<?php echo $current_username ?>" method="POST">
		<textarea class="post" name="post_area" rows="4" cols="75"></textarea>
		<input type="submit" name="post" value="Post" class="submitbutton" id="profilepostsubmit">
	</form>
</div>
<div class="profilePosts">
	<?php
	$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$current_username' ORDER BY id DESC LIMIT 10") or die(mysql_error());
	while($row = mysql_fetch_assoc($getposts)) {
		$id = $row['id'];
		$body = $row['body'];
		$date_added = $row['date_added'];
		$added_by = $row['added_by'];
		$user_posted_to = $row['user_posted_to'];
		echo "
				<div class='posted_by'>
					<a href='$added_by' class='postadder'>$added_by</a> 
					: $date_added :- 
				</div>
				<div class='postcontent'>
				<br>" 
				.nl2br($body).
				"<br><br>
				</div>
				<hr>
			";
	}
	?>
</div>
<div id ="profleftnav">
<div class="textHeader"><?php echo $firstname; ?>'s Profile</div>
<div class="polaroid">
<img id="profilePicture" src="<?php echo $userpic ?>" alt="<?php echo "$firstname" ?>'s Profile" title="<?php echo $username ?>'s Profile"/>
<p><?php echo "$firstname"." $lastname"; ?></p>
</div>
	<?php 
		$friend_array ='';
		$friend_array_explode= array();
		$count_friends = '';
		$friend_array12= '';
		$friend_query = mysql_query("SELECT friend_array FROM users WHERE username='$current_username'");
		$get_friends = mysql_fetch_assoc($friend_query);
		$friend_array = $get_friends['friend_array'];

		if ($friend_array !=''){
			$friend_array_explode = explode(",", $friend_array);
			$count_friends = count($friend_array_explode);
			$friend_array12 = array_slice($friend_array_explode, 0, 8);
		}
		if( $username != $current_username ) {
			?>
			<form action="<?php echo $current_username ?>" method="post">
			<?php
			if(in_array($username, $friend_array_explode)){
				$addasfriend = '<div id=pbox><input type="submit" name="removefriend" value="Remove" class="button1">';
			}
			else {
				$addasfriend = '<div id=pbox><input type="submit" name="addfriend" value="Add" class="button1">';
			}
			echo $addasfriend;
			?>
			<input type="submit" name="sendmsg" value="Send Message" class="button1">
			</div>
			</form>
			<br>
		<?php
		}
		else {
			echo '<div id="pbox" ><a href="mymessage.php" class="button1">My Messages</a></div>';
		}
		?>


<div class="textHeader"><?php echo $firstname; ?>'s Status</div>
<div class="profileLeftSideContent">
<div id="biobox">
<?php
echo $bio;
?>
</div>
</div>
<div class="textHeader"><?php echo $firstname; ?>'s Friends</div>
<div class="profileLeftSideContent">
<?php
	echo '<div id="profilefriends">';
	if ($count_friends!=0){
		foreach ($friend_array12 as $key => $value) {
			# code...
			$picquery = mysql_query("SELECT * FROM users WHERE username='$value'");
			$getpic = mysql_fetch_assoc($picquery);
			$friendname = $getpic['username'];
			$firstname = $getpic['firstname'];
			$profpic = $getpic['profile_pic'];
			if( $profpic == '') {
				echo "<a href='$friendname' title='$firstname'><img src='img/default.jpg' class='profimage' /></a>";
			}
			else {
				echo "<a href='$friendname' title='$firstname'><img src='userdata/profilepics/$profpic' class='profimage' /></a>";
			}
		}
	}
	else {
		echo "<div id='nofriends'>You don't have any friends yet.</div>";
	}
	echo '</div>';
?>
</div>
</div>
</div>
<?php include("./inc/footer.inc.php"); ?>