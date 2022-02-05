<?php 
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/chirpForm.css">
	<script src="js/jquery.js"></script>
	<script src="https://kit.fontawesome.com/feb0efc128.js" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
			var maxHeight = $(window).height()-300;
			function grow(){
				var cont = 
				document.getElementsByClassName('contentInput')[0];
				cont.style.height = "5px";
				if(cont.scrollHeight < (maxHeight)){
					cont.style.height = cont.scrollHeight+"px";
					cont.style.overflowY = "hidden";
				}else{
					cont.style.overflowY = "scroll";
					cont.style.height = (maxHeight)+"px";
				}
				var capacity = 
				document.getElementsByClassName('contentCapacity')[0];
				capacity.innerHTML = cont.value.length + "/280";

				if(capacity.innerHTML == "280/280"){
					capacity.style.color = "red";
				}else{
					capacity.style.color = "gray";
				}
			}
			$('.contentInput').on('input', function(){
				grow();
			});

			$('#imgContent').change(function(){
				if(this.files){
					var xBtn = 
					document.getElementsByClassName('xBtnImgDisplay')[0];
					xBtn.style.display = "inline-block";
					var img = URL.createObjectURL(this.files[0]);
					$('.imgWrapper').empty().prepend("<img src="+img+">");
					maxHeight = $(window).height() - 500;
					grow();
				}
			});

			$('.chirpBtn').click(function(){
				var attachment = document.getElementById('imgContent');
				var content = document.getElementsByClassName('contentInput')[0];
				var form = new FormData();
				if(attachment.value){
					form.append('file', attachment.files[0]);
				}	
				form.append('content', content.value);
				//TODO: SESSION ID/USER
				form.append('uid', 1);
				$.ajax({
					url: 'chirpUpload.php',
					method: 'POST',
					data: form,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data){
						console.log(data);
					}
				});
			});

			$('.xBtnImgDisplay').click(function(){
				this.style.display = "none";
				$('.imgWrapper').empty();
				$('#imgContent').val(null);
				maxHeight = $(window).height() - 300;
				grow();
			});
		});
	</script>
</head>
<body>
	<div class="chirpForm">
		<input id="imgContent" type="file">
		<img id="icon" src="img/vibecheck.jpg">
		<div class="taWrapper">
			<textarea class="contentInput" maxlength="280" placeholder="What's going on?"></textarea>

			<div class="imgContentDisplay">
				<div class="imgWrapper">
				</div>
				<button id="xBtnImgDisplay" class="xBtnImgDisplay">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="footerBtns">
				<span>
				<label for="imgContent" class="imgContent">
					<i class="fas fa-file"></i>
				</label>
				</span>
				<span id="btnSpan">
					<label class="contentCapacity">0/280</label>
					<button class="chirpBtn">Chirp</button>
				</span>
			</div>
		</div>
	</div>
</body>
</html>