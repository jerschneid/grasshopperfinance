<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ritz
 */

get_header(); 
	/**
	 * Hook - ritz_before_primary.
	 *
	 * @hooked ritz_before_primary_action - 10
	 */
	do_action( 'ritz_before_primary' );
?>

	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; ?>

<?php
	/**
	 * Hook - ritz_after_primary.
	 *
	 * @hooked ritz_after_primary_action - 10
	 */
	do_action( 'ritz_after_primary' );

get_footer();