(function($) {
	$(document).ready( function() {
	    $('.feature-slider a').click(function(e) {
	        $('.featured-posts section.featured-post').css({
	            opacity: 0,
	            display: 'none'
	        });
	        $(this.hash).css({
	            opacity: 1,
	            display: 'block'
	        });
	        $('.feature-slider a').removeClass('active');
	        $(this).addClass('active');
	        e.preventDefault();
	    });
	});
})(jQuery);