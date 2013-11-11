<?php
/**
 * Auto Hosted Child Theme Updater Class
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @version 0.1.4
 * @author David Chandra Purnama <david@shellcreeper.com>
 * @link http://autohosted.com/
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @copyright Copyright (c) 2013, David Chandra Purnama
 */
class Revo_Theme_Updater{

	/**
	 * Class Constructor
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		add_action( 'after_setup_theme', array( &$this, 'updater_setup' ), 16 );
	}

	/**
	 * Setup updater
	 * 
	 * @since 0.1.0
	 */
	public function updater_setup(){

		/* Get needed data */
		$updater_data = $this->updater_data();

		/* disable request to wp.org repo */
		add_filter( 'http_request_args', array( &$this, 'disable_wporg_request' ), 5, 2 );

		/* only do stuff if minimum req pass */
		if ( isset( $updater_data['repo_uri'] ) || !empty( $updater_data['repo_uri'] ) || isset( $updater_data['repo_slug'] ) || !empty( $updater_data['repo_slug'] ) ){

			/* filter theme update transient */
			add_filter( 'pre_set_site_transient_update_themes', array( &$this, 'transient_update_themes' ), 9999 );
			add_filter( 'site_transient_update_themes', array( &$this, 'transient_update_themes' ), 9999 );

			/* install theme in correct folder when zip source folder is not the same */
			add_filter( 'upgrader_source_selection', array( &$this, 'theme_source_selection' ), 10, 3);

			/* add dashboard widget for activation key */
			if ( true === $updater_data['dashboard'] ){
				add_action( 'wp_dashboard_setup', array( &$this, 'add_dashboard_widget' ) );
			}
		}
	}


	/**
	 * Disable request to wp.org theme repository
	 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
	 * @since 0.1.2
	 */
	public function disable_wporg_request( $r, $url ){

		/* If it's not a theme request, bail early */
		if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
			return $r;

		/* unserialize data */
		$themes = unserialize( $r['body']['themes'] );

		/* unset this theme only */
		unset( $themes[ get_option( 'stylesheet' ) ] );

		/* serialize it back */
		$r['body']['themes'] = serialize( $themes );
		return $r;
	}


	/**
	 * Updater Data
	 * 
	 * @since 0.1.0
	 */
	public function updater_data(){

		/* Get the theme support arguements for 'auto-hosted-theme-updater'. */
		$theme_support = get_theme_support( 'auto-hosted-child-theme-updater' );

		/* get updater config */
		if ( !is_array( $theme_support[0] ) ) $user_config = false;
		else $user_config = $theme_support[0];

		/* default config */
		$defaults = array(
			'repo_uri'    => '',
			'repo_slug'   => '',
			'key'         => '',
			'dashboard'   => false,
			'username'    => false,
			'autohosted'  => 'childtheme.0.1.4',
		);

		/* merge configs and defaults */
		$config = wp_parse_args( $user_config, $defaults );

		/* Theme data */
		$theme_data = wp_get_theme( get_stylesheet() );

		/* Updater data: Hana Tul Set! */
		$updater_data = array();

		/* Repo URI */
		$repo_uri = '';
		if ( !empty( $config['repo_uri'] ) )
			$repo_uri = trailingslashit( esc_url_raw( $config['repo_uri'] ) );
		$updater_data['repo_uri'] = $repo_uri;

		/* Repo slug */
		$repo_slug = '';
		if ( !empty( $config['repo_slug'] ) )
			$repo_slug = sanitize_title( $config['repo_slug'] );
		$updater_data['repo_slug'] = $repo_slug;

		/* by user role */
		if ( false === $config['username'] )
			$updater_data['role'] = false;
		else
			$updater_data['role'] = true;

		/* User name / login */
		$username = '';
		if ( false !== $config['username'] && false === $config['dashboard'] ) 
			$username = $config['username'];
		if ( true === $config['username'] && true === $config['dashboard'] ){
			$widget_id = 'aht_' . get_stylesheet() . '_activation_key';
			$widget_option = get_option( $widget_id );
			$username = ( isset( $widget_option['username'] ) && !empty( $widget_option['username'] ) ) ? $widget_option['username'] : '' ;
		}
		$updater_data['login'] = $username;

		/* Activation key */
		$key = '';
		if ( $config['key'] ) $key = md5( $config['key'] );
		if ( empty( $key ) && true === $config['dashboard'] ){
			$widget_id = 'aht_' . get_stylesheet() . '_activation_key';
			$key_db = get_option( $widget_id );
			$key = ( $key_db['key'] ) ? md5( $key_db['key'] ) : '' ;
		}
		$updater_data['key'] = $key;

		/* Dashboard widget */
		$updater_data['dashboard'] = $config['dashboard'];

		/* Theme slug */
		$updater_data['slug'] = get_stylesheet();

		/* Theme name */
		$updater_data['name'] = esc_attr( $theme_data->get( 'Name' ) );

		/* Theme version */
		$updater_data['version'] = esc_attr( $theme_data->get( 'Version' ) );

		/* Theme URI */
		$theme_uri = $theme_data->get( 'ThemeURI' );
		if ( !empty($theme_uri) ) $theme_uri = esc_url_raw( $theme_uri );
		$updater_data['uri'] = $theme_uri;

		/* Domain */
		$updater_data['domain'] = get_bloginfo('url');

		/* Updater class id and version */
		$updater_data['autohosted'] = esc_attr( $config['autohosted'] );

		return $updater_data;
	}

