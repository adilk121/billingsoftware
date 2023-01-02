/*
Template Name: Samar Real Estate - Bootstrap 4 Light  Theme
Author: Giftechies
Author URI: https://themeforest.net/user/giftechies
Version: 1.0
*/
$(document).ready(function() {
	"use strict";

	// ===========Hover Nav============	
		$('.navbar-nav li.dropdown').on('mouseenter', function(){ $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(500); })
		$('.navbar-nav li.dropdown').on('mouseleave', function(){ $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(500); });
	
	// ===========Select2============	
		$(document).ready(function() {
			$('.select2').select2();
		});

});