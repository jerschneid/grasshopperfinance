<?php
function my_theme_enqueue_styles() {

    $parent_style = 'ritz-style'; // This is 'ritz-style' for the ritz theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

function load_scripts() {
    global $post;

    if( is_page() || is_single() )
    {
        switch($post->post_name) // post_name is the post slug which is more consistent for matching to here
        {
            case 'investment-growth-and-net-worth-calculator':
                wp_enqueue_script('home', get_stylesheet_directory_uri() . '/js/growthcalculator.js', array('jquery'), '', false);
                break;
        }
    }
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
add_action('wp_enqueue_scripts', 'load_scripts');


?>
