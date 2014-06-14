//Main JS for GrocEx
$(document).ready(function(){
	$('html').removeClass('no-js').addClass('js');

	$('.message').delay(10000).slideUp(300);
	$('.message').click(function () {
		$('#messageclose').hide();
		$(this).clearQueue().slideUp(300);
	});

});