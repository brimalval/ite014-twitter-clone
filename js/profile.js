$('.profileeditBtn button').click(function(){
	$('.editpopupBox')[0].classList.remove('invisible');
});

$(window).click(function(e){
	if(e.target == $('.editpopupBox')[0]){
		e.target.classList.add('invisible');
	}
});

var bioLabel = document.getElementById('bioCapacity');
bioLabel.innerText = $('.bioTA')[0].value.length + '/160';

var nameLabel = document.getElementById('nameCapacity');
nameLabel.innerText = $('.nameTA')[0].value.length + '/50';

var currentName = $('.nameTA')[0].value;
var currentBio = $('.bioTA')[0].value;
var currentBday = $('#bdayinput').val();
var currentBanner = $('.bannereditdisplay')[0].src;
var currentIcon = $('.iconeditdisplay')[0].src;

$('.bioTA, .nameTA').focus(function(){
	this.parentElement.classList.add('activeDiv');
});

$('.bioTA, .nameTA').focusout(function(){
	this.parentElement.classList.remove('activeDiv');
});

$('.editTA').click(function(){
	this.children[1].focus();
});

$('.nameTA').on('input',function(){
	var label = document.getElementById('nameCapacity');
	label.innerText = this.value.length + '/50';
	$('.warning')[0].classList.add('invisible');
});

$('.bioTA').on('input',function(){
	this.style.height = '5px';
	this.style.height = this.scrollHeight + 'px';
	var label = document.getElementById('bioCapacity');
	label.innerText = this.value.length + '/160';
	console.log();
});

$('.saveBtn').click(function(e){
	e.preventDefault();
	e.stopImmediatePropagation();
	if($('.nameTA')[0].value == ''){
		$('.warning')[0].classList.remove('invisible');
		return false;
	}
	var form = new FormData();
	form.append('bday', $('#bdayinput').val());
	form.append('bio', $('.bioTA')[0].value);
	form.append('name', $('.nameTA')[0].value);
	if(document.querySelector('#editiconUpl').value != ''){
		var icon = document.querySelector('#editiconUpl');
		form.append('icon', icon.files[0]);
	}else{
		form.append('icon', 'none');
	}
	if($('#editbannerUpl').value != ''){
		var banner = document.querySelector('#editbannerUpl');
		form.append('banner', banner.files[0]);
	}else{
		form.append('banner', 'none');
	}

	$.ajax({
		url: 'updateProfile.php',
		type: 'POST',
		data: form,
		contentType: false,
		cache: false,
		processData: false,
		success: function(data){
			$('head').append(data);
		},
		error: function(data, status, error){
			console.log(error);
		}
	});

	$.post('loadProfile.php', {uname: currentUser},
	function(data){
		if($('.editpopupBox')[0]){
			$('.editpopupBox').remove();
		}
		$('#profilenav').trigger('click');
	});

	$('.editpopupBox')[0].classList.add('invisible');
});

$('#editiconUpl').change(function(){
	if(this.files){
		$('.iconeditdisplay')[0].src = URL.createObjectURL(this.files[0]);
	}
});

$('.editIcon').click(function(){
	$('#editiconUpl').trigger('click');
});

$('.editBanner').click(function(){
	$('#editbannerUpl').trigger('click');
});

$('.deleteBanner').click(function(){
	$('.bannereditdisplay')[0].src = '';
	$('.bannereditdisplay')[0].classList.add('invisible');
	this.style.display = 'none';
	var bannerCont = document.getElementById('editbannerUpl');
	bannerCont.value = '';
});

$('.editpopupXBtn').click(function(){
	$('.editpopupBox')[0].classList.add('invisible');
	$('.nameTA')[0].value = currentName;
	$('.bioTA')[0].value = currentBio;
	$('.bannereditdisplay')[0].src = currentBanner;
	$('.iconeditdisplay')[0].src = currentIcon;
	$('#bdayinput').val(currentBday);
	bioLabel.innerText = $('.bioTA')[0].value.length + '/160';
	nameLabel.innerText = $('.nameTA')[0].value.length + '/50';
});

$('#editbannerUpl').change(function(){
	if(this.files){
		$('.bannereditdisplay')[0].src = URL.createObjectURL(this.files[0]);
	}
	if($('.deleteBanner')[0].style.display = '\'none\''){
		$('.deleteBanner')[0].style.display = '\'inline-block\'';
		$('.bannereditdisplay')[0].classList.remove('\'invisible\'');
	}
});
