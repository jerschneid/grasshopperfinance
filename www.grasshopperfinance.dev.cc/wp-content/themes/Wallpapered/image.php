<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 


get_header(); ?>

		<div id="primary" class="image-attachment">
			<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<nav id="nav-single">
					<h3 class="assistive-text">Image navigation</h3>
					<span class="nav-previous"><?php previous_image_link( false, '&larr; Previous' ); ?></span>
					<span class="nav-next"><?php next_image_link( false, 'Next &rarr;' ); ?></span>
				</nav>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>

							<div class="entry-meta">
								<?php
									$metadata = wp_get_attachment_metadata();
									printf( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>',
										esc_attr( get_the_time() ),
										get_the_date(),
										esc_url( wp_get_attachment_url() ),
										$metadata['width'],
										$metadata['height'],
										esc_url( get_permalink( $post->post_parent ) ),
										esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
										get_the_title( $post->post_parent )
									);
								?>
								<?php edit_post_link( 'Edit', '<span class="edit-link">', '</span>' ); ?>
							</div>

						</header>

						<div class="entry-content">

							<div class="entry-attachment">
								<div class="attachment">
<?php
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		$next_attachment_url = wp_get_attachment_url();
	}
?>
									<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
									$attachment_size = apply_filters( 'sgwp_attachment_size', 848 );
									echo wp_get_attachment_image( $post->ID, array( $attachment_size, 1024 ) ); 
									?></a>

									<?php if ( ! empty( $post->post_excerpt ) ) : ?>
									<div class="entry-caption">
										<?php the_excerpt(); ?>
									</div>
									<?php endif; ?>
								</div>

							</div>

							<div class="entry-description">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . 'Pages:' . '</span>', 'after' => '</div>' ) ); ?>
							</div>

						</div>

					</article><!-- #post-<?php the_ID(); ?> -->

					<?php comments_template(); ?>

				<?php endwhile; // end of the loop. ?>

			</div>
		</div>

<?php get_footer(); ?>