<?php
/**
 * Ritz functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ritz
 */

if ( ! function_exists( 'ritz_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ritz_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
    
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	* Enable support for editor style.
	*/  
	add_editor_style( 'assets/css/editor-style.css' );

	/*
	* Enable support for custom logo.
	*/  
	add_theme_support( 'custom-logo', array(
		'flex-height' => true,
		'flex-width'  => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'ritz-common', 440, 320, true );


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'ritz' ),
		'social'  => esc_html__( 'Social', 'ritz' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ritz_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}
endif;
add_action( 'after_setup_theme', 'ritz_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ritz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ritz_content_width', 684 );
}
add_action( 'after_setup_theme', 'ritz_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ritz_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ritz' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ritz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Newsletter Section', 'ritz' ),
		'id'            => 'sidebar-newsletter',
		'description'   => esc_html__( 'Add Ritz: Newsletter widgets here.', 'ritz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'ritz' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'ritz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'ritz' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'ritz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'ritz' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'ritz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}

add_action( 'widgets_init', 'ritz_widgets_init' );

if ( ! function_exists( 'ritz_fonts_url' ) ) {
	/**
	 * Register Google fonts.
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function ritz_fonts_url() {
		
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Source Sans Pro, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Source Sans Pro: on or off', 'ritz' ) ) {
			$fonts[] = 'Source Sans Pro:300,300i,400,400i,600,600i,700,700i,900,900i';
		}
		

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
}

/**
 * Enqueue scripts and styles.
 */
function ritz_scripts() {

	wp_enqueue_style( 'meanmenu', get_template_directory_uri() . '/assets/third-party/meanmenu/meanmenu.css' );

	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/third-party/font-awesome/css/font-awesome.min.css');

	wp_enqueue_style( 'ritz-fonts', ritz_fonts_url(), array(), null );

	wp_enqueue_style( 'ritz-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ritz-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20161202', true );

	wp_enqueue_script( 'meanmenu', get_template_directory_uri() . '/assets/third-party/meanmenu/jquery.meanmenu.js', array('jquery'), '20161202', true );

	wp_enqueue_script( 'ritz-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '20161202', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ritz_scripts' );

/**
 * Implement the main files.
 */
require get_template_directory() . '/inc/main.php';

/* Turn on wide images */
add_theme_support( 'align-wide' );