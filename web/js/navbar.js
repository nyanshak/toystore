/* Credit for responsive navbar goes to Thoriq Firdaus at: http://www.hongkiat.com/blog/responsive-web-nav/ */

$(function() {
	var pull 		= $('#pull');
	menu 		= $('nav ul');
	menuHeight	= menu.height();

	$(pull).on('click', function(e) {
		e.preventDefault();
		menu.slideToggle();
	});

	$(window).resize(function(){
		var w = $(window).width();
		if(w > 320 && menu.is(':hidden')) {
			menu.removeAttr('style');
		}
	});
});
