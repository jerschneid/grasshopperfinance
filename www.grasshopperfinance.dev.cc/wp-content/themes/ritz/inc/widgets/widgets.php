<?php
/**
 * Custom widgets.
 *
 * @package Ritz
 */

if ( ! function_exists( 'ritz_load_widgets' ) ) :

    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function ritz_load_widgets() {
        
        // Newsletter.
        register_widget( 'Ritz_Newsletter_Widget' );

    }

endif;

add_action( 'widgets_init', 'ritz_load_widgets' );

if ( ! class_exists( 'Ritz_Newsletter_Widget' ) ) :

    /**
     * Contact widget class.
     *
     * @since 1.0.0
     */
    class Ritz_Newsletter_Widget extends WP_Widget {

        function __construct() {
            $opts = array(
                    'classname'   => 'ritz_newsletter',
                    'description' => esc_html__( 'Newsletter with mailchimp form', 'ritz' ),
            );
            parent::__construct( 'ritz-newsletter', esc_html__( 'Ritz: Newsletter', 'ritz' ), $opts );
        }

        function widget( $args, $instance ) {


            $title                  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );



            $newsletter_shortcode   = !empty( $instance['newsletter_shortcode'] ) ? $instance['newsletter_shortcode'] : ''; 

        
            echo $args['before_widget']; ?>

            <div class="section-newsletter">

                <div class="container">

                    <div class="row">

                        <?php 

                        if ( $title ) {
                            echo $args['before_title'] . $title . $args['after_title'];
                        } ?>

                        <?php if ( $newsletter_shortcode ) { ?>

                            <div class="newsletter-form">

                                <?php echo do_shortcode( wp_kses_post( $newsletter_shortcode ) ); ?>

                            </div>

                        <?php } ?>

                    </div><!-- .newsletter-wrapper -->

                </div>

            </div><!-- .newsletter -->

            <?php 

            echo $args['after_widget'];

        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title']                  = sanitize_text_field( $new_instance['title'] );

            $instance['newsletter_shortcode']   = sanitize_text_field( $new_instance['newsletter_shortcode'] );

            return $instance;
        }

        function form( $instance ) {

            // Defaults.
            $defaults = array(
                'title'                 => '',
                'newsletter_shortcode'  => '',
            );

            $instance = wp_parse_args( (array) $instance, $defaults );


            $newsletter_shortcode = !empty( $instance['newsletter_shortcode'] ) ? $instance['newsletter_shortcode'] : '';

            ?>
            
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Title:', 'ritz' ); ?></strong></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_name('newsletter_shortcode') ); ?>">
                    <?php esc_html_e('Newsletter Shortcode:', 'ritz'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('newsletter_shortcode') ); ?>" name="<?php echo esc_attr( $this->get_field_name('newsletter_shortcode') ); ?>" type="text" value="<?php echo esc_attr( $newsletter_shortcode ); ?>" />  
                <small>
                    <?php esc_html_e('Shortcode of mailchimp or other mailing applications can be used.', 'ritz'); ?> 
                </small>    
            </p>
                    
        <?php
                
        }

    }

endif;