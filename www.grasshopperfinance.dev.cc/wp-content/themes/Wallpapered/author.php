<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php
					the_post();
				?>

				<header class="page-header">
					<h1 class="page-title author"><?php printf( 'Author Archives: %s', '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
				</header>

				<?php
					rewind_posts();
				?>

				<?php sgwp_content_nav( 'nav-above' ); ?>

				<?php
				if ( get_the_author_meta( 'description' ) ) : ?>
				<div id="author-info">
					<div id="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'sgwp_author_bio_avatar_size', 60 ) ); ?>
					</div>
					<div id="author-description">
						<h2><?php printf( 'About %s', get_the_author() ); ?></h2>
						<?php the_author_meta( 'description' ); ?>
					</div>
				</div>
				<?php endif; ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php sgwp_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php echo 'Nothing Found'; ?></h1>
					</header>

					<div class="entry-content">
						<p><?php echo 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.'; ?></p>
						<?php get_search_form(); ?>
					</div>
				</article>

			<?php endif; ?>

			</div>
		</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>