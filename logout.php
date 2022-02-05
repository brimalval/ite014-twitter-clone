<?php
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}
	session_destroy();
	session_start();
	echo "<script>window.location = 'login.php';</script>";
?>