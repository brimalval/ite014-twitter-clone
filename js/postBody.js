$('.likes').click(function(){
		var postid = this.dataset.postid;
		var postmaker = this.dataset.postmaker;
		var heartIcon = this.children[0];
		var text = this.children[1];
		var textInt = parseInt(text.innerHTML.trim(),10);
		var fullHeart = 'noredir fas fa-heart';
		var emptyHeart = 'noredir far fa-heart';
		$.post('likepost.php',{postid:postid, postmaker:postmaker},
		function(data){
			console.log(data);
			if(data > 0){
				heartIcon.className = fullHeart;
				text.innerHTML = textInt + 1;
			}else{
				heartIcon.className = emptyHeart;
				text.innerHTML = textInt - 1;
			}
		});
	});

$('.comments').click(function(){
	var postid = this.dataset.postid;
	$.post('replyTo.php', {postid:postid},
	function(data){
		console.log(data);
	});
	$('.popupBg')[0].classList.remove('invisible');
});

$('.postBody').click(function(e){
	if(e.target.className.includes("noredir")){
	}else{
	}
});

$('a').click(function(){
	console.log(this.dataset.target);
});

$('.noredir').click(function(){
	if(this.dataset.target){
		console.log(this.dataset.target);
	}
});