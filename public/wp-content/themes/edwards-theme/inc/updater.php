<?php
/**
 * Theme Updater
 */

define( 'WPFC_STORE_URL', 'http://www.wpforchurch.com' ); // add your own unique prefix to prevent conflicts
define( 'WPFC_EDWARDS_THEME', 'Edwards Theme' ); // add your own unique prefix to prevent conflicts

/***********************************************
* This is our updater
***********************************************/

if ( !class_exists( 'EDD_SL_Theme_Updater' ) ) {
	// Load our custom theme updater
	include( dirname( __FILE__ ) . '/EDD_SL_Theme_Updater.php' );
}

$test_license = trim( get_option( 'edwards_theme_license_key' ) );

$edd_updater = new EDD_SL_Theme_Updater( array( 
		'remote_api_url' 	=> WPFC_STORE_URL, 	// Our store URL that is running EDD
		'version' 			=> '1.1', 				// The current theme version we are running
		'license' 			=> $test_license, 		// The license key (used get_option above to retrieve from DB)
		'item_name' 		=> WPFC_EDWARDS_THEME,	// The name of this theme
		'author'			=> 'Jack Lamb'	// The author's name
	)
);


/***********************************************
* Add our menu item
***********************************************/

function edwards_theme_license_menu() {
	add_theme_page( 'Theme License', 'Theme License', 'manage_options', 'edwards-license', 'edwards_theme_license_page' );
}
add_action('admin_menu', 'edwards_theme_license_menu');



/***********************************************
* Settings page
***********************************************/

function edwards_theme_license_page() {
	$license 	= get_option( 'edwards_theme_license_key' );
	$status 	= get_option( 'edwards_theme_license_key_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Theme License Options'); ?></h2>
		<form method="post" action="options.php">
		
			<?php settings_fields('edwards_theme_license'); ?>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="edwards_theme_license_key" name="edwards_theme_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="edwards_theme_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
									<?php wp_nonce_field( 'edwards_nonce_nonce', 'edwards_nonce_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_theme_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'edwards_nonce_nonce', 'edwards_nonce_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_theme_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>	
			<?php submit_button(); ?>
		
		</form>
	<?php
}

function edwards_theme_register_option() {
	// creates our settings in the options table
	register_setting('edwards_theme_license', 'edwards_theme_license_key', 'edd_theme_sanitize_license' );
}
add_action('admin_init', 'edwards_theme_register_option');


/***********************************************
* Gets rid of the local license status option
* when adding a new one
***********************************************/

function edd_theme_sanitize_license( $new ) {
	$old = get_option( 'edwards_theme_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'edwards_theme_license_key_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

/***********************************************
* Activate license key
***********************************************/

function edwards_theme_activate_license() {

	if( isset( $_POST['edd_theme_license_activate'] ) ) { 
	 	if( ! check_admin_referer( 'edwards_nonce_nonce', 'edwards_nonce_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		global $wp_version;

		$license = trim( get_option( 'edwards_theme_license_key' ) );
				
		$api_params = array( 
			'edd_action' => 'activate_license', 
			'license' => $license, 
			'item_name' => urlencode( WPFC_EDWARDS_THEME ) 
		);
		
		$response = wp_remote_get( add_query_arg( $api_params, WPFC_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "active" or "inactive"

		update_option( 'edwards_theme_license_key_status', $license_data->license );

	}
}
add_action('admin_init', 'edwards_theme_activate_license');

/***********************************************
* Deactivate license key
***********************************************/

function edwards_theme_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_theme_license_deactivate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'edwards_nonce_nonce', 'edwards_nonce_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edwards_theme_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( WPFC_EDWARDS_THEME ) // the name of our product in EDD
		);
		
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, WPFC_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'edwards_theme_license_key' );

	}
}
add_action('admin_init', 'edwards_theme_deactivate_license');



/***********************************************
* Check if a license is valid
***********************************************/

function edwards_theme_check_license() {

	global $wp_version;

	$license = trim( get_option( 'edwards_theme_license_key' ) );
		
	$api_params = array( 
		'edd_action' => 'check_license', 
		'license' => $license, 
		'item_name' => urlencode( WPFC_EDWARDS_THEME ) 
	);
	
	$response = wp_remote_get( add_query_arg( $api_params, WPFC_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}