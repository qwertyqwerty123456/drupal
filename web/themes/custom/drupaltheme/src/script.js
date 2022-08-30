const picture = document.querySelector('#picture');
let photos = document.querySelectorAll('.product_gallery-photo');
console.log(photos);
$('.product_gallery-photo').on('mouseenter', 'img', function (){
	const img_src = $(this).attr('src');
	picture.src = img_src;
})

$(document).ready(function(){
	$('.zoom').hover(function() {
		$(this).addClass('transition');
	}, function() {
		$(this).removeClass('transition');
	});
});

$(document).ready(function() {
	$('.number-minus').click(function () {
		const $input = $(this).parent().find('input');
		let count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		return false;
	});
	$('.number-plus').click(function () {
		const $input = $(this).parent().find('input');
		$input.val(parseInt($input.val()) + 1);
		$input.change();
		return false;
	});

});

$(function(){
	$('#buy').click(function(){
		$('#message').fadeIn().css('top',$(document).height()/3);
		const val = document.querySelector('.number-text').value;
		document.querySelector('#val').innerHTML = val;
	});
	$('#ok').click(function(){
		$('#message').fadeOut();
	});

});


