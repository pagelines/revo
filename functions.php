<?php

// Load Framework - don't delete this shit
require_once( dirname(__FILE__) . '/setup.php' );

// Load our shit in a class cause it's awesome
class Revo {

	function __construct() {

		// Constants
		$this->url = sprintf('%s', PL_CHILD_URL);
		$this->dir = sprintf('/%s', PL_CHILD_DIR);

	}

}
new Revo;

define( 'AH_REVO_STORE_URL', 'http://shop.ahansson.com' );

define( 'AH_REVO_THEME_NAME', 'REVO' );



/***********************************************
* This is our updater
***********************************************/

if ( !class_exists( 'EDD_SL_Theme_Updater' ) ) {
	// Load our custom theme updater
	include( dirname( __FILE__ ) . '/EDD_SL_Theme_Updater.php' );
}

$test_license = trim( get_option( 'ah_revo_license_key' ) );

$edd_updater = new EDD_SL_Theme_Updater( array(
		'remote_api_url' 	=> AH_REVO_STORE_URL, 	// Our store URL that is running EDD
		'version' 			=> '1.1', 				// The current theme version we are running
		'license' 			=> $test_license, 		// The license key (used get_option above to retrieve from DB)
		'item_name' 		=> AH_REVO_THEME_NAME,	// The name of this theme
		'author'			=> 'Aleksander Hansson'	// The author's name
	)
);


/***********************************************
* Add our menu item
***********************************************/

function ah_revo_license_menu() {
	add_theme_page( 'REVO License', 'REVO License', 'manage_options', 'ah-revo-license', 'ah_revo_license_page' );
}
add_action('admin_menu', 'ah_revo_license_menu');



/***********************************************
* Sample settings page, substitute with yours
***********************************************/

function ah_revo_license_page() {
	$license 	= get_option( 'ah_revo_license_key' );
	$status 	= get_option( 'ah_revo_license_key_status' );
	?>
	<div class="wrap">
		<h2><?php _e('REVO License Options'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('ah_revo_license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="ah_revo_license_key" name="ah_revo_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="ah_revo_license_key"><?php _e('Enter your license key'); ?></label>
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
									<?php wp_nonce_field( 'ah_revo_nonce', 'ah_revo_nonce' ); ?>
									<input type="submit" class="button-secondary" name="ah_revo_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'ah_revo_nonce', 'ah_revo_nonce' ); ?>
									<input type="submit" class="button-secondary" name="ah_revo_license_activate" value="<?php _e('Activate License'); ?>"/>
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

function ah_revo_register_option() {
	// creates our settings in the options table
	register_setting('ah_revo_license', 'ah_revo_license_key', 'ah_revo_sanitize_license' );
}
add_action('admin_init', 'ah_revo_register_option');


/***********************************************
* Gets rid of the local license status option
* when adding a new one
***********************************************/

function ah_revo_sanitize_license( $new ) {
	$old = get_option( 'ah_revo_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'ah_revo_license_key_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

/***********************************************
* Illustrates how to activate a license key.
***********************************************/

function ah_revo_activate_license() {

	if( isset( $_POST['ah_revo_license_activate'] ) ) {
	 	if( ! check_admin_referer( 'ah_revo_nonce', 'ah_revo_nonce' ) )
			return; // get out if we didn't click the Activate button

		global $wp_version;

		$license = trim( get_option( 'ah_revo_license_key' ) );

		$api_params = array(
			'edd_action' => 'activate_license',
			'license' => $license,
			'item_name' => urlencode( AH_REVO_THEME_NAME )
		);

		$response = wp_remote_get( add_query_arg( $api_params, AH_REVO_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"

		update_option( 'ah_revo_license_key_status', $license_data->license );

	}
}
add_action('admin_init', 'ah_revo_activate_license');

/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function ah_revo_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['ah_revo_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'ah_revo_nonce', 'ah_revo_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'ah_revo_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( AH_REVO_THEME_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, AH_REVO_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'ah_revo_license_key_status' );

	}
}
add_action('admin_init', 'ah_revo_deactivate_license');



/***********************************************
* Illustrates how to check if a license is valid
***********************************************/

function ah_revo_check_license() {

	global $wp_version;

	$license = trim( get_option( 'ah_revo_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( AH_REVO_THEME_NAME )
	);

	$response = wp_remote_get( add_query_arg( $api_params, AH_REVO_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

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