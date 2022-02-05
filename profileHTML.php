<div class='profileContainer'>
	<div class='profilebannerWrapper'>
		<img src='img/landscape.jpg'>
		<div class='profileeditBtn'>
			<button>Edit Profile</button>
		</div>
	</div>
	<div class='profileiconWrapper'>
		<img src='img/vibecheck.jpg'>
	</div>
	<div class='profileinfo'>
		
		<h3><?=$handle?></h3>
		<h7>@<?=$uname?></h7>
		<div class='bioDiv'>
			<?=$bio?>
		</div>
		<div class='profiledates'>
			<span class='bdaySpan'>
				<i class='fas fa-birthday-cake'></i>
				<h7>Born <?=$bday?></h7>
			</span>
			<span class='joinSpan'>
				<i class='fas fa-calendar'></i>
				<h7>Joined <?=$datejoined?></h7>
			</span>
		</div>
	</div>
</div>