<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header clearfix">
			<?php if ( comments_open() && ! post_password_required() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . '0' . '</span>', '1', '%' ); ?>
			</div>
			<?php endif; ?>
			
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php sgwp_posted_on(); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_sticky() ) : ?>
				<div class="hgroup-block">
					<h3 class="entry-format"><?php echo( 'Featured' ); ?></h3>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( 'Permalink to %s', the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				</div>
			<?php else : ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( 'Permalink to %s', the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<?php endif; ?>
		</header>

		<?php if ( is_search() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
		<?php else : ?>
		<div class="entry-content">
			<?php if( $post->post_excerpt ) : // Show Excerpt if user has defined manualy ?>
				<p class="excstl"><?php echo $post->post_excerpt; ?></p>
			<?php else : ?>
				<?php the_content( 'Continue reading <span class="meta-nav">&rarr;</span>' ); ?>
			<?php endif; ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . 'Pages:' . '</span>', 'after' => '</div>' ) ); ?>
		</div>
		<?php endif; ?>

		<footer class="entry-meta">
			<?php $show_sep = false; ?>
			<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : ?>
			<?php
				$categories_list = get_the_category_list( ', ' );
				if ( $categories_list ):
			?>
			<span class="cat-links">
				<?php printf( '<span class="%1$s">Posted in</span> %2$s', 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
				$show_sep = true; ?>
			</span>
			<?php endif; ?>
			<?php endif; ?>
			<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : ?>
			<?php
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ):
				if ( $show_sep ) : ?>
				<?php endif; ?>
			<span class="tag-links">
				<?php printf( '<span class="%1$s">Tagged</span> %2$s', 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
				$show_sep = true; ?>
			</span>
			<?php endif; ?>
			<?php endif; ?>

			<?php if ( comments_open() ) : ?>
			<?php if ( $show_sep ) : ?>
			<?php endif; ?>
			<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . 'Leave a reply' . '</span>', '<b>1</b> Reply', '<b>%</b> Replies' ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( 'Edit', '<span class="edit-link">', '</span>' ); ?>
		</footer>
	</article><!-- #post-<?php the_ID(); ?> -->
