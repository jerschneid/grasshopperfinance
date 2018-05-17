<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ritz
 */

	/**
	 * Hook - ritz_after_content.
	 *
	 * @hooked ritz_after_content_action - 10
	 */
	do_action( 'ritz_after_content' );

	/**
	 * Hook - ritz_newsletter.
	 *
	 * @hooked ritz_newsletter_action - 10
	 */
	do_action( 'ritz_newsletter' );

?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php 

		/**
		* Hook - ritz_footer_widgets.
		*
		* @hooked ritz_footer_widgets_action - 10
		*/
		do_action( 'ritz_footer_widgets' );

		/**
		* Hook - ritz_before_footer_info.
		*
		* @hooked ritz_before_footer_info_action - 10
		*/
		do_action( 'ritz_before_footer_info' );

		/**
		* Hook - ritz_bottom_footer.
		*
		* @hooked rritz_bottom_footer_action - 10
		*/
		do_action( 'ritz_bottom_footer' );

		/**
		* Hook - ritz_after_footer_info.
		*
		* @hooked ritz_after_footer_info_action - 10
		*/
		do_action( 'ritz_after_footer_info' );
		?>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>