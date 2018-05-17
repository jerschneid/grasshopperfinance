<?php
/**
 * Load hooks.
 *
 * @package Ritz
 */
/** Hookes Used
 *
 * ritz_doctype
 * ritz_head
 * ritz_before_header  
 * ritz_header 
 * ritz_after_header 
 * ritz_site_branding
 * ritz_before_content
 * ritz_after_content
 * ritz_footer_widgets
 * ritz_social_menu 
 * ritz_before_footer_info_action
 * ritz_copyright 
 * ritz_credit
 * ritz_after_footer_info_action
 * ritz_before_primary
 * ritz_after_primary
 * ritz_before_secondary
 * ritz_after_secondary
 */

//=============================================================
// Doctype hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_doctype_action' ) ) :
    /**
     * Doctype declaration of the theme.
     *
     * @since 1.0.0
     */
    function ritz_doctype_action() {
    ?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
    }
endif;

add_action( 'ritz_doctype', 'ritz_doctype_action', 10 );

//=============================================================
// Head hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_head_action' ) ) :
    /**
     * Header hook of the theme.
     *
     * @since 1.0.0
     */
    function ritz_head_action() {
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
    }
endif;

add_action( 'ritz_head', 'ritz_head_action', 10 );

//=============================================================
// Before header hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_before_header_action' ) ) :
    /**
     * Header Start.
     *
     * @since 1.0.0
     */
    function ritz_before_header_action() {

        ?><header id="masthead" class="site-header" role="banner"><?php
    }
endif;

add_action( 'ritz_before_header', 'ritz_before_header_action' );

//=============================================================
// Header main hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_header_action' ) ) :

    /**
     * Site Header.
     *
     * @since 1.0.0
     */
    function ritz_header_action() { ?>

        <div class="bottom-header">
            <div class="container">
                <div class="main-menu-holder">

                    <div id="main-nav" class="navigation-holder">
                        <nav id="site-navigation" class="main-navigation" role="navigation">
                            <?php 
                            wp_nav_menu( 
                                array( 
                                    'theme_location'    => 'primary', 
                                    'menu_id'           => 'primary-menu', 
                                    'fallback_cb'       => 'ritz_menu_fallback' 
                                ) 
                            ); 
                            ?>
                        </nav>
                    </div>

                    <?php 

                    $top_social = ritz_get_option('social_icon'); 

                    if( 1 == $top_social ){ ?>

                        <div class="top-social-links social-menu-wrap">   
                            <?php 

                            /**
                            * Hook - ritz_social_menu.
                            *
                            * @hooked ritz_social_menu_action - 10
                            */
                            do_action( 'ritz_social_menu' );
                            ?>
                        </div>

                    <?php } ?>

                </div>
                
            </div>
        </div>
        <?php
    }

endif;

add_action( 'ritz_header', 'ritz_header_action' );

//=============================================================
// After header hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_after_header_action' ) ) :
    /**
     * Header End.
     *
     * @since 1.0.0
     */
    function ritz_after_header_action() {
       
    ?></header><!-- #masthead --><?php
    }
endif;
add_action( 'ritz_after_header', 'ritz_after_header_action' );

//=============================================================
// Site branding hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_site_branding_action' ) ) :
    /**
     * Site branding.
     *
     * @since 1.0.0
     */
    function ritz_site_branding_action() { ?>

        <div class="top-header">
            <div class="container">
                <div class="row">
                    
                    <div class="site-branding">
                        <?php
                        $logo_option = ritz_get_option('site_identity');

                        if( 'logo-only' == $logo_option && function_exists( 'the_custom_logo' ) ){  

                            the_custom_logo(); 

                        }elseif( 'logo-title' == $logo_option ){

                            if ( function_exists( 'the_custom_logo' ) ) {
                                the_custom_logo();
                            } ?>

                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

                            <?php

                            $description = get_bloginfo( 'description', 'display' );

                            if ( $description || is_customize_preview() ) : ?>

                                <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>

                                <?php
                            endif; 

                        }else{ ?>

                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                           
                            <?php
                            $description = get_bloginfo( 'description', 'display' );

                            if ( $description || is_customize_preview() ) : ?>

                                <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>

                                <?php
                            endif; 

                        } ?>
                    </div><!-- .site-branding -->
                   
                    <div class="header-right">
                        <?php get_search_form(); ?>
                    </div>
                   
                </div>
            </div>
        </div><!-- .top-header -->
        <?php
    }
endif;
add_action( 'ritz_site_branding', 'ritz_site_branding_action' );

//=============================================================
// Before content hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_before_content_action' ) ) :
    /**
     * Content Start.
     *
     * @since 1.0.0
     */
    function ritz_before_content_action() {
    ?><div id="content" class="site-content"><div class="container"><div class="row"><?php
    }
endif;
add_action( 'ritz_before_content', 'ritz_before_content_action' );

//=============================================================
// After content hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_after_content_action' ) ) :
    /**
     * Content End.
     *
     * @since 1.0.0
     */
    function ritz_after_content_action() {
    ?></div><!-- .row --></div><!-- .container --></div><!-- #content --><?php    
    }
endif;
add_action( 'ritz_after_content', 'ritz_after_content_action' );

//=============================================================
// Social menu hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_social_menu_action' ) ) :

    function ritz_social_menu_action(){ 
        
        if( has_nav_menu( 'social' ) ) { 
            
            wp_nav_menu( array(
                'theme_location' => 'social',
                'depth'          => 1,
                'container'      => '',
                'container_class'=> 'social-menu-wrap',
                'link_before'    => '<span class="screen-reader-text">',
                'link_after'     => '</span>',
            ) ); 
        } 
    }

endif;

add_action( 'ritz_social_menu', 'ritz_social_menu_action', 10 );

