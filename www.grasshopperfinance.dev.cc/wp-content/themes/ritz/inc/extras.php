<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ritz
 */

//=============================================================
// Function to change default excerpt
//=============================================================
if ( ! function_exists( 'ritz_excerpt' ) ) :

	function ritz_excerpt( $more ) {

		if( is_admin() ){

			return $more;

		}

	    return '&hellip;';

	}

endif;
add_filter( 'excerpt_more', 'ritz_excerpt' );

//=============================================================
// Function to change length of excerpt
//=============================================================
if ( ! function_exists( 'ritz_implement_excerpt_length' ) ) :

	function ritz_implement_excerpt_length( $length ) {

		if( is_admin() ){

			return $length;
			
		}

		$excerpt = ritz_get_option( 'excerpt_length' );

		$excerpt_length = (!empty( $excerpt )) ? $excerpt : 20;

	    return absint($excerpt_length);
	}

endif;

if ( ! function_exists( 'ritz_content_more_link' ) ) :

	/**
	 * Implement read more in content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more_link Read More link element.
	 * @param string $more_link_text Read More text.
	 * @return string Link.
	 */
	function ritz_content_more_link( $more_link, $more_link_text ) {

		$read_more_text = ritz_get_option( 'read_more' );

		if ( ! empty( $read_more_text ) ) {

			$more_link = str_replace( $more_link_text, esc_html( $read_more_text ), $more_link );

		}

		return $more_link;

	}

endif;

if ( ! function_exists( 'ritz_implement_read_more' ) ) :

	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function ritz_implement_read_more( $more ) {

		$output = $more;

		$read_more_text = ritz_get_option( 'read_more' );

		if ( ! empty( $read_more_text ) ) {

			$output = '&hellip;<p><a href="' . esc_url( get_permalink() ) . '" class="btn-continue">' . esc_html( $read_more_text ) . '<span class="arrow-continue">&rarr;</span></a></p>';

		}

		return $output;

	}

endif;

if ( ! function_exists( 'ritz_hook_read_more_filters' ) ) :

	/**
	 * Hook read more and excerpt length filters.
	 *
	 * @since 1.0.0
	 */
	function ritz_hook_read_more_filters() {

		if ( is_home() || is_category() || is_tag() || is_author() || is_date() || is_search() ) {

			add_filter( 'excerpt_length', 'ritz_implement_excerpt_length', 999 );
			add_filter( 'the_content_more_link', 'ritz_content_more_link', 10, 2 );
			add_filter( 'excerpt_more', 'ritz_implement_read_more' );

		}

	}
endif;
add_action( 'wp', 'ritz_hook_read_more_filters' );

//=============================================================
// Menu Fallback function
//=============================================================

if ( !function_exists('ritz_menu_fallback') ) :

function ritz_menu_fallback(){

	echo '<ul id="menu-main-menu" class="menu">';
		echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'ritz' ). '</a></li>';
		wp_list_pages( array(
			'title_li' => '',
			'depth'    => 1,
			'number'   => 5,
		) );
		echo '</ul>';
	
}

endif;

//=============================================================
// Alter body class function
//=============================================================

function ritz_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$sticky = ritz_get_option( 'sticky' ); 

	if( 1 != $sticky ){
		$classes[] = 'sticky-top';
	}
   	
	return $classes;
}

add_filter( 'body_class', 'ritz_body_classes' );

//=============================================================
// Pingback function
//=============================================================
function ritz_pingback_header() {

	if ( is_singular() && pings_open() ) {

		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';

	}
	
}

add_action( 'wp_head', 'ritz_pingback_header' );

if ( ! function_exists( 'ritz_footer_goto_top' ) ) :

	/**
	 * Add Go to top.
	 *
	 * @since 1.0.0
	 */
	function ritz_footer_goto_top() {

		$enable_scrollup = ritz_get_option( 'enable_scrollup' ); 

		if( 1 != $enable_scrollup ){

			echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-angle-up"></i></a>';

		}
	}
endif;
add_action( 'wp_footer', 'ritz_footer_goto_top' );

//=============================================================
// Hide archive page prefix
//=============================================================
if( ! function_exists( 'ritz_archive_prefix_change' ) ):

	 function ritz_archive_prefix_change( $title ) {

	 	$archive_prefix = ritz_get_option( 'archive_prefix' );

	 	if( 1 === absint( $archive_prefix ) ){

	 		if ( is_category() ) {

	 		    $title = single_cat_title( '', false );

	 		} elseif ( is_tag() ) {

	 		    $title = single_tag_title( '', false );

	 		} elseif ( is_author() ) {

	 		    $title = '<span class="vcard">' . get_the_author() . '</span>';

	 		} elseif ( is_post_type_archive() ) {

	 		    $title = post_type_archive_title( '', false );

	 		} elseif ( is_tax() ) {

	 		    $title = single_term_title( '', false );

	 		}

	 	}

	 	return $title;

	 }

endif;

add_filter( 'get_the_archive_title', 'ritz_archive_prefix_change');