jQuery(document).ready(function ($) {

    $('#main-nav').meanmenu({
    	meanMenuContainer: '.bottom-header',
        meanScreenWidth:"991"
    }); 

    // Go to top.
    var $scroll_obj = $( '#btn-scrollup' );
    $( window ).scroll(function(){
    	if ( $( this ).scrollTop() > 100 ) {
    		$scroll_obj.fadeIn();
    	} else {
    		$scroll_obj.fadeOut();
    	}
    });

    $scroll_obj.click(function(){
    	$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
    	return false;
    });  

});

