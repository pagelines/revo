<?php

// Load Framework - don't delete this shit
require_once( dirname(__FILE__) . '/setup.php' );

// Load our shit in a class cause it's awesome
class Revo {

	function __construct() {

		$this->url = sprintf('%s', PL_CHILD_URL);
		$this->dir = sprintf('/%s', PL_CHILD_DIR);

		add_action( 'after_setup_theme', array( &$this, 'update' ),11 );

	}

	function update(){

		require_once( trailingslashit( get_stylesheet_directory() ) . 'includes/child-theme-updater.php' );

		$updater_args = array(
			'repo_uri'   => 'http://shop.ahansson.com/',
			'repo_slug'  => 'revo',
		);

		add_theme_support( 'auto-hosted-child-theme-updater', $updater_args );
		
		new Revo_Theme_Updater;
	}

}

new Revo;