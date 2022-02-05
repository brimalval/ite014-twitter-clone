<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/post.css">
	<script src="js/jquery.js"></script>
	<script src="https://kit.fontawesome.com/feb0efc128.js" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
			var imgPreview = document.querySelector('.imagePreviewContainer');
			$('.imgContent').click(function(){
				var img = this.innerHTML;
				$('.imagePreview').empty().prepend(img);
				imgPreview.style.display = "inline-block";
			});

			$('.imagePreviewContainer').click(function(e){
				if(e.target == this)
					this.style.display = "none";
			});
		});
	</script>
</head>
<body>
	<div class="imagePreviewContainer">
		<div class="imagePreview"></div>
	</div>
	<div class="postBody">
		<img id="icon" src="img/vibecheck.jpg">
		<span class="posterInfo">
			<a data-target="profile.php?user=" onclick="return false" href="#" id="name">Name</a>
			<label id="uname">@user</label>
			·
			<label id="time">69d</label>
		</span>
		<div class="contentWrapper">What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
		</div>
		<div class="imgContent"><img id="imgContent" src="img/landscape.jpg"></div>
		<div class="commentslikes">
			<span id="commentSpan">
				<button id="commentBtn">
				</button>
				<label for="commentBtn" id="comments">
				<i class="fas fa-comment"></i>
				69
				</label>
			</span>
			<span id="heartSpan">
				<button id="likeBtn">
				</button>
				<label for="likeBtn" id="likes">
				<i class="far fa-heart"></i>
				69
				</label>
			</span>
		</div>
	</div>

	
</body>
</html>