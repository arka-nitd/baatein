<?php include ("inc/header.inc.php"); ?>
<?php
if(!$username) {
	echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/website/index.php\">";
	exit();
}
?>

<h2>My Unread Messages:</h2><p />

<?php

$msgquery1 = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$username' && opened='no'");
$noofrows1 = mysql_num_rows($msgquery1);


if ($noofrows1 != 0) {
	while ( $get_msg = mysql_fetch_assoc($msgquery1) ) {
		$id = $get_msg['id']; 
	    $user_from = $get_msg['user_from'];
	    $user_to = $get_msg['user_to'];
	    $msg_title = $get_msg['msg_title'];
        $msg_body = $get_msg['msg_body'];
	    $date = $get_msg['date'];
        $opened = $get_msg['opened'];

	    if (strlen($msg_title) > 50) {
 	 	   $msg_title = substr($msg_title, 0, 50)." ...";
	    }
	    else
		   $msg_title = $msg_title;
	      
	    if (strlen($msg_body) > 150) {
	       $msg_body = substr($msg_body, 0, 150)." ...";
	    }
	    else
	    $msg_body = $msg_body;

		?>

		<script type="text/javascript">
		function toggle<?php echo $id; ?>(){
			var x = document.getElementById("toggletext<?php echo $id; ?>");
			if(x.style.display == "none")
				x.style.display = "block";
			else
				x.style.display = "none";

		}
		</script>

		<?php

		if (isset($_POST['setopen'.$id.''])) {
			$set_query = mysql_query("UPDATE pvt_messages SET opened='yes' WHERE id='$id'");
			header("location: mymessage.php");

		}

		echo "
		<form action='mymessage.php' method='POST'>
      	<b><a href='$user_from'>$user_from</a></b>
		<input type='button' name='openmsg' value='$msg_title' onclick='javascript:toggle$id()'>
		<input type='submit' name='setopen$id' value='Mark as read'>
		</form>
		<div id='toggletext$id' style='display:none;'>
		<br><div id='biobox' >$msg_body</div><br>
		</div>
		<hr><br>
		";
	

	}
}
else {
	echo "<br>You have no unread messages right now !<br>";
}
?>
<h2>My Read Messages:</h2><p />

<?php

$grabmsg = mysql_query("SELECT * FROM pvt_messages WHERE user_to='$username' && opened='yes'");
$noofrows2 = mysql_num_rows($grabmsg);

if ($noofrows2 != 0) {
	while ( $get_msg2 = mysql_fetch_assoc($grabmsg) ) {
		$id = $get_msg2['id']; 
	    $user_from = $get_msg2['user_from'];
	    $user_to = $get_msg2['user_to'];
	    $msg_title = $get_msg2['msg_title'];
        $msg_body = $get_msg2['msg_body'];
	    $date = $get_msg2['date'];
        $opened = $get_msg2['opened'];

	    if (strlen($msg_title) > 50) {
 	 	   $msg_title = substr($msg_title, 0, 50)." ...";
	    }
	    else
		   $msg_title = $msg_title;
	      
	    if (strlen($msg_body) > 150) {
	       $msg_body = substr($msg_body, 0, 150)." ...";
	    }
	    else
	    $msg_body = $msg_body;
		?>
		<script type="text/javascript">
		function toggle<?php echo $id; ?>(){
			var x = document.getElementById("toggletext<?php echo $id; ?>");
			if(x.style.display == "none")
				x.style.display = "block";
			else
				x.style.display = "none";

		}
		</script>
		<?php
		if (isset($_POST['delete'.$id.''])) {
			$del_query = mysql_query("DELETE FROM pvt_messages WHERE id='$id'");
			header("location: mymessage.php");
		}
		
		if (isset($_POST['reply'.$id.''])) {
			echo "<meta http-equiv=\"refresh\" content=\"0; url=msg_reply.php?u=$user_from\">";
		}

		echo "
		<form action='mymessage.php' method='POST'>
	    <b><a href='$user_from'>$user_from</a></b>
		<input type='button' name='openmsg' value='$msg_title' onclick='javascript:toggle$id()'>
		<input type='submit' name='delete$id' value='X'>
		<input type='submit' name='reply$id' value='Reply'>
		</form>
		<div id='toggletext$id' style='display:none;'>
		<br>$msg_body<br>
		</div>
		<hr><br>
		";
	

	}
}
else {
	echo "<br>You haven't read any messages till now !<br>";
}

?>