//=============================================================
// Footer widgets hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_footer_widgets_action' ) ) :

    function ritz_footer_widgets_action(){ 

        if ( is_active_sidebar( 'footer-1' ) ||
             is_active_sidebar( 'footer-2' ) ||
             is_active_sidebar( 'footer-3' ) ){ ?> 
            <div id="footer-widgets" class="widget-area">
                <div class="container">
                    <?php
                    $column_count = 0;
                    for ( $i = 1; $i <= 3; $i++ ) {
                        if ( is_active_sidebar( 'footer-' . $i ) ) {
                            $column_count++;
                        }
                    }

                    $column_class = 'widget-column footer-column-' . absint( $column_count );
                    
                    for ( $i = 1; $i <= 3 ; $i++ ) {
                        if ( is_active_sidebar( 'footer-' . $i ) ) {
                            ?>
                            <div class="<?php echo $column_class; ?>">
                                <?php dynamic_sidebar( 'footer-' . $i ); ?>
                            </div>
                            <?php
                        }
                    } ?>
                </div><!-- .container -->
            </div><!-- #footer-widgets -->
            <?php
        }
    }

endif;

add_action( 'ritz_footer_widgets', 'ritz_footer_widgets_action', 10 );

//=============================================================
// Before footer info hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_before_footer_info_action' ) ) :

    function ritz_before_footer_info_action(){ 
        ?><div class="site-info"><div class="container"><div class="row"><?php
    }

endif;

add_action( 'ritz_before_footer_info', 'ritz_before_footer_info_action', 10 );

//=============================================================
// After footer info hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_after_footer_info_action' ) ) :
    
    function ritz_after_footer_info_action() {
       
        ?></div><!-- .row --></div><!-- .container --></div><!-- .site-info --><?php
    }
endif;

add_action( 'ritz_after_footer_info', 'ritz_after_footer_info_action' );

//=============================================================
// Copyright hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_bottom_footer_action' ) ) :

    function ritz_bottom_footer_action(){ 
       
        $copyright = ritz_get_option('copyright');

        if( !empty( $copyright )){ ?>

            <div class="copyright-text">

                <?php echo wp_kses_data( $copyright ); ?>

            </div>

            <?php

        } 

        $footer_social = ritz_get_option('social_icon_footer'); 

        if( 1 == $footer_social ){ ?>
            <div class="footer-social-links social-menu-wrap">   
                <?php 

                /**
                * Hook - ritz_social_menu.
                *
                * @hooked ritz_social_menu_action - 10
                */
                do_action( 'ritz_social_menu' );
                ?>
            </div>
        <?php } ?>
        
        <div class="credit-text">             
            <?php printf( esc_html__( '%1$s by %2$s', 'ritz' ), 'Ritz', '<a href="https://preciousthemes.com" rel="designer" target="_blank">Precious Themes</a>' ); ?>
        </div>
       
        <?php
    }

endif;

add_action( 'ritz_bottom_footer', 'ritz_bottom_footer_action', 10 );

//=============================================================
// Before primary hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_before_primary_action' ) ) :

    function ritz_before_primary_action(){

        ?><div id="primary" class="content-area"><main id="main" class="site-main" role="main"><?php
    }

endif;

add_action( 'ritz_before_primary', 'ritz_before_primary_action', 10 );

//=============================================================
// After primary hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_after_primary_action' ) ) :

    function ritz_after_primary_action(){ 
        ?></main><!-- #main --></div><!-- #primary --><?php
    }

endif;

add_action( 'ritz_after_primary', 'ritz_after_primary_action', 10 );

//=============================================================
// Newsletter hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_newsletter_action' ) ) :

    function ritz_newsletter_action(){ 

        if ( is_active_sidebar( 'sidebar-newsletter' ) ) {
            dynamic_sidebar( 'sidebar-newsletter' );
        }

    }

endif;

add_action( 'ritz_newsletter', 'ritz_newsletter_action', 10 );


//=============================================================
// Related post hook of the theme
//=============================================================
if ( ! function_exists( 'ritz_related_post_action' ) ) :

    function ritz_related_post_action(){ 

        $show_related_posts     = ritz_get_option('show_related_posts');

        $related_post_number    = ritz_get_option('related_post_number');

        if( !empty( $related_post_number) ){

            $post_num = $related_post_number;

        }else{

            $post_num = 3;

        } 

        if( 1 == $show_related_posts ){
        
            $post_id = get_the_ID();

            $categories = get_the_category( $post_id );  

            if( $categories ) {

                $category_ids = array();

                foreach( $categories as $category ) {

                    $category_ids[] = $category->term_id;

                }

                $args = array(
                            'category__in'   => $category_ids,
                            'post__not_in'   => array( $post_id ),
                            'posts_per_page' => absint( $post_num ),                                
                        );

                $related_query = new WP_Query( $args );

                if( $related_query->have_posts() ) { 

                    $related_posts = ritz_get_option('related_posts'); 

                    if( !empty( $related_posts ) ){  ?>

                        <h2 class="related-posts-title"><?php echo esc_html( $related_posts ); ?></h2>

                        <?php

                    } ?>
                    
                    <ul class="related-posts">

                        <?php 
                        while( $related_query->have_posts()){
                            
                            $related_query->the_post(); ?>  

                            <li>
                                <?php 
                                if ( has_post_thumbnail() ) { ?>
                                    <div class="related-img">
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('ritz-common'); ?></a>
                                   </div>
                                   <?php
                                } ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </li> 

                            <?php                
                        } 

                        wp_reset_postdata(); ?>

                    </ul>
                     
                    <?php           
                }
            }
        }
    }

endif;

add_action( 'ritz_related_post', 'ritz_related_post_action', 10 );