<?php 
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	include 'dbconnection.php';
	if(isset($_SESSION['replyto'])){
		$replyto = $_SESSION['replyto'];
		$_SESSION['replyto'] = 0;
	}else{
		$replyto = 0;
	}
	$uid = $_POST['uid'];
	$query = "SELECT * FROM accts WHERE id=$uid";
	$result = $conn->query($query);
	$user = $result->fetch_assoc();
	$uname = $user['user'];
	$content = mysqli_escape_string($conn, $_POST['content']);
	$imgpath = "";
	if($_FILES){
		$img = $_FILES['file']['tmp_name'];
		$target = "uplimg/".$user['user'];
		if(!file_exists($target)){
			mkdir($target);
		}
		$imgpath = $target."/".$_FILES['file']['name'];
		move_uploaded_file($img, $target."/".$_FILES['file']['name']);

	}

	$query = "INSERT INTO posts (user, date, content, attachment, replyto) VALUES(".
			 "'$uname', NOW(), '$content', '$imgpath', $replyto)";
	$conn->query($query);
	if($replyto != 0){
		$query = "UPDATE posts SET comments = comments + 1 WHERE id = $replyto";
		$conn->query($query);
		$query = "SELECT user FROM posts WHERE id=$replyto";
		$result = $conn->query($query);
		$poster = $result->fetch_assoc();
		$poster_name = $poster['user'];
		$query = "SELECT id FROM accts WHERE user = '$poster_name'";
		$result = $conn->query($query);
		$poster = $result->fetch_assoc();
		$poster_id = $poster['id'];
		$query = "INSERT INTO replies (user_id, post_id, poster_id) VALUES ($uid, $replyto, $poster_id)";
		$conn->query($query);
	}
?>