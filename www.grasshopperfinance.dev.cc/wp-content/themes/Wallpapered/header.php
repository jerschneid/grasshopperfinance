<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
	<header id="branding" class="clearfix" role="banner">
		<div class="main-nav">
			<nav id="access" class="wid960" role="navigation">
				<h3 class="assistive-text"><?php echo( 'Main menu' ); ?></h3>
				<?php ?>
				<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr( 'Skip to primary content' ); ?>"><?php echo 'Skip to primary content'; ?></a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr( 'Skip to secondary content' ); ?>"><?php echo 'Skip to secondary content'; ?></a></div>
				<?php ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					<?php
						if ( 'blank' == get_header_textcolor() ) :
						$custom_header = get_custom_header();
					?>
					<div class="only-search<?php if ( ! empty( $custom_header ) ) : ?> with-image<?php endif; ?>">
						<?php get_search_form(); ?>
					</div>
					<?php
						else :
					?>
					<?php get_search_form(); ?>
				<?php endif; ?>
			<div class="clr"></div>
			</nav>
		</div>
		<div class="wid960 slider">	
			<a class="standart-image" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/standard-header.png" alt="" /></a>
			<?php
				$header_image = get_header_image();
				if ( $header_image ) :
					if ( function_exists( 'get_custom_header' ) ) {
						$header_image_width = get_theme_support( 'custom-header', 'width' );
					} else {
						$header_image_width = HEADER_IMAGE_WIDTH;
					}
					?>
				<a class="slider-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php
					if ( is_singular() && has_post_thumbnail( $post->ID ) &&
							( $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( $header_image_width, $header_image_width ) ) ) &&
							$image[1] >= $header_image_width ) :
						echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
					else :
						if ( function_exists( 'get_custom_header' ) ) {
							$header_image_width  = get_custom_header()->width;
							$header_image_height = get_custom_header()->height;
						} else {
							$header_image_width  = HEADER_IMAGE_WIDTH;
							$header_image_height = HEADER_IMAGE_HEIGHT;
						}
						?>
					<img src="<?php header_image(); ?>" width="<?php echo $header_image_width; ?>" height="<?php echo $header_image_height; ?>" alt="" />
				<?php endif; ?>
				<span class="slider-image-leftgradient"></span>
				<span class="slider-image-rightgradient"></span>
			</a>
			<?php endif; ?>
			<div class="title-wrap">
				<h1 id="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="aligncenter"><?php bloginfo( 'name' ); ?></a>
					<span id="site-description" class="aligncenter"><?php bloginfo( 'description' ); ?></span>
				</h1>
			</div>
		</div>
	</header>
	
	<div id="main" class="wid960 clearfix">

