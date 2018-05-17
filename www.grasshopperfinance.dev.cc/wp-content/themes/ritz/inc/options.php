<?php
/**
 * Options.
 *
 * @package Ritz
 */

global $ritz_google_fonts;

$default = ritz_get_default_theme_options();

//Logo Options Setting Starts
$wp_customize->add_setting('site_identity', array(
	'default' 			=> $default['site_identity'],
	'sanitize_callback' => 'ritz_sanitize_select'
	));

$wp_customize->add_control('site_identity', array(
	'type' 		=> 'radio',
	'label' 	=> esc_html__('Show', 'ritz'),
	'section' 	=> 'title_tagline',
	'choices' 	=> array(
		'logo-only' 	=> esc_html__('Logo Only', 'ritz'),
		'title-text' 	=> esc_html__('Title + Tagline', 'ritz'),
		)
));

// Option Panel
$wp_customize->add_panel(
	'basic_panel', 
	array(
		'title'				=> esc_html__('Theme Options', 'ritz'),
		'priority' 			=> 90		
		)
);

// Header Section
$wp_customize->add_section(
	'header', 
	array(    
		'title'       => esc_html__('Header Options', 'ritz'),
		'panel'       => 'basic_panel'    
	)
);

$wp_customize->add_setting(
	'social_icon', 
	array(
		'default'           => $default['social_icon'],			
		'sanitize_callback' => 'ritz_sanitize_checkbox'
	)
);

$wp_customize->add_control(
	'social_icon', 
	array(
		'label'       => esc_html__('Show Social Icons', 'ritz'),
		'description' => esc_html__('Please create menu and assign it to Social Menu Location.', 'ritz'),
		'section'     => 'header',   
		'settings'    => 'social_icon',		
		'type'        => 'checkbox'
	)
);

// Post Options Section
$wp_customize->add_section(
	'post_options', 
	array(    
		'title'       => esc_html__('Post Options', 'ritz'),
		'panel'       => 'basic_panel'    
	)
);

$wp_customize->add_setting(
	'excerpt_length', 
	array(
		'default' 			=> $default['excerpt_length'],		
		'sanitize_callback' => 'ritz_sanitize_positive_integer'
	)
);

$wp_customize->add_control(
	'excerpt_length', 
	array(		
		'label' 		=> esc_html__('Excerpt Length', 'ritz'),
		'description' 	=> esc_html__( 'Select number of words to display in excerpt', 'ritz' ),
		'section' 		=> 'post_options',
		'settings'  	=> 'excerpt_length',
		'type'      	=> 'number',
		'input_attrs' 	=> array(
								'min' 	=> 20,		
								'max' 	=> 410,
								'step'  => 1
							),			
	)
);

