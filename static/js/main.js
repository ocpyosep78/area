$(function() {
	// search
	$('#searchform').submit(function() {
		var action = $('#searchform').attr('action');
		var keyword = Func.GetName($('#keyword').val());
		if (keyword.length == 0) {
			return false;
		}
		
		$('#searchform').attr('action', action += '/' + keyword);
	});
	
	// slide
	if ($('#home_slider').length == 1) {
		$('#home_slider').flexslider({
			animation: 'fade', animationLoop: true, slideshow: true, slideshowSpeed: 7000, animationSpeed: 600, controlNav: true, directionNav: true, pauseOnAction: true,
			pauseOnHover: false, useCSS: false, manualControls: '#thumb_controls li', start: function(){}, end: function(){}, added: function(){}, removed: function(){}
		});
	}
	
	// to top
	$(window).scroll(function() {
		if ($(this).scrollTop() >= 110) {
			$('#toTop').show();
		} else {
			$('#toTop').hide();
		}
	});
	$('#toTop').click(function(e) {
		$('body,html').animate({scrollTop:0}, 800);
		e.preventDefault();
	});
	
	/* Disable select text on dbl click */
	$('.section2 .newsletter .newsletter-title,.jcarousel-prev,.jcarousel-next,.login-popup-link,.registration-popup-link').mousedown(function(e){
		e.preventDefault();
		return false;
	});
	$('.section2 .newsletter .newsletter-title,.jcarousel-prev,.jcarousel-next,.login-popup-link,.registration-popup-link').select(function(e){
		e.preventDefault();
		return false;
	});
	/* Disable select text on dbl click */
	
	// sidebar tab
	$('.block_news_tabs').tabs('div.tab_content', { tabs: 'div.tabs a', initialIndex: 0 });
	
	// sidebar slide
	$(".widget_recent_blogposts .widget_body").flexslider({
		animation: "fade", slideshow: false, controlNav: false, directionNav: true, prevText:"", nextText:"",
		smoothHeight: true, controlsContainer: ".flex-container", after: function(slider) {
			$(".widget_recent_blogposts .cur_page").eq(0).html(slider.currentSlide + 1);
		}
	});
	
	jQuery('#site-main-menu').mobileMenu();
	jQuery('body #overlay').click(function(e){
		jQuery('body').removeClass('overlayed');
		jQuery(this).fadeOut(100);
		jQuery('.login-popup').fadeOut();
		jQuery('#registration').fadeOut();
		e.preventDefault();
		return false;
	});
	jQuery('.section2 .newsletter .newsletter-title').click(function(){
		jQuery(this).parent().find('.newsletter-popup:hidden').fadeToggle(100).find('input[type="text"]').focus();
	});
	jQuery('.newsletter-popup').focusout(function(){
		jQuery(this).fadeOut();
	});
	jQuery('#top-left-menu').superfish({
		autoArrows: false,
		speed: 'fast',
		speedOut: 'fast',
		animation: {height:'show'},
		animationOut: {height: 'hide'},
		useClick: false,
		disableHI: true
	});
	jQuery('#site-main-menu').superfish({
		autoArrows: false,
		speed: 'fast',
		speedOut: 'fast',
		animation: {height:'show'},
		animationOut: {opacity: 'hide'},
		useClick: false,
		delay: 100,
		disableHI: true
	});
	
	// init login
	jQuery('.login-popup-link').click(function(e) {
		$('body').addClass('overlayed');
		$('#overlay').fadeIn(100);
		
		if ($('.login-popup .close').length == 0) {
			Func.ajax({ url: web.host + 'ajax/view', param: { 'action': 'view_login' }, is_json: 0, callback: function(view) {
				$('.login-popup').html(view);
				$('.login-popup').fadeIn();
				$('.login-popup [name="email"]').get(0).focus();
				
				$("#form-login").validate({
					rules: {
						email: { required: true, email: true },
						passwd: { required: true }
					},
					messages: {
						email: { required: 'Silahkan mengisi field ini', email: 'Email anda tidak valid' },
						passwd: { required: 'Silahkan mengisi field ini' }
					}
				});
				
				$('#form-login').submit(function() {
					if (! $("#form-login").valid()) {
						return false;
					}
					
					$('#form-login .c_message').hide();
					var param = Site.Form.GetValue('form-login');
					Func.ajax({ url: web.host + 'ajax/user', param: param, callback: function(result) {
						if (result.status) {
							window.location.reload();
						} else {
							$('#form-login .c_message').text(result.message);
							$('#form-login .c_message').slideDown();
						}
					} });
					
					return false;
				});
				
				$('.login-popup .close').click(function(e) {
					$('body').removeClass('overlayed');
					$('#overlay').fadeOut(100);
					$('.login-popup').fadeOut();
					
					e.preventDefault();
					return false;
				});
			} });
		}
		else {
			$('.login-popup').fadeIn();
			$('.login-popup [name="email"]').get(0).focus();
		}
		
		e.preventDefault();
		return false;
	});
	
	// init registration
	jQuery('.registration-popup-link').click(function(e) {
		$('body').addClass('overlayed');
		$('#overlay').fadeIn(100);
		
		if ($('.registration-popup .close').length == 0) {
			Func.ajax({ url: web.host + 'ajax/view', param: { 'action': 'view_registration' }, is_json: 0, callback: function(view) {
				$('.registration-popup').html(view);
				$('.registration-popup').fadeIn();
				$('.registration-popup [name="fullname"]').get(0).focus();
				
				$("#form-register").validate({
					rules: {
						fullname: { required: true, minlength: 5 },
						email: { required: true, email: true },
						passwd: { required: true },
						passwd_confirm: { required: true, equalTo: "#passwd" }
					},
					messages: {
						fullname: { required: 'Silahkan mengisi field ini', minlength: '5 minimal karakter' },
						email: { required: 'Silahkan mengisi field ini', email: 'Email anda tidak valid' },
						passwd: { required: 'Silahkan mengisi field ini' },
						passwd_confirm: { required: 'Silahkan mengisi field ini', equalTo: 'Password anda tidak sama' }
					}
				});
				
				$('#form-register').submit(function() {
					if (! $("#form-register").valid()) {
						return false;
					}
					
					$('#form-register .c_message').hide();
					var param = Site.Form.GetValue('form-register');
					Func.ajax({ url: web.host + 'ajax/user', param: param, callback: function(result) {
						if (result.status) {
							window.location.reload();
						} else {
							$('#form-register .c_message').text(result.message);
							$('#form-register .c_message').slideDown();
						}
					} });
					
					return false;
				});
				
				$('.registration-popup .close').click(function(e) {
					$('body').removeClass('overlayed');
					$('#overlay').fadeOut(100);
					$('.registration-popup').fadeOut();
					
					e.preventDefault();
					return false;
				});
			} });
		}
		else {
			$('.registration-popup').fadeIn();
			$('.registration-popup [name="fullname"]').get(0).focus();
		}
		
		e.preventDefault();
		return false;
	});
	
	// tweeter
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

	// facebook
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/id_ID/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
});