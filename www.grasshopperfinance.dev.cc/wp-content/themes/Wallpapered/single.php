<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<nav id="nav-single">
						<h3 class="assistive-text"><?php echo 'Post navigation'; ?></h3>
						<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> Previous' ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', 'Next <span class="meta-nav">&rarr;</span>' ); ?></span>
					</nav>

					<?php get_template_part( 'content-single', get_post_format() ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; ?>

			</div>
		</div>

<?php get_footer(); ?>