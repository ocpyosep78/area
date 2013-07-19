jQuery(document).ready(function() {
	if (!jQuery.browser.msie) {
		jQuery('.slides li').each(function() {
			var imgs = jQuery(this).find('img');
			if (imgs.length > 0 && imgs.get(0).width === 0) {
				jQuery(this).html('Sorry, requested content is unavailable');
			}
		});
	}
	jQuery('#home-gallery-wrapper').elastislide({ margin: 18, minItems: 3, imageW: 194 });
	
	"use strict";
	/* to Top */
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() >= 110) {
			jQuery('#toTop').show();	}
		else {
			jQuery('#toTop').hide();}
	});
	if(jQuery('.single article .post_thumb img').attr('width') <= 500) {
		jQuery('.single article .pic').parent().addClass('img-floated');
	}
	jQuery	('#toTop').click(function(e) {

		jQuery('body,html').animate({scrollTop:0}, 800);
		e.preventDefault();
	});

	/* Disable select text on dbl click */
	jQuery('.section2 .newsletter .newsletter-title,.jcarousel-prev,.jcarousel-next,.login-popup-link,.registration-popup-link').mousedown(function(e){
		
		e.preventDefault();
		return false;
	});
	
	jQuery('.section2 .newsletter .newsletter-title,.jcarousel-prev,.jcarousel-next,.login-popup-link,.registration-popup-link').select(function(e){
		
		e.preventDefault();
		return false;
	});
	/* /Disable select text on dbl click */

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
	jQuery('#flexslider-news').flexslider({
		animation: "slide",
		pausePlay: true,
		slideshow: true,
		slideshowSpeed: 10000,
		controlNav: false
	});
	jQuery('article .gallery').flexslider({
		animation: "fade",
		speed: "slow",
		controlNav: true,
		directionNav: true
	});
	jQuery('#news_style2_header').flexslider({
		animation: "fade",
		slideshow: true,
		slideshowSpeed: 10000,
		controlNav: true
	});
	
	jQuery('#blog_posts .slider_container').flexslider({
		animation: "fade",		
		controlNav: false
	});
	
	jQuery('div.sc_infobox_closeable').click(function() {
		
		jQuery(this).fadeOut();
	});
	jQuery('.sc_tooltip_parent').hover(function(){
		
		var obj = jQuery(this);
		obj.find('.sc_tooltip').stop().animate({'marginTop': '5'}, 100).show();
	},
	function(){
		
		var obj = jQuery(this);
		obj.find('.sc_tooltip').stop().animate({'marginTop': '0'}, 100).hide();
	});

	// ----------------------- Contact form submit ----------------
	jQuery('.sc_contact_form .enter').click(function(e){
		userSubmitForm();
		e.preventDefault();
		return false;
	});

	// init login
	jQuery('.login-popup-link').click(function(e) {
		$('body').addClass('overlayed');
		$('#overlay').fadeIn(100);
		
		if ($('.login-popup .close').length == 0) {
			Func.ajax({ url: web.host + 'ajax/view', param: { 'action': 'view_login' }, is_json: 0, callback: function(view) {
				$('.login-popup').html(view);
				$('.login-popup').fadeIn();
				$('.login-popup #log').get(0).focus();
				
				$('.login-popup .close').click(function(e) {
					$('body').removeClass('overlayed');
					$('#overlay').fadeOut(100);
					$('.login-popup').fadeOut();
					
					e.preventDefault();
					return false;
				});
			} });
		} else {
			$('.login-popup').fadeIn();
			$('.login-popup #log').get(0).focus();
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
				$('.registration-popup #registration_form_username').get(0).focus();
				
				$('.registration-popup .close').click(function(e) {
					$('body').removeClass('overlayed');
					$('#overlay').fadeOut(100);
					$('.registration-popup').fadeOut();
					
					e.preventDefault();
					return false;
				});
			} });
		} else {
			$('.registration-popup').fadeIn();
			$('.registration-popup #registration_form_username').get(0).focus();
		}
		
		e.preventDefault();
		return false;
	});
});
