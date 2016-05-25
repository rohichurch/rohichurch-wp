<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$theme = wp_get_theme();
	$themename = $theme->Name;
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/*
 * Allow the Script tag in the theme options panel
 */
add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'custom_sanitize_textarea' );
}
 
function custom_sanitize_textarea($input) {
    global $allowedposttags;
    
      $custom_allowedtags["script"] = array();
 
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Post Featured Image Size
	$post_featured_image_size = array("large" => "Large", "small" => "Small");
	
	// Slideshow Transition Effect
	$slideshow_effect = array("slide" => "Slide", "fade" => "Fade");
			
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
		
	$options[] = array( "name" => __('General','edwards'),
						"type" => "heading");	
	
	$options['logo'] = array( "name" => __('Logo','edwards'),
						"desc" => __('Upload a custom logo.','edwards'),
						"id" => "logo",
						"type" => "upload");
						
	$options['edwards_favicon'] = array( "name" => __('Favicon','edwards'),
						"desc" => __('Upload a custom favicon.','edwards'),
						"id" => "edwards_favicon",
						"type" => "upload");					

	$options['edwards_home_message'] = array( "name" => __('Home Message','edwards'),
						"desc" => __('Enter a short message to be displayed on the home page.','edwards'),
						"id" => "edwards_home_message",
						"std" => "",
						"type" => "textarea");
	
	$options[] = array( "name" => __('Number of Home Features to Show','edwards'),
						"desc" => __('Enter the number of features to show on the home page.','edwards'),
						"id" => "edwards_features_count",
						"std" => "3",
						"type" => "text");	
						
	$options['edwards_custom_css'] = array( "name" => __('Custom CSS','edwards'),
						"desc" => __('Enter custom CSS here.','edwards'),
						"id" => "edwards_custom_css",
						"std" => "",
						"type" => "textarea");								
							
	$options['edwards_analytics'] = array( "name" => __('Analytics','edwards'),
						"desc" => __('Enter your custom analytics code. (e.g. Google Analytics).','edwards'),
						"id" => "edwards_analytics",
						"std" => "",
						"type" => "textarea",
						"validate" => "none");
						
	$options[] = array( "name" => __('Appearance','edwards'),
						"type" => "heading");
							
	$options['edwards_color_scheme'] = array( "name" => __('Header Color','edwards'),
						"desc" => __('Select a color for the site header.','edwards'),
						"id" => "edwards_color_scheme",
						"std" => "#98a97c",
						"type" => "color");
										
	$options['edwards_color_link'] = array( "name" => __('Link Color','edwards'),
						"desc" => __('Select a color for your links.','edwards'),
						"id" => "edwards_color_link",
						"std" => "#366289",
						"type" => "color");

	$options['edwards_color_link_hover'] = array( "name" => __('Link Hover Color','edwards'),
						"desc" => __('Select a hover color for your links.','edwards'),
						"id" => "edwards_color_link_hover",
						"std" => "#b43c24",
						"type" => "color");
						
	$options['edwards_heading_font'] = array( "name" => __('Font for Headings','edwards'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for headings.','edwards'),
						"id" => "edwards_heading_font",
						"std" => "PT Sans Narrow",
						"type" => "text");
						
	$options['edwards_body_font'] = array( "name" => __('Font for Body Text','edwards'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for the body text.','edwards'),
						"id" => "edwards_body_font",
						"std" => "PT Sans",
						"type" => "text");
						
	$options['edwards_home_message_font'] = array( "name" => __('Font for Home Message','edwards'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for the home message text.','edwards'),
						"id" => "edwards_home_message_font",
						"std" => "PT Sans Narrow",
						"type" => "text");
/* Slideshow */																							
	$options[] = array( "name" => __('Slideshow','edwards'),
						"type" => "heading");
						
	$options['edwards_slideshow_enabled'] = array( "name" => __('Enable Slideshow','edwards'),
						"desc" => __('Check this box to enable the home page slideshow.','edwards'),
						"id" => "edwards_slideshow_enabled",
						"std" => "1",
						"type" => "checkbox");				

	$options['edwards_slideshow_delay'] = array( "name" => __('Slideshow Delay','edwards'),
						"desc" => __('Enter the delay in seconds between slides. Enter 0 to disable auto-playing.','edwards'),
						"id" => "edwards_slideshow_delay",
						"std" => "6",
						"type" => "text");

	$options['edwards_slideshow_effect'] = array( "name" => __('Slideshow Effect','edwards'),
						"desc" => __('Select the type of transition effect for the slideshow.','edwards'),
						"id" => "edwards_slideshow_effect",
						"std" => "fade",
						"type" => "select",
						"options" => $slideshow_effect);	
	/* Contact Links */
	$options[] = array( "name" => __('Contacts','edwards'),
						"type" => "heading");

	$options['edwards_street'] = array( 'name' => __('Street Address', 'edwards'),
                'desc' => __('Enter the street: e.g., 4700 NW 10th St', 'edwards'),
                'id' => 'edwards_street',
                'std' => '',
                'type' => 'text');
				
	$options['edwards_address'] = array( 'name' => __('City, State, and ZIP', 'edwards'),
                'desc' => __('Enter the city, state, and zip on one line: e.g., Oklahoma City, OK 73127', 'edwards'),
                'id' => 'edwards_address',
                'std' => '',
                'type' => 'text');

	$options['edwards_phone'] = array( 'name' => __('Phone', 'edwards'),
                'desc' => __('Enter the phone number.', 'edwards'),
                'id' => 'edwards_phone',
                'std' => '',
                'type' => 'text');
				
	$options['social_fb'] = array( 'name' => __('Facebook', 'edwards'),
                'desc' => __('Enter the full url to your page', 'edwards'),
                'id' => 'social_fb',
                'std' => '',
                'type' => 'text');

	$options['social_twitter'] = array( 'name' => __('Twitter', 'edwards'),
                'desc' => __('Enter the full url to your page', 'edwards'),
                'id' => 'social_twitter',
                'std' => '',
                'type' => 'text');

	$options['social_gplus'] = array( 'name' => __('Google+', 'edwards'),
                'desc' => __('Enter the full url to your page', 'edwards'),
                'id' => 'social_gplus',
                'std' => '',
                'type' => 'text');

	$options['social_email'] = array( 'name' => __('Email', 'edwards'),
                'desc' => __('Enter your email address', 'edwards'),
                'id' => 'social_email',
                'std' => '',
                'type' => 'text');
																										
	$options[] = array( "name" => __('Footer','edwards'),
						"type" => "heading");
						
	$options['edwards_footer_left'] = array( "name" => __('Left Footer Text','edwards'),
						"desc" => __('This will appear on the left side of the footer.','edwards'),
						"id" => "edwards_footer_left",
						"std" => "",
						"type" => "textarea");

	$options['edwards_footer_right'] = array( "name" => __('Right Footer Text','edwards'),
						"desc" => __('This will appear on the right side of the footer.','edwards'),
						"id" => "edwards_footer_right",
						"std" => "",
						"type" => "textarea");
							
	return $options;
}

/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */

add_action( 'customize_register', 'edwards_customizer_register' );

function edwards_customizer_register($wp_customize) {
	
	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$theme = wp_get_theme();
	$themename = $theme->Name;
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	/**
	 * This is optional, but if you want to reuse some of the defaults
	 * or values you already have built in the options panel, you
	 * can load them into $options for easy reference
	 */
	 
	$options = optionsframework_options();

	$wp_customize->add_section( 'edwards_general', array(
		'title' => __( 'General', 'edwards' ),
		'priority' => 25
	) );

	$wp_customize->add_setting( $themename.'[logo]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label' => $options['logo']['name'],
		'section' => 'edwards_general',
		'settings' => $themename.'[logo]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[edwards_favicon]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'edwards_favicon', array(
		'label' => $options['edwards_favicon']['name'],
		'section' => 'edwards_general',
		'settings' => $themename.'[edwards_favicon]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[edwards_home_message]', array(
		'default' => $options['edwards_home_message']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_customizer_home_message', array(
		'label' => $options['edwards_home_message']['name'],
		'section' => 'edwards_general',
		'settings' => $themename.'[edwards_home_message]',
		'type' => 'text'
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_custom_css]', array(
		'default' => $options['edwards_custom_css']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, 'edwards_customizer_custom_css', array(
		'label' => $options['edwards_custom_css']['name'],
		'section' => 'edwards_general',
		'settings' => $themename.'[edwards_custom_css]',
		'type' => $options['edwards_custom_css']['type']
	) ) );
	
	/* Appearance */
	$wp_customize->add_section( 'edwards_appearance', array(
		'title' => __( 'Appearance', 'edwards' ),
		'priority' => 26
	) );

	$wp_customize->add_setting( $themename.'[edwards_color_scheme]', array(
		'default' => $options['edwards_color_scheme']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'edwards_color_scheme', array(
		'label'   => $options['edwards_color_scheme']['name'],
		'section' => 'edwards_appearance',
		'settings'   => $themename.'[edwards_color_scheme]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[edwards_color_link]', array(
		'default' => $options['edwards_color_link']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'edwards_color_link', array(
		'label'   => $options['edwards_color_link']['name'],
		'section' => 'edwards_appearance',
		'settings'   => $themename.'[edwards_color_link]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[edwards_color_link_hover]', array(
		'default' => $options['edwards_color_link_hover']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'edwards_color_link_hover', array(
		'label'   => $options['edwards_color_link_hover']['name'],
		'section' => 'edwards_appearance',
		'settings'   => $themename.'[edwards_color_link_hover]'
	) ) );
	
	/* Typography */
	$wp_customize->add_section( 'edwards_typography', array(
		'title' => __( 'Typography', 'edwards' ),
		'priority' => 27
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_heading_font]', array(
		'default' => $options['edwards_heading_font']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_customizer_heading_font', array(
		'label' => $options['edwards_heading_font']['name'],
		'section' => 'edwards_typography',
		'settings' => $themename.'[edwards_heading_font]',
		'type' => $options['edwards_heading_font']['type']
	) );

	$wp_customize->add_setting( $themename.'[edwards_body_font]', array(
		'default' => $options['edwards_body_font']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_customizer_body_font', array(
		'label' => $options['edwards_body_font']['name'],
		'section' => 'edwards_typography',
		'settings' => $themename.'[edwards_body_font]',
		'type' => $options['edwards_body_font']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_home_message_font]', array(
		'default' => $options['edwards_home_message_font']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_customizer_home_message_font', array(
		'label' => $options['edwards_home_message_font']['name'],
		'section' => 'edwards_typography',
		'settings' => $themename.'[edwards_home_message_font]',
		'type' => $options['edwards_home_message_font']['type']
	) );

	/* Slideshow */
	$wp_customize->add_section( 'edwards_slideshow', array(
		'title' => __( 'Slideshow', 'edwards' ),
		'priority' => 28
	) );

	$wp_customize->add_setting( $themename.'[edwards_slideshow_enabled]', array(
		'default' => $options['edwards_slideshow_enabled']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'edwards_slideshow_enabled', array(
		'label' => $options['edwards_slideshow_enabled']['name'],
		'section' => 'edwards_slideshow',
		'settings' => $themename.'[edwards_slideshow_enabled]',
		'type' => $options['edwards_slideshow_enabled']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_slideshow_delay]', array(
		'default' => $options['edwards_slideshow_delay']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_customizer_slideshow_delay', array(
		'label' => $options['edwards_slideshow_delay']['name'],
		'section' => 'edwards_slideshow',
		'settings' => $themename.'[edwards_slideshow_delay]',
		'type' => $options['edwards_slideshow_delay']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_slideshow_effect]', array(
		'default' => $options['edwards_slideshow_effect']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'edwards_customizer_slideshow_effect', array(
		'label' => $options['edwards_slideshow_effect']['name'],
		'section' => 'edwards_slideshow',
		'settings' => $themename.'[edwards_slideshow_effect]',
		'type' => $options['edwards_slideshow_effect']['type'],
		'choices' => $options['edwards_slideshow_effect']['options']
	) );
	
	/* Social Links */
	$wp_customize->add_section( 'edwards_social', array(
		'title' => __( 'Contacts', 'edwards' ),
		'priority' => 29
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_address]', array(
		'default' => $options['edwards_address']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_address', array(
		'label' => $options['edwards_address']['name'],
		'section' => 'edwards_social',
		'settings' => $themename.'[edwards_address]',
		'type' => $options['edwards_address']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_street]', array(
		'default' => $options['edwards_street']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_street', array(
		'label' => $options['edwards_street']['name'],
		'section' => 'edwards_social',
		'settings' => $themename.'[edwards_street]',
		'type' => $options['edwards_street']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_phone]', array(
		'default' => $options['edwards_phone']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'edwards_phone', array(
		'label' => $options['edwards_phone']['name'],
		'section' => 'edwards_social',
		'settings' => $themename.'[edwards_phone]',
		'type' => $options['edwards_phone']['type']
	) );

	
	$wp_customize->add_setting( $themename.'[social_fb]', array(
		'default' => $options['social_fb']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'social_fb', array(
		'label' => $options['social_fb']['name'],
		'section' => 'edwards_social',
		'settings' => $themename.'[social_fb]',
		'type' => $options['social_fb']['type']
	) );

	$wp_customize->add_setting( $themename.'[social_twitter]', array(
		'default' => $options['social_twitter']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'social_twitter', array(
		'label' => $options['social_twitter']['name'],
		'section' => 'edwards_social',
		'settings' => $themename.'[social_twitter]',
		'type' => $options['social_twitter']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[social_gplus]', array(
		'default' => $options['social_gplus']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'social_gplus', array(
		'label' => $options['social_gplus']['name'],
		'section' => 'edwards_social',
		'settings' => $themename.'[social_gplus]',
		'type' => $options['social_gplus']['type']
	) );
	

	$wp_customize->add_setting( $themename.'[social_email]', array(
		'default' => $options['social_email']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'social_email', array(
		'label' => $options['social_email']['name'],
		'section' => 'edwards_social',
		'settings' => $themename.'[social_email]',
		'type' => $options['social_email']['type']
	) );
	
	/* Footer */
	$wp_customize->add_section( 'edwards_footer', array(
		'title' => __( 'Footer', 'edwards' ),
		'priority' => 31
	) );
	
	$wp_customize->add_setting( $themename.'[edwards_footer_left]', array(
		'default' => $options['edwards_footer_left']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, 'edwards_customizer_footer_left', array(
		'label' => $options['edwards_footer_left']['name'],
		'section' => 'edwards_footer',
		'settings' => $themename.'[edwards_footer_left]',
		'type' => $options['edwards_footer_left']['type']
	) ) );
	
	$wp_customize->add_setting( $themename.'[edwards_footer_right]', array(
		'default' => $options['edwards_footer_right']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, 'edwards_customizer_footer_right', array(
		'label' => $options['edwards_footer_right']['name'],
		'section' => 'edwards_footer',
		'settings' => $themename.'[edwards_footer_right]',
		'type' => $options['edwards_footer_right']['type']
	) ) );
	
}