	/**
	 * Check for theme updates
	 * 
	 * @since 0.1.0
	 */
	public function transient_update_themes( $checked_data ) {

		global $wp_version;

		/* only if wp check for updates. */
		if ( empty( $checked_data->checked ) )
			return $checked_data;

		/* Get needed data */
		$updater_data = $this->updater_data();

		/* remote call */
		$remote_url = add_query_arg( array( 'theme_repo' => $updater_data['repo_slug'], 'ahtr_check' => $updater_data['version'] ), $updater_data['repo_uri'] );
		$remote_request = array( 'timeout' => 20, 'body' => array( 'key' => $updater_data['key'], 'login' => $updater_data['login'], 'autohosted' => $updater_data['autohosted'] ), 'user-agent' => 'WordPress/' . $wp_version . '; ' . $updater_data['domain'] );
		$raw_response = wp_remote_post( $remote_url, $remote_request );

		/* error check */
		$response = '';
		if ( !is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) )
			$response = maybe_unserialize( trim( wp_remote_retrieve_body( $raw_response ) ) );

		/* check response data */
		if ( is_array( $response ) && !empty( $response ) ){

			/* check if minimum data is available */
			if ( isset( $response['new_version'] ) && !empty( $response['new_version'] ) && isset( $response['package'] ) && !empty( $response['package'] ) ){

				/* create response data array */
				$updates = array();
				$updates['new_version'] = esc_attr( $response['new_version'] );
				$updates['package'] = esc_url_raw( $response['package'] );
				if ( isset( $response['url'] ) && !empty( $response['url'] ) )
					$updates['url'] = esc_url_raw( $response['url'] );
				else
					$updates['url'] = $updater_data['uri'];

				/* if response not exist, create empty. */
				if ( !isset( $checked_data->response ) )
					$checked_data->response = array();

				/* feed data to wp transient */
				$checked_data->response[$updater_data['slug']] = $updates;
			}
		}

