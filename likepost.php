<?php 
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}
	function likePost($id, $uid, $poster){
		include 'dbconnection.php';
		$query = "UPDATE posts SET likes = likes + 1 WHERE id='$id'";
		$conn->query($query);
		$query = "INSERT INTO likes (user_id, post_id, poster_id) VALUES ($uid, $id, $poster)";
		$conn->query($query);
		echo 1;
	}

	function unlikePost($id, $uid, $poster){
		include 'dbconnection.php';
		$query = "UPDATE posts SET likes = likes - 1 WHERE id='$id'";
		$conn->query($query);
		$query = "DELETE FROM likes WHERE user_id=$uid AND post_id=$id";
		$conn->query($query);
		echo -1;
	}

	function isLikedBy($id, $uid){
		include 'dbconnection.php';
		$query = "SELECT * FROM accts AS a INNER JOIN likes ON a.id=user_id INNER JOIN posts AS p ON ".
				 "p.id=post_id WHERE a.id=$uid AND p.id=$id";
		$result = $conn->query($query);
		if($row = $result->fetch_assoc()){
			return true;
		}
		return false;
	}

	if(isset($_POST['postid'])){
		$postid = $_POST['postid'];
		unset($_POST['postid']);
		$postmaker = $_POST['postmaker'];
		unset($_POST['postmaker']);

		if(!isLikedBy($postid, $_SESSION['uid'])){
			likePost($postid, $_SESSION['uid'], $postmaker);
		}else{
			unlikePost($postid, $_SESSION['uid'], $postmaker);
		}
	}
?>