<!--These are all the functions, etc. necessary for elements which are repeatedly loaded across
several files (such as the nav bar and functions for the posts) -->
<?php
	include_once 'likepost.php';
	include_once 'dbconnection.php';
	if(session_status() == PHP_SESSION_NONE){
		session_start();
		$_SESSION['replyto'] = 0;
	}
	if(!isset($_SESSION['user'])){
		echo "<script>alert('You must log in first!');</script>";
		echo "<script>window.location='login.php';</script>";
	}
	include 'loadPosts.php';
	echo "<script src='https://kit.fontawesome.com/feb0efc128.js' crossorigin='anonymous'></script>";
	echo "<link rel='stylesheet' href='css/home.css'>";
	$icon = $_SESSION['icon'];
	$currentUser = $_SESSION['user'];
?>
<script>
	$(document).ready(function(){
		var currentWindowQuery;
		$('link').remove();
		$('head').append(''+
		'<script src="https://kit.fontawesome.com/feb0efc128.js" crossorigin="anonymous"><\/script>'+
		'<link rel="stylesheet" href="css/navbar.css">'+
		'<link rel="stylesheet" href="css/post.css">'+
		'<link rel="stylesheet" href="css/chirpForm.css">'+
		'<link rel="stylesheet" href="css/home.css">'+
		'<link rel="stylesheet" href="css/chirpPopup.css">'+
		'<link rel="stylesheet" href="css/profile.css">'+
		'<link rel="stylesheet" href="css/search.css">');
		//ADDS NAV BAR TO PAGE IF IT DOESN'T ALREADY HAVE IT
		var navbar = document.getElementsByClassName('navbar')[0];
		if(!navbar){
			//JAVASCRIPT IS SENSITIVE TO LINE BREAKS PO KASI
			var nav = "<?=trim(preg_replace('/\s+/', ' ',file_get_contents('navbar.php')))?>";
			$('body').prepend(nav);
		} 
		
		//ADDS POPUP FOR CHIRPING IF IT ISN'T ALREADY THERE
		if(!$('.popupBg')[0]){
			var popupHTML = "<?=trim(preg_replace('/\s+/', ' ', file_get_contents('chirpPopup.php')))?>";
			$('body').prepend(popupHTML);
			var formHTML = "<?=trim(preg_replace('/\s+/', ' ', file_get_contents('chirpForm.php')))?>";
			$('.popupForm').append(formHTML);
		}

		//ADDS CONTENT BOX IF IT ISN'T ALREADY THERE
		if(!$('.content')[0]){
			var contentDiv = "<div class='content' style='position: relative'>";
			$('body').append(contentDiv);
		}

		//ADDS SEARCH/NOTIF BAR IF IT ISN'T ALREADY THERE
		if(!$('.searchWrapper')[0]){
			var searchWrapperHTML = "<?=trim(preg_replace('/\s+/', ' ', file_get_contents('search.php')))?>";
			$('body').prepend(searchWrapperHTML);
		}

		//FUNCTION FOR CENTERING DIV WITHIN A WINDOW & ITS WRAPPER
		function center(cont, wrapper){
			var contH = cont.clientHeight;
			var contW = cont.clientWidth;
			var windowH = window.innerHeight;
			var windowW = window.innerWidth;
			
			wrapper.style.paddingLeft = ((windowW-contW)/2)+"px";
			wrapper.style.paddingTop = ((windowH-contH)/2)+"px";
		}
		//LOADS HOMEPAGE
		function homeload(){
			currentWindowQuery = "SELECT * FROM posts ORDER BY date DESC";
			//FUNCTIONS FOR CHIRPFORM
			loadChirpFunctions();
			window.history.pushState("home", "Home", "/socmedv2/home.php");
			$('#homenav').children().each(function(){
				this.classList.add('activenavlink');
			});

			if(!$('.content').children()[0]){
				$('.content').append($('.posts').children());
			}else if(window.history.state != "home"){
				$('.content').empty().append($('.posts').children());
			}else{
				$('.content').empty().prepend("<script src='https://kit.fontawesome.com/feb0efc128.js' crossorigin='anonymous'><//script>");
				$('.content').append("<link rel='stylesheet' href='css/home.css'>");
				$.post('loadPosts.php', {query: currentWindowQuery},
				function(data){
					$('.content').append(data);
				});
			}
			$('#hh').children()[0].innerHTML = "Home";
		}

		function profileLoad(uname){
			loadChirpFunctions();
			window.history.pushState("profile", "Profile", "/socmedv2/profile.php?user="+uname);
			$('#profilenav').children().each(function(){
				this.classList.add('activenavlink');
			});
			$.post('loadProfile.php', {uname: uname},
				function(data){
					if($('.editpopupBox')[0]){
						$('.editpopupBox').remove();
					}
					$('.content').prepend(data);
					$('body').prepend($('.editpopupBox'));
				});
			var requestProfilePostsForm = new FormData();
			var query = "SELECT * FROM posts WHERE user = '<?=$currentUser?>' ORDER BY date DESC";
			requestProfilePostsForm.append("query", query);
			$.ajax({
				url: 'loadPosts.php',
				method: 'POST',
				data: requestProfilePostsForm,
				contentType: false,
				processData: false,
				cache: false,
				success: function(data){
					$('.content').append(data);
				}
			});

			$('#hh').children()[0].innerHTML = "Profile";
		}

		function searchLoad(){
			window.history.pushState("search", "Search", "/socmedv2/search.php");
			$('#searchnav').children().each(function(){
				this.classList.add('activenavlink');
			});
		}

		function msgLoad(){
			window.history.pushState("msgs", "Messages", "/socmedv2/msgs.php");
			$('#msgnav').children().each(function(){
				this.classList.add('activenavlink');
			});
		}
		//NAVIGATION LINKS
		$('a').click(function(){
			if(this.id != "chirp" && this.id != 'logoutnav'){
					$('.navbtnicon').each(function(){
						this.classList.remove('activenavlink');
					});

					$('.navbtnh7').each(function(){
						this.classList.remove('activenavlink');
					});

				var target = this.dataset.url;
				if(target == 'home.php'){
					homeload();
				}else if(target == 'profile.php'){
					profileLoad("<?=$_SESSION['user']?>");
				}else if(target == 'search.php'){
					searchLoad();
				}else if(target == 'notifs.php'){
					notifLoad();
				}else if(target == 'msgs.php'){
					msgLoad();
				}

				if(target != 'home.php'){
					$('.posts').append($('.content').children());
				}
			}else if(this.id == 'logoutnav'){
				return confirm('Are you sure you want to log out?');
			}
			return false;
		});

		//FUNCTIONS FOR CHIRP FORM (defined in a function because it's used more than once)
		function loadChirpFunctions(){
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
				//STUFF TO CENTER THE POP-UP
				var doc = document.getElementsByClassName('content')[0];
				var greatGrandParent = $('.contentInput')[0].parentElement.parentElement.parentElement;
				var gggGrandParent = greatGrandParent.parentElement.parentElement;
				center(greatGrandParent.parentElement, gggGrandParent);
			}

			$('.contentInput').on('input', function(){
				grow();
			});

			//NAVBAR CHIRP BUTTON
			$('#chirp').click(function(){
				<?php if(isset($_SESSION['replyto'])){$_SESSION['replyto'] = 0;} ?>
				$('.popupBg')[0].classList.remove("invisible");
				var wrapper = $('.popupBg')[0];
				var container = $('.popupContainer')[0];
				wrapper.style.paddingLeft = ((window.innerHeight-container.clientHeight)/2) + "px";
				wrapper.style.paddingTop = ((window.innerHeight-container.clientHeight)/2) + "px";
			});

			$('#imgContent').change(function(){
				console.log(this.parentElement.parentElement);
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

			$('.chirpBtn').click(function(e){
				e.preventDefault();
				e.stopImmediatePropagation();
				var attachment = document.getElementById('imgContent');
				var content = document.getElementsByClassName('contentInput')[0];
				var form = new FormData();
				if(attachment.value){
					form.append('file', attachment.files[0]);
				}	
				form.append('content', content.value);
				form.append('uid', <?=$_SESSION['uid']?>);
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
				$('.xBtnImgDisplay').trigger('click');
				content.value = "";
				$('.popupBg')[0].classList.add("invisible");
				if(window.history.state == "home"){
					$('#homenav').trigger('click');
				}else if(window.history.state == "profile"){
					$('#profilenav').trigger('click');
				}
				console.log(window.history.state);
			});

			$('.xBtnImgDisplay').click(function(){
				this.style.display = "none";
				$('.imgWrapper').empty();
				$('#imgContent').val(null);
				maxHeight = $(window).height() - 300;
				grow();
			});
		}

		if(window.history.state == "home"){
			homeload();
			$('#homenav').children().each(function(){
				this.classList.add('activenavlink');
			});
		}if(window.history.state == "profile"){
			profileLoad("<?=$_SESSION['user']?>");
			$('#profilenav').children().each(function(){
				this.classList.add('activenavlink');
			});
		}

		$(window).on("resize", function(){
			var greatGrandParent = $('.contentInput')[0].parentElement.parentElement.parentElement;
			var gggGrandParent = greatGrandParent.parentElement.parentElement;
			var isItShowing = !gggGrandParent.classList.contains("invisible");
			if(isItShowing){
				center(greatGrandParent.parentElement, gggGrandParent);
			}
		});
		//POPUP X BUTTON
		$('#popupxBtn').click(function(){
			$('.popupBg')[0].classList.add("invisible");
			<?php $_SESSION['replyto'] = 0 ?>
			console.log("<?="Now replying to ".$_SESSION['replyto']?>");
		});

		//NOTIF REFRESH BUTTON
		$('.fa-refresh').click(function(){
			$.ajax({
			url: 'loadNotifs.php',
			method: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			success: function(data){
				if(data != 0){
					$('.notifList').prepend(data);
				}else{
					alert('No new notifications.');
				}
			}
			});
		});
		$('#profilenav').children()[0].src = "<?=$icon?>";
		document.getElementById('icon').src = "<?=$icon?>";
	});
</script>