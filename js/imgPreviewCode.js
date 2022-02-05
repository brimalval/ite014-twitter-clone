
		$('.likes').click(function(){
			var postid = this.dataset.postid;
			var heartIcon = this.children[0];
			var text = this.children[1];
			var textInt = parseInt(text.innerHTML.trim(),10);
			var fullHeart = 'noredir fas fa-heart';
			var emptyHeart = 'noredir far fa-heart';
			$.post('likepost.php',{postid:postid},
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
				$('.popupBg')[0].classList.remove('invisible');
			});
			console.log(this.dataset);
		});

		$('.postBody').on('click',function(e){

		});

		if(!$('.imagePreview')[0]){
			var imgPreview = '<div class='imagePreviewContainer'><div class='imagePreview'></div></div>';
			$('body').prepend(imgPreview);
		}