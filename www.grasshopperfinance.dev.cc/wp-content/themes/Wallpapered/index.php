<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php sgwp_content_nav( 'nav-above' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

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
		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>