<?php
/**
 * Core functions.
 *
 * @package Ritz
 */

if ( ! function_exists( 'ritz_get_option' ) ) :

	/**
	 * Get theme option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function ritz_get_option( $key ) {

		if ( empty( $key ) ) {
			return;
		}

		$value = '';

		$default = ritz_get_default_theme_options();

		$default_value = null;

		if ( is_array( $default ) && isset( $default[ $key ] ) ) {
			$default_value = $default[ $key ];
		}

		if ( null !== $default_value ) {
			$value = get_theme_mod( $key, $default_value );
		}
		else {
			$value = get_theme_mod( $key );
		}

		return $value;

	}

endif;

if ( ! function_exists( 'ritz_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function ritz_get_default_theme_options() {

		$defaults = array();

		//Header
		$defaults['site_identity'] 			= 'title-text';
		$defaults['social_icon'] 			= 0;

		// Blog
		$defaults['excerpt_length'] 		= 20;
		$defaults['read_more'] 				= esc_html__( 'Read More', 'ritz' );
		$defaults['category_meta']         	= 0;
		$defaults['post_author']         	= 0;
		$defaults['post_date']         		= 0;
		$defaults['archive_prefix']         = 1;
		$defaults['show_related_posts']     = 1;
		$defaults['related_posts'] 			= esc_html__( 'Related Posts', 'ritz' );
		$defaults['related_post_number'] 	= 3;
		

		// Footer.
		$defaults['copyright'] 				= esc_html__( 'Copyright &copy; All rights reserved.', 'ritz' );
		$defaults['social_icon_footer']     = 0;

		//Scroll Up
		$defaults['enable_scrollup'] 		= 0;

		return $defaults;
	}

endif;

//=============================================================
// Get all options in array
//=============================================================
if ( ! function_exists( 'ritz_get_options' ) ) :

    /**
     * Get all theme options in array.
     *
     * @since 1.0.0
     *
     * @return array Theme options.
     */
    function ritz_get_options() {

        $value = array();

        $value = get_theme_mods();

        return $value;

    }

endif;