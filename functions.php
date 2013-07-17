<?php

// Load Framework - don't delete this shit
require_once( dirname(__FILE__) . '/setup.php' );

// Load our shit in a class cause it's awesome
class Revo {

	function __construct() {

		// Constants
		$this->url = sprintf('%s', PL_CHILD_URL);
		$this->dir = sprintf('/%s', PL_CHILD_DIR);

		// Add a filter so we can build a few custom LESS vars
		add_filter( 'get_search_form', array(&$this, 'my_search_form' ));

	}

}
new Revo;