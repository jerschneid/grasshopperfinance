<?php
/**
 * Sanitization functions.
 *
 * @package ritz
 */

//=============================================================
// Select/radio santitization
//=============================================================
if ( ! function_exists( 'ritz_sanitize_select' ) ) :

	function ritz_sanitize_select( $input, $setting ) {
	  
		// Ensure input is clean.
		$input = sanitize_text_field( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

	}

endif;

//=============================================================
// Checkbox santitization
//=============================================================
if ( ! function_exists( 'ritz_sanitize_checkbox' ) ) :

	function ritz_sanitize_checkbox( $checked ) {

		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}

endif;

//=============================================================
// Positive santitization
//=============================================================
if ( ! function_exists( 'ritz_sanitize_positive_integer' ) ) :

	/**
	 * Sanitize positive integer.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input Number to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized number; otherwise, the setting default.
	 */
	function ritz_sanitize_positive_integer( $input, $setting ) {

		$input = absint( $input );

		// If the input is an absolute integer, return it.
		// otherwise, return the default.
		return ( $input ? $input : $setting->default );

	}

endif;

//=============================================================
// Textarea santitization
//=============================================================
if ( ! function_exists( 'ritz_sanitize_textarea' ) ) :

	/**
	 * Sanitize footer content.
	 *
	 * @since 1.0.0
	 *
	 * @param string               $input Content to be sanitized.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return string Sanitized content.
	 */
	function ritz_sanitize_textarea( $input, $setting ) {

		return wp_kses_post( $input );

	}
endif;

//=============================================================
// Related posts active callback
//=============================================================

if ( ! function_exists( 'ritz_is_related_posts_active' ) ) :

	/**
	 * Check if related posts is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function ritz_is_related_posts_active( $control ) {

		if ( true == $control->manager->get_setting( 'show_related_posts' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;