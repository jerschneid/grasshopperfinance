<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

		get_template_part( 'template-parts/content', get_post_format() );

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