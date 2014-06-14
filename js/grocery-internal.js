// JS for Internal GrocEx site

$(document).ready(function(){

	function addpositioner (target){
		target.position({
			'my': 'center top',
			'at': 'center center-65',
			'of': $(window)
		});
	}

	function otherfield (selector, altfield){
		altfield.hide();
		selector.change(function() {
			if(selector.val() == "Other" || selector.val() == "Add New...") {
				altfield.show();
			} else {
				altfield.hide();
			}
		});
	}

	var winHeight = $(window).outerHeight();
	var headHeight = $('header').outerHeight();
	var navHeight = $('nav').outerHeight();
	var footHeight = $('footer').outerHeight();
	$('main').css({'min-height': winHeight-headHeight-navHeight-footHeight+"px"});


	var $email1 = $('#emaillist');
	var $email2 = $('#emaillist2');

	var $locationselect1 = $('#locationselect'); 
	var $locationselect2 = $('#locationselect2');
	
	//random background image generator
	/*var image = Math.floor(Math.random() * 10); //adjust number based on number of available images
	
	$vportw = $(window).width();
	$vporth = $(window).height();
	if ($vportw >= 960 && $vportw >= $vporth) {
		$('html').css({
			'background': 'url(img/background/ibg' + image + 'h.jpg) no-repeat center center fixed',
			'-webkit-background-size': 'cover',
	 		'-moz-background-size': 'cover',
	  		'-o-background-size': 'cover',
	  		'background-size': 'cover'		
		});
	}else if($vportw >= 960 && $vportw <= $vporth) {
		$('html').css({
			'background': 'url(img/background/ibg' + image + 'v.jpg) no-repeat center center fixed',
			'-webkit-background-size': 'cover',
	 		'-moz-background-size': 'cover',
	  		'-o-background-size': 'cover',
	  		'background-size': 'cover'		
		});
	} else if ($vportw <= 959 && $vportw >= $vporth) {
		$('html').css({
			'background': 'url(img/background/ibg' + image + '-mobileh.jpg) no-repeat center center fixed',
			'-webkit-background-size': 'cover',
	 		'-moz-background-size': 'cover',
	  		'-o-background-size': 'cover',
	  		'background-size': 'cover'		
		});
	} else if ($vportw <= 959 && $vportw <= $vporth) {
		$('html').css({
			'background': 'url(img/background/ibg' + image + '-mobilev.jpg) no-repeat center center fixed',
			'-webkit-background-size': 'cover',
	 		'-moz-background-size': 'cover',
	  		'-o-background-size': 'cover',
	  		'background-size': 'cover'		
		});
	}

	if((image % 2) > 0) {
		$('header h1').css({'color': '#111'});
		$('header h2').css({'color': '#111'});
	} else {
		$('header h1').css({'color': '#eee'});
		$('header h2').css({'color': '#eee'});
	}*/
	

	//AJAX call to mark item in basket in database
	var $inbasket = $('.item_checkbox');
	$inbasket.on('click', function () {
		var theItemId = $(this).val();
		var theBasketState = 0;
		if($(this).prop('checked')) {
			theBasketState = 1;
		}
		$.ajax({ //Updates database with basket status to save for when reloading page
			url: "grocery-basket.php",
			type: "post",
			data: {
				inbasket: theItemId,
				basket_state: theBasketState,
				ajax: 'true'
			}
		});
	});

	//Sets CSS for items in basket on change
	$('.item_checkbox').on('change', function () {
		if($(this).prop('checked')) {
			$(this).parentsUntil('li').parent().addClass('cart-checked');
		} else {
			$(this).parentsUntil('li').parent().removeClass('cart-checked');
		}
	});

	otherfield($email1, $email2);
	otherfield($locationselect1, $locationselect2);

	addpositioner($('#editwrapper'));

/*	$(window).resize(function() {
		addpositioner($('#addwrapper'));
		addpositioner($('#editwrapper'));
	});*/

	//Code to handle click actions of navigation forms (filters and email)
	$('nav ul li span').siblings('ul').hide();
	$('nav ul li span').on('click', function() {
		$(this).toggleClass('nav-active');
		if($(this).parent().siblings().children('span').hasClass('nav-active')) {
			$(this).parent().siblings().children('span').removeClass('nav-active');
			$(this).parent().siblings().children('ul').slideUp(300);
		}		
		$(this).siblings('ul').slideToggle(300);
	});

	$('nav ul li a').on('click', function(e) {
		e.preventDefault();
	});

	$('header, #contentwrapper, footer, nav ul li a, nav #filtertags').on('click', function() {
		if($('nav ul li span').hasClass('nav-active')) {
			$('.nav-active').siblings('ul').slideToggle(300, function() {
				$('.nav-active').removeClass('nav-active');
			});
		}
	});


	
	$('nav input[type="date"], #addwrapper input[type="date"]').addClass('datepick').attr('type', 'text');

	$('.datepick').datepicker({ dateFormat: "yy-mm-dd" });
	

});