$wp_customize->add_setting(
	'read_more', 
	array(
		'default' 			=>  $default['read_more'],
		'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control(
	'read_more', 
	array(
		'label'       => esc_html__('Read More Text', 'ritz'),
		'settings'    => 'read_more',
		'section'     => 'post_options',
		'type'        => 'text'
	)
);

// Setting category_meta.
$wp_customize->add_setting( 
	'category_meta',
	array(
		'default'           => $default['category_meta'],
		'sanitize_callback' => 'ritz_sanitize_checkbox',
	)
);
$wp_customize->add_control( 
	'category_meta',
	array(
		'label'    		=> esc_html__( 'Hide category meta', 'ritz' ),
		'section'  		=> 'post_options',
		'type'     		=> 'checkbox',
	)
);

// Setting post_author.
$wp_customize->add_setting( 
	'post_author',
	array(
		'default'           => $default['post_author'],
		'sanitize_callback' => 'ritz_sanitize_checkbox',
	)
);
$wp_customize->add_control( 
	'post_author',
	array(
		'label'    		=> esc_html__( 'Hide Author', 'ritz' ),
		'section'  		=> 'post_options',
		'type'     		=> 'checkbox',
	)
);

// Setting post_date.
$wp_customize->add_setting( 
	'post_date',
	array(
		'default'           => $default['post_date'],
		'sanitize_callback' => 'ritz_sanitize_checkbox',
	)
);
$wp_customize->add_control( 
	'post_date',
	array(
		'label'    		=> esc_html__( 'Hide Date', 'ritz' ),
		'section'  		=> 'post_options',
		'type'     		=> 'checkbox',
	)
);

// Setting archive_prefix.
$wp_customize->add_setting( 
	'archive_prefix',
	array(
		'default'           => $default['archive_prefix'],
		'sanitize_callback' => 'ritz_sanitize_checkbox',
	)
);
$wp_customize->add_control( 
	'archive_prefix',
	array(
		'label'    => esc_html__( 'Hide prefix in archive pages', 'ritz' ),
		'section'  => 'post_options',
		'type'     => 'checkbox',
	)
);

// Setting show_related_posts.
$wp_customize->add_setting( 
	'show_related_posts',
	array(
		'default'           => $default['show_related_posts'],
		'sanitize_callback' => 'ritz_sanitize_checkbox',
	)
);
$wp_customize->add_control( 
	'show_related_posts',
	array(
		'label'    => esc_html__( 'Show Related Posts', 'ritz' ),
		'section'  => 'post_options',
		'type'     => 'checkbox',
	)
);

// Setting related_posts_title
$wp_customize->add_setting(
	'related_posts', 
	array(
		'default' 			=>  $default['related_posts'],
		'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control(
	'related_posts', 
	array(
		'label'       => esc_html__('Related Posts Title', 'ritz'),
		'settings'    => 'related_posts',
		'section'     => 'post_options',
		'type'        => 'text',
		'active_callback' 	=> 'ritz_is_related_posts_active',
	)
);

// Setting related_post_number
$wp_customize->add_setting(
	'related_post_number', 
	array(
		'default' 			=> $default['related_post_number'],		
		'sanitize_callback' => 'ritz_sanitize_positive_integer'
	)
);

$wp_customize->add_control(
	'related_post_number', 
	array(		
		'label' 		=> esc_html__('Related posts number', 'ritz'),
		'description' 	=> esc_html__( 'You can display 3,6 or 9 related posts', 'ritz' ),
		'section' 		=> 'post_options',
		'settings'  	=> 'related_post_number',
		'type'      	=> 'number',
		'input_attrs' 	=> array(
								'min' 	=> 3,		
								'max' 	=> 9,
								'step'  => 3
							),
		'active_callback' 	=> 'ritz_is_related_posts_active',			
	)
);

// Footer Section
$wp_customize->add_section(
	'footer', 
	array(    
		'title'       => esc_html__('Footer Options', 'ritz'),
		'panel'       => 'basic_panel'    
	)
);

$wp_customize->add_setting(
	'copyright', 
	array(
		'default' 			=>  $default['copyright'],
		'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control(
	'copyright', 
	array(
		'label'       => esc_html__('Copyright Text', 'ritz'),
		'description' => esc_html__('Copyright text of the site', 'ritz'),
		'settings'    => 'copyright',
		'section'     => 'footer',
		'type'        => 'text'
	)
);

$wp_customize->add_setting(
	'social_icon_footer', 
	array(
		'default'           => $default['social_icon_footer'],			
		'sanitize_callback' => 'ritz_sanitize_checkbox'
	)
);

$wp_customize->add_control(
	'social_icon_footer', 
	array(
		'label'       => esc_html__('Show Social Icons', 'ritz'),
		'section'     => 'footer',   
		'settings'    => 'social_icon_footer',		
		'type'        => 'checkbox'
	)
);

// ScrollUp Section
$wp_customize->add_section(
	'scrollup', 
	array(    
		'title'       => esc_html__('Scroll Up Options', 'ritz'),
		'panel'       => 'basic_panel'    
	)
);

$wp_customize->add_setting(
	'enable_scrollup', 
	array(
		'default'           => $default['enable_scrollup'],			
		'sanitize_callback' => 'ritz_sanitize_checkbox'
	)
);

$wp_customize->add_control(
	'enable_scrollup', 
	array(
		'label'       => esc_html__('Disable Scroll Up', 'ritz'),
		'section'     => 'scrollup',   
		'settings'    => 'enable_scrollup',		
		'type'        => 'checkbox'
	)
);