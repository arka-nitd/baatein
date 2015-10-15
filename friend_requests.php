<?php  include ("inc/header.inc.php") ?>
<?php

$user_from ='';
$friend_requests = mysql_query("SELECT * FROM friend_requests WHERE user_to = '$username'");
$nooffriends = mysql_num_rows($friend_requests);

if($nooffriends == 0) {
	echo "You don't have any friend request at this moment";
}
else {
	while ($getrows = mysql_fetch_assoc($friend_requests)) {
		$user_from = $getrows['user_from'];
		echo ''.$user_from.' sent you a friend request.
		<form action="friend_requests.php" method="POST">
		<input type="submit" name="acceptrequest'.$user_from.'" value="Accept Request" class="submitbutton">
		<input type="submit" name="ignorerequest'.$user_from.'" value="Ignore Request" class="submitbutton">
		</form>
		<br><br>';

		if (isset($_POST['acceptrequest'.$user_from])) {
			// select friend array from logged in user
			// select same from person who sent request
			// if the user has no friends we just concat the friends username
			$user_friends = mysql_query("SELECT friend_array FROM users where username='$username'");
			$get_friend_row = mysql_fetch_assoc($user_friends);
			$user_friend_array = $get_friend_row['friend_array'];
			$user_friend_elements = explode(",", $user_friend_array);
			$user_friend_count = count($user_friend_elements);

			$sender_friends = mysql_query("SELECT friend_array FROM users where username='$user_from'");
			$get_sender_friend_row = mysql_fetch_assoc($sender_friends);
			$sender_friend_array = $get_sender_friend_row['friend_array'];
			$sender_friend_elements = explode(",", $sender_friend_array);
			$sender_friend_count = count($sender_friend_elements);

			if ($user_friend_array == ''){
				$user_friend_count = count(NULL);
			}
			if ($sender_friend_array == ''){
				$sender_friend_count = count(NULL);
			}

			if($user_friend_count == NULL){
				$user_query = mysql_query("UPDATE users SET friend_array = concat(friend_array, '$user_from') WHERE username = '$username'");
			}
			else if($user_friend_count >= 1){
				$user_query = mysql_query("UPDATE users SET friend_array = concat(friend_array, ',$user_from') WHERE username = '$username'");
			}

			if($sender_friend_count == NULL){
				$sender_query = mysql_query("UPDATE users SET friend_array = concat(friend_array, '$username') WHERE username = '$user_from'");
			}
			else if($sender_friend_count >= 1){
				$sender_query = mysql_query("UPDATE users SET friend_array = concat(friend_array, ',$username') WHERE username = '$user_from'");
			}	
			$delete_request = mysql_query("DELETE FROM friend_requests WHERE user_to='$username'&&user_from='$user_from'");
			header("location: friend_requests.php");
		
		}
		if (isset($_POST['ignorerequest'.$user_from])) {
			$ignore_request = mysql_query("DELETE FROM friend_requests WHERE user_to='$username'&&user_from='$user_from'");
			header("location: friend_requests.php");
		}

	}
}
?>
