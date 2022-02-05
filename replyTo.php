<?php  
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	$_SESSION['replyto'] = $_POST['postid'];
	echo "Currently replying to: ".$_SESSION['replyto'];
?>