<?php
function my_theme_enqueue_styles() {

    $parent_style = 'wp-bootstrap-4-style'; // This is 'ritz-style' for the ritz theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( "grasshopper-style", "/wp-includes/grasshopper/css/grasshopper.css");

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
        switch($post->post_name) // post_name is the post slug which is more consistent for matching to here
        {
            default:

                //These three scripts make react happen
                wp_enqueue_script('babel-standalone', 'https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js', null, '6.26.0', false);

                //Todo: Find a better way to include production versions on live site
                if(WP_ENV == "development")
                {
                    wp_enqueue_script('react', 'https://unpkg.com/react@16/umd/react.development.js', array('babel-standalone'), '16', false);
                    wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', array('react'), '16', false);

                }
                else
                {
                    wp_enqueue_script('react', 'https://unpkg.com/react@16/umd/react.production.min.js', array('babel-standalone'), '16', false);            
                    wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array('react'), '16', false);
                }                

                //This is for ajax
                wp_enqueue_script('axios', 'https://unpkg.com/axios/dist/axios.min.js', null, '6.26.0', false);                

                break;
        }
    }
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles' );
add_action('wp_enqueue_scripts', 'load_scripts');


add_filter( 'wp_nav_menu_items','add_search_box', 10, 2 );
function add_search_box( $items, $args ) 
{
 
    $newmenu =  
    '<li id="followlinks">
        <span>Follow us:</span>
        <a href="https://www.instagram.com/personalfinanceclub">
            <img src="/wp-includes/grasshopper/img/instagram.png" />
        </a>
        <a href="https://www.facebook.com/personalfinanceclub">
            <img src="/wp-includes/grasshopper/img/facebook.png" />
        </a>
    </li>'
        + $items;

    return $newmenu;
}

?>
