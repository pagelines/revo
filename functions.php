<?php

// Load Framework - don't delete this shit
require_once( dirname(__FILE__) . '/setup.php' );

// Load our shit in a class cause it's awesome
class Revo {

	function __construct() {

		// Constants
		$this->url = sprintf('%s', PL_CHILD_URL);
		$this->dir = sprintf('/%s', PL_CHILD_DIR);

		add_filter( 'get_search_form', array(&$this, 'my_search_form' ));

	}

	function my_search_form( $form ) {

	    $form = '<form action="/" method="get">
		    <fieldset>
		        <label for="search">Search in <?php echo home_url( "/" ); ?></label>
		        <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" />
		        <input type="image" alt="Search" src="<?php bloginfo( $this->dir ); ?>/images/search.png" />
		    </fieldset>
		</form>';

	    return $form;
	}

}
new Revo;