<?php
/**
 * Template Name: Showcase Template
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 


wp_enqueue_script( 'sgwp-showcase', get_template_directory_uri() . '/js/showcase.js', array( 'jquery' ) );

get_header(); ?>

		<div id="primary" class="showcase">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

				<?php
					if ( '' != get_the_content() )
						get_template_part( 'content', 'intro' );
				?>

				<?php endwhile; ?>

				<?php
				$sticky = get_option( 'sticky_posts' );

				if ( ! empty( $sticky ) ) :

				$featured_args = array(
					'post__in' => $sticky,
					'post_status' => 'publish',
					'posts_per_page' => 10,
					'no_found_rows' => true,
				);

				$featured = new WP_Query( $featured_args );

				if ( $featured->have_posts() ) :

				$counter_slider = 0;

				if ( function_exists( 'get_custom_header' ) ) {
					$header_image_width = get_theme_support( 'custom-header', 'width' );
				} else {
					$header_image_width = HEADER_IMAGE_WIDTH;
				}
				?>
				
				<?php
				if ( $featured->post_count > 1 ) :
				?>
					<nav class="feature-slider">
						<ul>
						<?php
	
					    	$counter_slider = 0;
	
					    	rewind_posts();
	
					    	while ( $featured->have_posts() ) : $featured->the_post();
					    		$counter_slider++;
								if ( 1 == $counter_slider )
									$class = 'class="active"';
								else
									$class = '';
					    	?>
							<li><a href="#featured-post-<?php echo $counter_slider; ?>" title="<?php echo esc_attr( sprintf( 'Featuring: %s', the_title_attribute( 'echo=0' ) ) ); ?>" <?php echo $class; ?>><?php the_title(); ?></a></li>
						<?php endwhile;	?>
						</ul>
					</nav>
				<?php endif; ?>

				<div class="featured-posts">
					<h1 class="showcase-heading"><?php echo 'Featured Post'; ?></h1>

				<?php
					while ( $featured->have_posts() ) : $featured->the_post();

					$counter_slider++;

					$feature_class = 'feature-text';

					if ( has_post_thumbnail() ) {
						$feature_class = 'feature-image small';

						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( $header_image_width, $header_image_width ) );

						if ( $image[1] >= $header_image_width ) {
							$feature_class = 'feature-image large';
						}
					}
					?>

					<section class="featured-post <?php echo $feature_class; ?>" id="featured-post-<?php echo $counter_slider; ?>">

						<?php
							if ( has_post_thumbnail() ) {
								if ( $image[1] >= $header_image_width )
									$thumbnail_size = 'large-feature';
								else
									$thumbnail_size = 'small-feature';
								?>
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( 'Permalink to %s', the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( $thumbnail_size ); ?></a>
								<?php
							}
						?>
						<?php get_template_part( 'content', 'featured' ); ?>
					</section>
				<?php endwhile;	?>

				
				</div>
				<?php endif; ?>
				<?php endif; ?>


			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar( 'showcase' ); ?>
<?php get_footer(); ?>