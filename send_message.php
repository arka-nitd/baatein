<?php include ("inc/header.inc.php"); ?>
<?php
if(!$username) {
	echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/website/index.php\">";
	exit();
}
	$current_username = mysql_real_escape_string($_GET['u']);
	if (isset($_POST['sendmsg'])) {
			$msgtitle = $_POST['msgtitle'];
			$msgbody = $_POST['msgbody'];
			$current_username = mysql_real_escape_string($_GET['u']);
			$d = date("Y-m-d");
			$query = mysql_query("INSERT INTO pvt_messages VALUES('', '$username', '$current_username', '$msgtitle', '$msgbody', '$d', 'no' )");
			echo "successful";
	}

?>		<h2>Compose Message</h2>
		<div class="postform">
		<form action='send_message.php?u=<?php echo $current_username ?>' method='POST'>
			<input type="text" class="post" name="msgtitle" size="50" placeholder="Message Title"><br>
			<textarea rows='10' class="post" cols='70' name='msgbody' placeholder='Type Your Message'></textarea>
			<input type='submit' name='sendmsg' value='Send Message'>
		</div>
		</form>
