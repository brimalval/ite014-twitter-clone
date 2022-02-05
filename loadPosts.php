<?php
	date_default_timezone_set('Asia/Manila');
	if(isset($_POST['query'])){
		include 'dbconnection.php';
		include 'likepost.php';
		$query = $_POST['query'];
		unset($_POST['query']);
		$resultset = $conn->query($query);
		$returnstr = "";
		while($row = $resultset->fetch_assoc()){
			//USERNAME OF THE POSTER
			$postUName = $row['user'];
			//GETTING THE POSTER'S ICON
			$userIconQuery = "SELECT id, icon, handle FROM accts WHERE user = '$postUName'";
			$result = $conn->query($userIconQuery);
			$user = $result->fetch_assoc();
			$icon = $user['icon'];
			$poster_id = $user['id'];
			//GETTING THE INFO ABOUT THE POST
			$postid = $row['id'];
			$handle = $user['handle'];
			$content = $row['content'];
			$attachment = $row['attachment'];
			$comments = $row['comments'];
			$likes = $row['likes'];
			//USED IN CALCULATING HOW MUCH TIME SINCE THE POST WAS MADE
			$timeposted = strtotime($row['date']);
			$currentTime = date("U");
			//(time since post)
			$tsp = $currentTime - $timeposted;
			//less than a minute
			if($tsp < 60){
				$time = round($tsp)."s";
			}
			//less than an hour
			else if($tsp < 3600){
				$time = round($tsp/60)."m";
			}
			//less than a day
			else if($tsp < 86400){
				$time = round($tsp/3600)."h";
			}
			//less than a week
			else if($tsp < 604800){
				$time = round($tsp / 86400)."d";
			}
			//less than a month
			else if($tsp < 31536000){
				$time = date('F j', $tsp);
			}
			//A year or more
			else{
				$time = date('F j, Y', $tsp);
			}

			if(islikedBy($row['id'], 1)){
				$likeIconStatus = "noredir fas fa-heart";
			}else{
				$likeIconStatus = "noredir far fa-heart";
			}

			if($attachment != ""){
				$imgHTML = "<img id='imgContent' src='$attachment'>";
			}else{
				$imgHTML = "";
			}                             
			$returnstr .= "
<div data-postid='$postid' class='postBody'>
	<img data-target='profile.php?user=$postUName' class='noredir' id='icon' src='$icon'>
	<span class='posterInfo'>
		<a data-target='profile.php?user=$postUName' onclick='return false' href='#' id='name'>$handle</a>
		<label id='uname'>@$postUName</label>
		·
		<label id='time'>$time</label>
	</span>
	<div class='contentWrapper'>$content</div>
	<div class='imgContent'>$imgHTML</div>
	<div class='commentslikes'>
		<span id='commentSpan'>
			<button data-postid='$postid' class='noredir' id='commentBtn'>
			</button>
			<label data-btninfo='this' data-postid='$postid' class='comments noredir' for='commentBtn' id='comments'>
			<i class='noredir fas fa-comment'></i>
			<h7>
			$comments
			</h7>
			</label>
		</span>
		<span id='heartSpan'>
			<button data-postid='$postid' class='noredir' id='likeBtn'>
			</button>
			<label data-postid='$postid' data-postmaker=$poster_id class='likes noredir' for='likeBtn' id='likes'>
			<i class='$likeIconStatus'></i>
			<h7>
			$likes
			</h7>
			</label>
		</span>
	</div>
</div>";
		}
		//javascript can't handle multiline string kasi minsan sir
		//echo "<h1>POOP $resultset->num_rows </h1>";

		//yung other code naman loaded asynchronously

		$scripts = "<script>".file_get_contents('js/postBody.js')."</script>";
		$returnstr = $scripts.$returnstr;
		$finalReturnStr = trim(preg_replace('/\s+/', ' ', $returnstr));
		echo $finalReturnStr;
	}
?>