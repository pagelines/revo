<?php
/*
	Section: Revo Contact
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://revo.ahansson.com
	Version: 1.0
	Description: Custom section in Revo - a PageLines Child Theme made by Aleksander Hansson
	Class Name: RevoContact
	Workswith: main, templates
	Cloning: true
	V3: true
*/

class RevoContact extends PageLinesSection {

	function section_styles() {

	}

	function section_head() {

	}

	function section_template() {;

		$form_id = $this->opt('revo_contact_ninja_id', $this->oset) ? $this->opt('revo_contact_ninja_id', $this->oset): false;

		if( function_exists( 'ninja_forms_display_form' ) )	{ 
			if ( $form_id ) {
				ninja_forms_display_form( $form_id );
			} else {
				echo setup_section_notify($this, __('Please set up Revo Contact.', 'revo'));
			}
		} else {
			echo 'Please install <a href="http://wpninjas.com/ninja-forms/">\'Ninja Forms\'</a>';
		}

	}

	function section_opts() {

		$options = array();

		$options[] = array(

			'title' => __( 'How to use', 'revo' ),
			'type'	=> 'multi',
			'opts'	=> array(

		        array(
		            'key'           => 'revo_contact_help',
		            'type'          => 'help',
		            'help'			=> __( '1. To use this section you first need the free plugin called <a href="http://wpninjas.com/ninja-forms/">\'Ninja Forms\'</a>. </br></br>2. Create a form and remember the form ID. </br></br>3. Input the form ID in the textfield below.', 'revo' )
		        ),
		    )
		);

		$options[] = array(

			'title' => __( 'Settings', 'revo' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
		            'key'           => 'revo_contact_ninja_id',
		            'type'          => 'text',
		            'label'			=> __( 'Ninja Form ID to show?', 'revo' )
		        ),
		    )
		);

		return $options;
	}

}