<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 

if ( ! isset( $content_width ) )
	$content_width = 584;

add_action( 'after_setup_theme', 'sgwp_setup' );

if ( ! function_exists( 'sgwp_setup' ) ):

function sgwp_setup() {

	add_editor_style();

	add_theme_support( 'automatic-feed-links' );

	register_nav_menu( 'primary', 'Primary Menu' );
	
	add_theme_support( 'custom-background' );

	add_theme_support( 'post-thumbnails' );

	$custom_header_support = array(
		'default-text-color' => '000',
		'width' => apply_filters( 'sgwp_header_image_width', 1000 ),
		'height' => apply_filters( 'sgwp_header_image_height', 330 ),
		'flex-height' => true,
		'wp-head-callback' => 'sgwp_header_style',
		'admin-head-callback' => 'sgwp_admin_header_style',
		'admin-preview-callback' => 'sgwp_admin_header_image',
	);

	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		
	}

	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	
	add_image_size( 'small-feature', 500, 300 );

}
endif; 

if ( ! function_exists( 'sgwp_header_style' ) ) :

function sgwp_header_style() {
	$text_color = get_header_textcolor();

	if ( $text_color == HEADER_TEXTCOLOR )
		return;

	?>
	<style type="text/css">
	<?php
		if ( 'blank' == $text_color ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; 

if ( ! function_exists( 'sgwp_admin_header_style' ) ) :

function sgwp_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif;

if ( ! function_exists( 'sgwp_admin_header_image' ) ) :

function sgwp_admin_header_image() { ?>
	<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	<div id="headimg">
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else
			$style = ' style="display:none"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php }
endif; 

function sgwp_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'sgwp_excerpt_length' );

if ( ! function_exists( 'sgwp_continue_reading_link' ) ) :

function sgwp_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . 'Continue reading <span class="meta-nav">&rarr;</span>' . '</a>';
}
endif; 

function sgwp_auto_excerpt_more( $more ) {
	return ' &hellip;' . sgwp_continue_reading_link();
}
add_filter( 'excerpt_more', 'sgwp_auto_excerpt_more' );

function sgwp_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= sgwp_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'sgwp_custom_excerpt_more' );

function sgwp_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'sgwp_page_menu_args' );

function sgwp_widgets_init() {

	register_sidebar( array(
		'name' => 'Main Sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Showcase Sidebar',
		'id' => 'sidebar-2',
		'description' => 'The sidebar for the optional Showcase Template',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Footer Area One',
		'id' => 'sidebar-3',
		'description' => 'An optional widget area for your site footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Footer Area Two',
		'id' => 'sidebar-4',
		'description' => 'An optional widget area for your site footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Footer Area Three',
		'id' => 'sidebar-5',
		'description' => 'An optional widget area for your site footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'sgwp_widgets_init' );

if ( ! function_exists( 'sgwp_content_nav' ) ) :

function sgwp_content_nav( $html_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo esc_attr( $html_id ); ?>">
			<h3 class="assistive-text">Post navigation</h3>
			<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older posts' ); ?></div>
			<div class="nav-next"><?php previous_posts_link( 'Newer posts <span class="meta-nav">&rarr;</span>' ); ?></div>
		</nav>
	<?php endif;
}
endif; 

function sgwp_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

function sgwp_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'sgwp_comment' ) ) :

function sgwp_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php echo 'Pingback:'; ?> <?php comment_author_link(); ?><?php edit_comment_link( 'Edit', '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<h2 id="comments-title">
				<?php
					printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'sgwp' ),
						number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				?>
			</h2>
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						printf( '%1$s on %2$s <span class="says">said:</span>',
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( '%1$s at %2$s', get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( 'Edit', '<span class="edit-link">', '</span>' ); ?>
				</div>

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php echo 'Your comment is awaiting moderation.'; ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'Reply <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		</article>

	<?php
			break;
	endswitch;
}
endif;

if ( ! function_exists( 'sgwp_posted_on' ) ) :

function sgwp_posted_on() {
	printf( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( 'View all posts by %s', get_the_author() ) ),
		get_the_author()
	);
}
endif;

function sgwp_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'sgwp_body_classes' );

function sgwp_enqueue_scripts_styles() {
	wp_enqueue_style( 'sgwp-style', get_stylesheet_uri() );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}

add_action( 'wp_enqueue_scripts', 'sgwp_enqueue_scripts_styles' );

function sgwp_head_title( $title, $sep ) {
	global $page, $paged;

	$out = $title;

	// Add the blog name.
	$out .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$out .= " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$out .= ' | ' . sprintf( 'Page %s', max( $paged, $page ) );

	return $out;
}

add_filter( 'wp_title', 'sgwp_head_title', 10, 2 );