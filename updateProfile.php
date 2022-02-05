<?php
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}
	$user = $_SESSION['user'];
	$iconFilePath = "";
	$bannerFilePath = "";
	include 'dbconnection.php';
	if(isset($_FILES['banner'])){
		$target = "uplimg/$user";
		if(!file_exists($target)){
			mkdir($target);
		}
		$banner = $_FILES['banner']['name'];
		$bannerFilePath = $target."/$banner";
		move_uploaded_file($_FILES['banner']['tmp_name'], $bannerFilePath);
		$query = "UPDATE accts SET banner = '$bannerFilePath' WHERE user = '$user'";
		$conn->query($query);
	}
	if(isset($_FILES['icon'])){
		$target = "uplimg/$user";
		if(!file_exists($target)){
			mkdir($target);
		}
		$icon = $_FILES['icon']['name'];
		$iconFilePath = $target."/$icon";
		move_uploaded_file($_FILES['icon']['tmp_name'], $iconFilePath);
		$query = "UPDATE accts SET icon = '$iconFilePath' WHERE user = '$user'";
		$conn->query($query);
	}
	$handle = $_POST['name'];
	$bio = $_POST['bio'];
	$bday = $_POST['bday'];
	$query = "UPDATE accts SET handle = '$handle', bio = '$bio', bday = '$bday' WHERE user='$user'";
	$conn->query($query);
?>