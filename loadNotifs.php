<?php  
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}

	include 'dbconnection.php';
	$curruser = $_SESSION['uid'];
	//FIRST COUNT IF THERE ARE ANY NEW REPLY NOTIFS
	$queryCountReplies = "SELECT COUNT(*) FROM posts AS p INNER JOIN replies ON p.id=post_id WHERE poster_id = $curruser AND seen = false";
	$result = $conn->query($queryCountReplies);
	$replyCount = $result->fetch_assoc()['COUNT(*)'];
	$notifsHTML = "";
	if($replyCount > 0){
		$queryReplies = "SELECT user, content, user_id, post_id FROM posts AS p INNER JOIN replies ON p.id=post_id WHERE poster_id = $curruser AND seen = false";
		$result = $conn->query($queryReplies);
		while($row = $result->fetch_assoc()){
			$commenter = $row['user_id'];
			$commentedPost = $row['post_id'];
			$user = $row['user'];
			$content = $row['content'];
			$query = "SELECT icon FROM accts WHERE user = '$user'";
			$requestUser = $conn->query($query);
			$requestIcon = $requestUser->fetch_assoc()['icon']; 
			$content = strlen($content) > 115 ? substr($content, 0, 115)."..." : $content;
			$notifsHTML .= "<div class='notifSample'>
					<img class='uicon' src='$requestIcon'>
					<div class='notifInfo'>
						<h3 id='notifUName'>$user</h3> <span id='notiftype'>commented on</span> your post: 
						<div class='notifpostBody'>
							&ldquo; <textarea disabled='disabled' class='notifpostText'>$content</textarea> &rdquo;
						</div>
					</div>
					<div class='notifsymbol'><i class='fa fa-comment'></i></div>
				</div>";
			$seenQuery = "UPDATE replies SET seen = true WHERE user_id = $commenter AND post_id = $commentedPost";
			$conn->query($seenQuery);
		}
	}

	$queryCountLikes = "SELECT COUNT(*) FROM posts AS p INNER JOIN likes ON p.id=post_id WHERE poster_id = $curruser AND seen = false";
	$result = $conn->query($queryCountLikes);
	$likeCount = $result->fetch_assoc()['COUNT(*)'];
	if($likeCount > 0){
		$queryLikes = "SELECT user, content, user_id, post_id FROM posts AS p INNER JOIN likes ON p.id=post_id WHERE poster_id = $curruser AND seen = false";
		$result = $conn->query($queryLikes);
		while($row = $result->fetch_assoc()){
			$liker = $row['user_id'];
			$likedPost = $row['post_id'];
			$user = $row['user'];
			$content = $row['content'];
			$query = "SELECT icon FROM accts WHERE user = '$user'";
			$requestUser = $conn->query($query);
			$requestIcon = $requestUser->fetch_assoc()['icon']; 
			$content = strlen($content) > 115 ? substr($content, 0, 115)."...": $content;
			$notifsHTML .= "<div class='notifSample'>
					<img class='uicon' src='$requestIcon'>
					<div class='notifInfo'>
						<h3 id='notifUName'>$user</h3> <span id='notiftype'>liked</span> your post: 
						<div class='notifpostBody'>
							&ldquo; <textarea disabled='disabled' class='notifpostText'>$content</textarea> &rdquo;
						</div>
					</div>
					<div class='notifsymbol'><i class='fa fa-heart'></i></div>
				</div>";
			$seenQuery = "UPDATE likes SET seen = true WHERE user_id = $liker AND post_id = $likedPost";
			$conn->query($seenQuery);
		}
	}
	if(($likeCount + $replyCount) > 0){
		echo trim(preg_replace('/\s+/', ' ', $notifsHTML));
	}
	else{
		echo 0;
	}
?>