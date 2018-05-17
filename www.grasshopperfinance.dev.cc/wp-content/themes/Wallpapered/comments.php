<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 
?>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php echo 'This post is password protected. Enter the password to view any comments.'; ?></p>
	</div>
	<?php
			return;
		endif;
	?>

	<?php ?>

	<?php if ( have_comments() ) : ?>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php echo 'Comment navigation'; ?></h1>
			<div class="nav-previous"><?php previous_comments_link( ( '&larr; Older Comments' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( 'Newer Comments &rarr;' ); ?></div>
		</nav>
		<?php endif; ?>

		<ol class="commentlist">
			<?php
				wp_list_comments( array( 'callback' => 'sgwp_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php echo 'Comment navigation'; ?></h1>
			<div class="nav-previous"><?php previous_comments_link( '&larr; Older Comments' ); ?></div>
			<div class="nav-next"><?php next_comments_link( 'Newer Comments &rarr;' ); ?></div>
		</nav>
		<?php endif; ?>

		<?php
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php echo 'Comments are closed.'; ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div>