		/* close sesame*/
		return $checked_data;
	}


	/**
	 * Move the theme from zip file to correct theme folder
	 * 
	 * @link https://github.com/scarstens/Github-Theme-Updater/blob/master/updater.php
	 * @since 0.1.0
	 */
	public function theme_source_selection( $source, $remote_source, $upgrader ){

		/* if theme name is set */
		if( isset( $upgrader->skin->theme_info->stylesheet ) ){

			/* only in current theme */
			if ( $upgrader->skin->theme_info->stylesheet == get_stylesheet() ){

				/* theme folder */
				$theme_name = $upgrader->skin->theme_info->stylesheet;

				/* add notification feedback text */
				$upgrader->skin->feedback( __( 'Executing upgrader_source_selection filter function...', 'text-domain' ) );

				/* only if everything is set */
				if( isset( $source, $remote_source, $theme_name ) ){

					/* set new source to correct theme folder */
					$new_source = $remote_source . '/' . $theme_name . '/';

					/* rename the folder */
					if(@rename( $source, $new_source ) ){
						$upgrader->skin->feedback( __( 'Renamed theme folder successfully.', 'text-domain' ) );
						return $new_source;
					}
					/* unable to rename the folder to correct theme folder */
					else{
						$upgrader->skin->feedback( __( '**Unable to rename downloaded theme.', 'text-domain' ) );
						return new WP_Error();
					}
				}
				/* fallback */
				else
					$upgrader->skin->feedback( __( '**Source or Remote Source is unavailable.', 'text-domain' ) );
			}
		}
		return $source;
	}


	/**
	 * Add Dashboard Widget
	 * 
	 * @since 0.1.0
	 */
	public function add_dashboard_widget() {

		/* Get needed data */
		$updater_data = $this->updater_data();

		/* Widget ID, prefix with "aht_" to make sure it's unique */
		$widget_id = 'aht_' . $updater_data['slug'] . '_activation_key';

		/* Widget name */
		$widget_name = $updater_data['name'] . __( ' Theme Updates', 'text-domain' );

		/* role check, in default install only administrator have this cap */
		if ( current_user_can( 'update_themes' ) ) {

			/* add dashboard widget for acivation key */
			wp_add_dashboard_widget( $widget_id, $widget_name, array( &$this, 'dashboard_widget_callback' ), array( &$this, 'dashboard_widget_control_callback' ) );
		}
	}


	/**
	 * Dashboard Widget Callback
	 * 
	 * @since 0.1.0
	 */
	public function dashboard_widget_callback() {

		/* Get needed data */
		$updater_data = $this->updater_data();

		/* Widget ID, prefix with "aht_" to make sure it's unique */
		$widget_id = 'aht_' . $updater_data['slug'] . '_activation_key';

		/* edit widget url */
		$edit_url = 'index.php?edit=' . $widget_id . '#' . $widget_id;

		/* get activation key from database */
		$widget_option = get_option( $widget_id );

		/* if activation key available/set */
		if ( !empty( $widget_option ) && is_array( $widget_option ) ){

			/* members only update */
			if ( true === $updater_data['role'] ){

				/* username */
				$username = isset( $widget_option['username'] ) ? $widget_option['username'] : '';
				echo '<p>'. __( 'Username: ', 'text-domain' ) . '<code>' . $username . '</code></p>';

				/* activation key input */
				$key = isset( $widget_option['key'] ) ? $widget_option['key'] : '' ;
				echo '<p>'. __( 'Email: ', 'text-domain' ) . '<code>' . $key . '</code></p>';
			}
			else{

				/* activation key input */
				$key = isset( $widget_option['key'] ) ? $widget_option['key'] : '' ;
				echo '<p>'. __( 'Key: ', 'text-domain' ) . '<code>' . $key . '</code></p>';
			}

			/* if key status is valid */
			if ( $widget_option['status'] == 'valid' ){
				_e( '<p>Your plugin update is <span style="color:green">active</span></p>', 'text-domain' );
			}
			/* if key is not valid */
			elseif( $widget_option['status'] == 'invalid' ){
				_e( '<p>Your input is <span style="color:red">not valid</span>, automatic updates is <span style="color:red">not active</span>.</p>', 'text-domain' );
				echo '<p><a href="' . $edit_url . '" class="button-primary">' . __( 'Edit Key', 'text-domain' ) . '</a></p>';
			}
			/* else */
			else{
				_e( '<p>Unable to validate update activation.</p>', 'auto-hosted' );
				echo '<p><a href="' . $edit_url . '" class="button-primary">' . __( 'Try again', 'text-domain' ) . '</a></p>';
			}
		}
		/* if activation key is not yet set/empty */
		else{
			echo '<p><a href="' . $edit_url . '" class="button-primary">' . __( 'Add Key', 'text-domain' ) . '</a></p>';
		}
	}


	/**
	 * Dashboard Widget Control Callback
	 * 
	 * @since 0.1.0
	 */
	public function dashboard_widget_control_callback() {

		/* Get needed data */
		$updater_data = $this->updater_data();

		/* Widget ID, prefix with "aht_" to make sure it's unique */
		$widget_id = 'aht_' . $updater_data['slug'] . '_activation_key';

		/* check options is set before saving */
		if ( isset( $_POST[$widget_id] ) ){

			$submit_data = $_POST[$widget_id];

			/* username submitted */
			$username = isset( $submit_data['username'] ) ? strip_tags( trim( $submit_data['username'] ) ) : '' ;

			/* retrive the option value from the form */
			$key = isset( $submit_data['key'] ) ? strip_tags( trim( $submit_data['key'] ) ) : '' ;

			/* get wp version */
			global $wp_version;

			/* get current domain */
			$domain = $updater_data['domain'];

			/* Get data from server */
			$remote_url = add_query_arg( array( 'theme_repo' => $updater_data['repo_slug'], 'ahr_check_key' => 'validate_key' ), $updater_data['repo_uri'] );
			$remote_request = array( 'timeout' => 20, 'body' => array( 'key' => md5($key), 'login' => $username, 'autohosted' => $updater_data['autohosted'] ), 'user-agent' => 'WordPress/' . $wp_version . '; ' . $updater_data['domain'] );
			$raw_response = wp_remote_post( $remote_url, $remote_request );

			/* get response */
			$response = '';
			if ( !is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) )
				$response = trim( wp_remote_retrieve_body( $raw_response ) );

			/* if call to server sucess */
			if ( !empty( $response ) ){

				/* if key is valid */
				if ( $response == 'valid' ) $valid = 'valid';

				/* if key is not valid */
				elseif ( $response == 'invalid' ) $valid = 'invalid';

				/* if response is value is not recognized */
				else $valid = 'unrecognized';
			}
			/* if response is empty or error */
			else{
				$valid = 'error';
			}

			/* database input */
			$input = array(
				'username' => $username,
				'key' => $key,
				'status' => $valid,
			);

			/* save value */
			update_option( $widget_id, $input );
		}

		/* get activation key from database */
		$widget_option = get_option( $widget_id );

		/* default key, if it's not set yet */
		$username_option = isset( $widget_option['username'] ) ? $widget_option['username'] : '' ;
		$key_option = isset( $widget_option['key'] ) ? $widget_option['key'] : '' ;

		/* display the form input for activation key */ ?>

		<?php if ( true === $updater_data['role'] ) { // members only update ?>

		<p>
			<label for="<?php echo $widget_id; ?>-username"><?php _e( 'User name', 'text-domain' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $widget_id; ?>-username" name="<?php echo $widget_id; ?>[username]" type="text" value="<?php echo $username_option;?>"/>
		</p>
		<p>
			<label for="<?php echo $widget_id; ?>-key"><?php _e( 'Email', 'text-domain' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $widget_id; ?>-key" class="regular-text" name="<?php echo $widget_id; ?>[key]" type="text" value="<?php echo $key_option;?>"/>
		</p>

		<?php } else { // activation keys ?>

		<p>
			<label for="<?php echo $widget_id; ?>-key"><?php _e( 'Activation Key', 'text-domain' ); ?></label>
		</p>
		<p>
			<input id="<?php echo $widget_id; ?>-key" class="regular-text" name="<?php echo $widget_id; ?>[key]" type="text" value="<?php echo $key_option;?>"/>
		</p>

		<?php }
	}
}