<?php  
	if(session_status() == PHP_SESSION_NONE){
		session_start();
		$currentUser = $_SESSION['user'];
		echo "<script>var currentUser = '$currentUser';</script>";
	}
	include 'dbconnection.php';
	$uservar = $_POST['uname'];
	$query = "SELECT * FROM accts WHERE user='$uservar'";
	$result = $conn->query($query);

	if($user = $result->fetch_assoc()){
		
	}else{
		echo "<script>alert(\"$uservar doesn't exist!\");</script>";
		echo "<script>window.location = 'home.php';</script>";
	}

	$handle = $user['handle'];
	$bio = $user['bio'];
	$datejoined = date("F Y", strtotime($user['datejoined']));
	$bday = date("F j, Y", strtotime($user['bday']));
	$icon = $user['icon'];
	$banner = $user['banner'];
	$bdayStr = $user['bday'];

	$returnstr = "<div class='profileContainer'>
	<div class='profilebannerWrapper'>
		<img src='$banner'>";
		if($_SESSION['user'] == $user['user']){
			$returnstr.="<div class='profileeditBtn'>
				<button>Edit Profile</button>
			</div>";
		}
	$returnstr.="
	</div>
	<div class='profileiconWrapper'>
		<img src='$icon'>
	</div>
	<div class='profileinfo'>
		<h3>$handle</h3>
		<h7 id='user'>@$uservar</h7>
		<div class='bioDiv'>
			$bio
		</div>
		<div class='profiledates'>
			<span class='bdaySpan'>
				<i class='fas fa-birthday-cake'></i>
				<h7>Born $bday</h7>
			</span>
			<span class='joinSpan'>
				<i class='fas fa-calendar'></i>
				<h7>Joined $datejoined</h7>
			</span>
		</div>
	</div>
</div>"."<div class='divider' style='line-height: 50px; background-color: #1a161c; width: 100%; max-width: 600px; color: white; padding-left: 20px; border-bottom: 1px solid #dddddd; border-right: 1px solid #dddddd'><h3>$handle's posts</h3></div>".
"<div class='invisible editpopupBox'>
		<div class='editpopupContent'>
			<div class='editHeader'>
				<i class='editpopupXBtn fas fa-times'></i>
				<h3>Edit profile</h3>
				<div class='saveBtnWrapper'>
					<button class='saveBtn'>Save</button>
				</div>
			</div>
			<div class='editBody'>
				<input type='file' id='editiconUpl' class='invisible'>
				<input type='file' id='editbannerUpl' class='invisible'>
				<div class='profilebannerWrapper'>
					<span class='bannerBtns'>
						<div class='editBanner'>
							<i class='fas fa-camera'></i>
						</div>
						<div class='deleteBanner'>
							<i class='fas fa-minus'></i>
						</div>
					</span>
					<img class='bannereditdisplay' src='$banner'>
				</div>

				<div class='profileiconWrapper'>
					<div class='editIcon'>
						<i id='plusIcon' class='fas fa-camera'></i>
					</div>
					<img class='iconeditdisplay' src='$icon'>
				</div>
				
				<div class='editTA editNameWrapper'>
					<h7>Name</h7>
					<input class='nameTA' type='text' maxlength='50' placeholder='Add your name' value='$handle'>
					<h8 id='nameCapacity'>50/50</h8>
				</div>

				<div class='editTA editBioWrapper'>
					<h7>Bio</h7>
					<textarea class='bioTA' maxlength='160' placeholder='Add your bio'>$bio</textarea>
					<h8 id='bioCapacity'>160/160</h8>
				</div>
	
				<div class='editBdayWrapper'>
					<h7>Birth date</h7> · 
					<label for='bdayinput'>Edit</label>
					<input id='bdayinput' type='date' value='$bdayStr'>
				</div>
			</div>
		</div>
		<div class='invisible warning'>
			You must write a name
		</div>
	</div>";
	$scripts = file_get_contents('js/profile.js');
	$returnstr = "<script>".$scripts."</script>".$returnstr;
	echo trim(preg_replace('/\s+/', ' ', $returnstr));
?>