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
        //TODO: Maybe include react based on tag name or something?
        //TODO: Make these case statements correct
        switch($post->post_name) // post_name is the post slug which is more consistent for matching to here
        {
            case 'investment-growth-and-net-worth-calculator':
            default:

                //These three scripts make react happen
                wp_enqueue_script('babel-standalone', 'https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js', null, '6.26.0', false);                

                //Todo: Find a better way to include production versions on live site
//                wp_enqueue_script('react', 'https://unpkg.com/react@16/umd/react.production.min.js', array('babel-standalone'), '16', false);                
//                wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array('react'), '16', false);                

                wp_enqueue_script('react', 'https://unpkg.com/react@16/umd/react.development.js', array('babel-standalone'), '16', false);                
                wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', array('react'), '16', false);                



                wp_enqueue_script('growthcalculator', get_stylesheet_directory_uri() . '/js/growthcalculator.js', null, array('react-dom'), false);
                break;
        }
    }
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles' );
add_action('wp_enqueue_scripts', 'load_scripts');


?>
