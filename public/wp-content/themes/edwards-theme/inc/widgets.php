<?php
/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Edwards 1.0
 */
function edwards_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', wpfc_theme_name() ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Sermon Sidebar', wpfc_theme_name() ),
		'id' => 'sidebar-sermon',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer', wpfc_theme_name() ),
		'id' => 'footer-sidebar',
		'before_widget' => '<li id="%1$s" class="widget thirds %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'edwards_widgets_init' );

/**
 * Custom Widget: Contacts
 */
class edwards_address_widget extends WP_Widget {

/**
* Widget setup.
*/
function edwards_address_widget() {
		$widget_ops = array('classname' => 'edwards-address', 'description' => __( 'This widget is used to show your contacts (based on your settings in Appearance => Theme Options)', 'edwards') );
		parent::__construct('edwards-address-widget', __('Edwards Contacts', 'edwards'), $widget_ops);
		$this->alt_option_name = 'edwards-address-widget';
}

function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		        
            echo $before_widget;
			if ( $title )
                echo $before_title . $title . $after_title;
				$edwards_fb = of_get_option( 'social_fb' );
				$edwards_twitter = of_get_option( 'social_twitter' );
				$edwards_gplus = of_get_option( 'social_gplus' );
				$edwards_email = of_get_option( 'social_email' );
				$edwards_phone = of_get_option( 'edwards_phone' );
				$edwards_street = of_get_option( 'edwards_street' );
				$edwards_address = of_get_option( 'edwards_address' );
				?>							

				<?php if ( $edwards_address ) : 
					$address_url = preg_replace( '![^a-z0-9]+!i', '+', $edwards_street. ' ' .$edwards_address );?>
					<p><i class="icon-map-marker"></i> <a href="<?php echo 'http://maps.google.com/maps?q=' . $address_url; ?>" title="<?php esc_attr_e( 'Directions', 'edwards' ); ?>"><?php echo $edwards_street. '<span class="city-state">' .$edwards_address. '</span>'; ?> </a></p>
				<?php endif; ?>

				<?php if ( $edwards_phone ) : ?>
					<p><i class="icon-phone"></i> <a href="tel:<?php echo $edwards_phone; ?>"><?php echo $edwards_phone; ?></a></p>
				<?php endif; ?>

				<?php if ( $edwards_email ) : ?>
					<p><i class="icon-envelope"></i> <a href="mailto:<?php echo antispambot( $edwards_email ); ?>"><?php echo $edwards_email; ?></a></p>
				<?php endif; ?>
				
				<div id="contact-social">
					<ul class="contact-social">
						<?php if ( $edwards_fb ) : ?>
							<li class="facebook"><a href="<?php echo esc_url( $edwards_fb ); ?>" title="<?php esc_attr_e( 'Facebook', 'edwards' ); ?>"><i class="icon-facebook"></i><span><?php _e( 'Facebook', 'edwards' ); ?></span></a></li>
						<?php endif; ?>

						<?php if ( $edwards_twitter ) : ?>
							<li class="twitter" ><a href="<?php echo esc_url( $edwards_twitter ); ?>" title="<?php esc_attr_e( 'Twitter', 'edwards' ); ?>"><i class="icon-twitter"></i><span><?php _e( 'Twitter', 'edwards' ); ?></span></a></li>
						<?php endif; ?>

						<?php if ( $edwards_gplus ) : ?>
							<li class="gplus"><a href="<?php echo esc_url( $edwards_gplus ); ?>" title="<?php esc_attr_e( 'Google+', 'edwards' ); ?>"><i class="icon-google-plus"></i><span><?php _e( 'Google+', 'edwards' ); ?></span></a></li>
						<?php endif; ?>
					</ul>
				</div><!-- #contact-social -->
              <?php echo $after_widget; ?>
        <?php
    }
 /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
	   ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'edwards'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><?php _e('Set your contacts in Appearance => Theme Options', 'edwards'); ?></p>
 <?php 
    }
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	    return $instance;
    }
} 

// Add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'edwards_address_load_widgets' );

// Register our widget.
function edwards_address_load_widgets() {
register_widget( 'edwards_address_widget' );
}
?>