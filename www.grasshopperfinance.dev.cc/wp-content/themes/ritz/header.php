<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ritz
 */

?>
<?php
	/**
	 * Hook - ritz_doctype.
	 *
	 * @hooked ritz_doctype_action - 10
	 */
	do_action( 'ritz_doctype' );
?>
<head>
<?php
	/**
	 * Hook - ritz_head.
	 *
	 * @hooked ritz_head_action - 10
	 */
	do_action( 'ritz_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<?php
		/**
		* Hook - ritz_before_header.
		*
		* @hooked ritz_before_header_action - 10
		*/
		do_action( 'ritz_before_header' );

		/**
		* Hook - ritz_site_branding.
		*
		* @hooked ritz_site_branding_action - 10
		*/
		do_action( 'ritz_site_branding' );

		/**
		* Hook - ritz_header.
		*
		* @hooked ritz_header_action - 10
		*/
		do_action( 'ritz_header' );

		/**
		* Hook - ritz_after_header.
		*
		* @hooked ritz_after_header_action - 10
		*/
		do_action( 'ritz_after_header' );

		/**
		* Hook - ritz_before_content.
		*
		* @hooked ritz_before_content_action - 10
		*/
		do_action( 'ritz_before_content' );