<?php
/*
	Section: Squared
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://squared.ahansson.com
	Description: Squared is an interactive grid system that supports up to 15 images or icons with your custom text. It is awesome!
	Class Name: Squared
	Cloning: true
	v3: true
	Filter: format
*/

class Squared extends PageLinesSection {

	function section_styles() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'jquery-ui-core' );

		wp_enqueue_script( 'jquery-mousewheel', $this->base_url.'/js/jquery.mousewheel.min.js' );

		wp_enqueue_script( 'jquery-mcustomscrollbar', $this->base_url.'/js/jquery.mCustomScrollbar.min.js' );

		wp_enqueue_script( 'jquery-usquare', $this->base_url.'/js/jquery.usquare.js' );

	}

	function section_head() {

		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';


		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					$("#squared<?php echo $prefix; ?>").uSquare({
						opening_speed:		300,
						closing_speed:		500,
						easing:				'swing'
					});

				});
			</script>
		<?php

	}

	function section_template() {

		$clone_id = $this->get_the_id();

		$prefix = ($clone_id != '') ? 'Clone'.$clone_id : '';

		$squared_array = $this->opt('squared_array');

		$format_upgrade_mapping = array(
			'image'	=> 'squared_image_%s',
			'arrow'	=> 'squared_arrow_%s',
			'filter'	=> 'squared_filter%s',
			'link'	=> 'squared_link_%s',
			'background_color'	=> 'squared_background_color_%s',
			'head'	=> 'squared_about_head_%s',
			'head_color'	=> 'squared_head_color_%s',
			'subhead'	=> 'squared_subhead_%s',
			'subhead_color'	=> 'squared_subhead_color_%s',
			'about_head_color'	=> 'squared_about_head_color_%s',
			'about_head'	=> 'squared_about_head_%s',
			'about_body'	=> 'squared_about_body_color_%s',
			'icons_1'	=> 'squared_icons_%s1',
			'icons_link_1'	=> 'squared_icons_link_%s1',
			'icons_2'	=> 'squared_icons_%s2',
			'icons_link_2'	=> 'squared_icons_link_%s2',
			'icons_3'	=> 'squared_icons_%s3',
			'icons_link_3'	=> 'squared_icons_link_%s3',
			'icons_4'	=> 'squared_icons_%s4',
			'icons_link_4'	=> 'squared_icons_link_%s4',
			'icons_5'	=> 'squared_icons_%s5',
			'icons_link_5'	=> 'squared_icons_link_%s5',
			'icons_6'	=> 'squared_icons_%s6',
			'icons_link_6'	=> 'squared_icons_link_%s6',
			'icons_7'	=> 'squared_icons_%s7',
			'icons_link_7'	=> 'squared_icons_link_%s7',
			'icons_8'	=> 'squared_icons_%s8',
			'icons_link_8'	=> 'squared_icons_link_%s8'
		);


		$squared_array = $this->upgrade_to_array_format( 'squared_array', $squared_array, $format_upgrade_mapping, $this->opt('squared_squares'));

		// must come after upgrade
		if( !$squared_array || $squared_array == 'false' || !is_array($squared_array) ){
			$squared_array = array( array(), array(), array() );
		}

		printf('<div id="squared%s" class="usquare_module_wrapper">', $prefix ) ;

			?>

			<div id="squared" class="usquare_module_wrapper">

				<div class="usquare_module_shade"></div>
					<?php

						if ( $this->opt( 'squared_position' ) == 'right' ) {
							$array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30);
						} elseif ( $this->opt( 'squared_position' ) == 'left' ){
							$array = array('');
						} elseif ( $this->opt( 'squared_position' ) == 'mixed_right' ){
							$array = array(1,2,3,7,8,9,13,14,15,19,20,21,25,26,27);
						} else {
							$array = array(4,5,6,10,11,12,16,17,18,22,23,24,28,29,30);
						}

						$output = '';

						$i=1;

						if( is_array($squared_array) ){

							$squares = count( $squared_array );

							foreach( $squared_array as $square ){

								if ( pl_array_get( 'image', $square ) ) {

									$the_background_color = ( pl_array_get( 'background_color', $square ) ) ? pl_hashify( pl_array_get( 'background_color', $square ) ) : '#444444' ;

									$the_img = pl_array_get( 'image', $square );

									$the_head_color = ( pl_array_get( 'head_color', $square ) ) ? pl_hashify( pl_array_get( 'head_color', $square ) ) : '#ffffff' ;

									$the_subhead_color = ( pl_array_get( 'subhead_color', $square ) ) ? pl_hashify( pl_array_get( 'subhead_color', $square ) ) : '#ffffff' ;

									$the_about_head_color = ( pl_array_get( 'about_head_color', $square ) ) ? pl_hashify( pl_array_get( 'about_head_color', $square ) ): '#000' ;

									$the_about_head = ( pl_array_get( 'about_head', $square ) ) ? sprintf( '<span data-sync="squared_array_item%s_about_head" class="bold" style="color:%s;">%s</span>', $i, $the_about_head_color, pl_array_get( 'about_head', $square ) ) :'' ;

									$the_about_body_color = ( pl_array_get( 'about_body_color', $square ) ) ? pl_hashify( pl_array_get( 'about_body_color', $square ) ) : '#000' ;

									$the_about_body = ( pl_array_get( 'about_body', $square ) ) ? sprintf( '<div data-sync="squared_array_item%s_about_body" class="usquare_about" style="color:%s;">%s</div>', $i, $the_about_body_color, pl_array_get( 'about_body', $square ) ) :'' ;

									$filter = ( !pl_array_get( 'filter', $square ) ) ? 'usquare_filter' : '' ;

									$img = ( $the_img ) ? sprintf( '<img src="%s" class="usquare_square %s" />', $the_img, $filter) : '' ;

									if ( pl_array_get( 'icons_1', $square ) ) {
										$icons1 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_1', $square ), pl_array_get( 'icons_1', $square ) );
									} else {
										$icons1 ='';
									}
									if ( pl_array_get( 'icons_2', $square ) ) {
										$icons2 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_2', $square ), pl_array_get( 'icons_2', $square ) );
									} else {
										$icons2 ='';
									}
									if ( pl_array_get( 'icons_3', $square ) ) {
										$icons3 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_3', $square ), pl_array_get( 'icons_3', $square ) );
									} else {
										$icons3 ='';
									}
									if ( pl_array_get( 'icons_4', $square ) ) {
										$icons4 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_4', $square ), pl_array_get( 'icons_4', $square ) );
									} else {
										$icons4 ='';
									}
									if ( pl_array_get( 'icons_5', $square ) ) {
										$icons5 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_5', $square ), pl_array_get( 'icons_5', $square ) );
									} else {
										$icons5 ='';
									}
									if ( pl_array_get( 'icons_6', $square ) ) {
										$icons6 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_6', $square ), pl_array_get( 'icons_6', $square ) );
									} else {
										$icons6 ='';
									}
									if ( pl_array_get( 'icons_7', $square ) ) {
										$icons7 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_7', $square ), pl_array_get( 'icons_7', $square ) );
									} else {
										$icons7 ='';
									}
									if ( pl_array_get( 'icons_8', $square ) ) {
										$icons8 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', pl_array_get( 'icons_link_8', $square ), pl_array_get( 'icons_8', $square ) );
									} else {
										$icons8 ='';
									}

									if ( in_array( $i, $array, true ) ) {

										$the_head = ( pl_array_get( 'head', $square ) ) ? sprintf( '<h3 data-sync="squared_array_item%s_head" class="usquare_r" style="color:%s;">%s</h3>', $i, $the_head_color, pl_array_get( 'head', $square ) ) : '' ;

										$the_subhead = ( pl_array_get( 'subhead', $square ) ) ? sprintf( '<span data-sync="squared_array_item%s_subhead" class="usquare_r" style="color:%s;">%s</span>', $i, $the_subhead_color, pl_array_get( 'subhead', $square ) ) : '' ;

										$arrow = ( !$this->opt( 'squared_arrow_'.$i ) ) ? sprintf('<img src="%s" class="usquare_arrow usquare_arrow_r" alt="arrow" />', $this->base_url.'/img/arrow_r.png') : '' ;

										$close = sprintf('<a href="#" class="close close_left_side"><i class="icon-remove"></i></a>');

										$img_position = sprintf('<div class="usquare_square usquare_square_bg%s"><div class="usquare_square_text_wrapper usquare_square_right">%s<div class="row"></div>%s%s<div class="row"></div></div></div>%s', $i, $arrow, $the_head, $the_subhead, $img );

									} else {

										$the_head = ( pl_array_get( 'head', $square ) ) ? sprintf( '<h3 data-sync="squared_array_item%s_head" style="color:%s;">%s</h3>', $i, $the_head_color, pl_array_get( 'head', $square ) ) : '' ;

										$the_subhead = ( pl_array_get( 'subhead', $square ) ) ? sprintf( '<span data-sync="squared_array_item%s_subhead" style="color:%s;">%s</span>', $i, $the_subhead_color, pl_array_get( 'subhead', $square ) ) : '' ;

										$arrow = ( !$this->opt( 'squared_arrow_'.$i ) ) ? sprintf('<img src="%s" class="usquare_arrow" alt="arrow" />', $this->base_url.'/img/arrow.png') : '' ;

										$close = sprintf('<a href="#" class="close"><i class="icon-remove"></i></a>');

										$img_position = sprintf('%s<div class="usquare_square usquare_square_bg%s"><div class="usquare_square_text_wrapper">%s<div class="row"></div>%s%s<div class="row"></div></div></div>', $img, $i, $arrow, $the_head, $the_subhead );

									}

									if ( $the_img && $link ) {
										$output .= sprintf( '<a href="%s" target="_blank"><div class="usquare_block_link" style="background-color:%s;">%s</div></a>', $link, $the_background_color, $img_position );
									} elseif ( $the_img ) {
										$output .= sprintf( '<div class="usquare_block" style="background-color:%s;">%s<div class="usquare_block_extended usquare_square_bg%s" style="background-color:%s;">%s<ul class="social_background">%s%s%s%s%s%s%s%s</ul><div class="row"></div>%s%s</div></div>', $the_background_color, $img_position, $i, $the_background_color, $close, $icons1, $icons2, $icons3, $icons4, $icons5, $icons6, $icons7, $icons8, $the_about_head, $the_about_body );
									} else {
										$output .='';
									}

								}

								$i++;

							}
						}

						if ( $output == '' ) {
							$this->do_defaults();
						} else {
							echo $output;

						}

					?>

			</div>

		<?php
	}

	function do_defaults() {
		echo setup_section_notify($this, __('Please set up Squared.', 'squared'));
	}

	function section_opts() {

		$options = array();

		$how_to_use = __( '
		<strong>Read the instructions below before asking for additional help:</strong>
		</br></br>
		<strong>1.</strong> In the frontend editor, drag the Squared section to a template of your choice.
		</br></br>
		<strong>2.</strong> Edit settings for Squared.
		</br></br>
		<strong>3.</strong> When you are done, hit "Publish" and refresh to see changes.
		</br></br>
		<div class="row zmb">
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://forum.pagelines.com/71-products-by-aleksander-hansson/" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-ambulance"></i>          Forum</a>
				</div>
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://betterdms.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-align-justify"></i>          Better DMS</a>
				</div>
			</div>
			<div class="row zmb" style="margin-top:4px;">
				<div class="span12 tac zmb">
					<a class="btn btn-success" href="http://shop.ahansson.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-shopping-cart" ></i>          My Shop</a>
				</div>
			</div>
		', 'squared' );

		$options[] = array(
			'key' => 'squared_help',
			'type'     => 'template',
			'template'      => do_shortcode( $how_to_use ),
			'title' =>__( 'How to use:', 'squared' ) ,
		);

		$options[] = array(
			'key' => 'squared_settings',
			'title' => __( 'Settings', 'squared' ),
			'type'	=> 'multi',
			'opts'	=> array(
		        array(
		            'key'           => 'squared_position',
		            'type'          => 'select',
		            'label'			=> __( 'Position of icon', 'squared' ),
		            'default'		=> 'mixed_left',
		            'opts'			=> array(
		            	'left'			=> array( 'name' => __( 'Icon on left', 'squared' ) ),
		            	'right'			=> array( 'name' => __( 'Icon on right', 'squared' ) ),
		            	'mixed_left'	=> array( 'name' => __( 'Icon mixed for each row, left start', 'squared' ) ),
		            	'mixed_right'	=> array( 'name' => __( 'Icon mixed for each row, right start', 'squared' ) ),
		            ),
		        ),
		    )
		);

		$options[] = array(
			'key'		=> 'squared_array',
		   	'type'		=> 'accordion',
			'title'		=> __('Squared Setup', 'squared'),
			'post_type'	=> __('Square ', 'squared'),
			'opts'	=> array(
				array(
			 		'key' =>	'image',
					'label'  => __( 'Squared Image', 'squared' ),
					'type'   => 'image_upload',
					'help'   => __( 'Upload an image... </br>Recommended image size: 160x160</br>Images will scale to match the size of the square, not crop.', 'squared' ),
				),
				array(
				 	'key' =>	'arrow',
					'label'  => __( 'Hide arrow?', 'squared' ),
					'type'   => 'check',
				),
				array(
				 	'key' =>	'filter',
					'label'  => __( 'Remove grayscale filter?', 'squared' ),
					'type'   => 'check',
				),
				array(
					'key' =>'link',
					'label'  => __( 'Squared Link', 'squared' ),
					'type'   => 'text',
					'help'   => __( 'Square links to (If this is set, there will be no dropdown)', 'squared' ),
				),
				array(
					'key' =>	'background_color',
					'label' => __( 'Squared Background Color', 'squared' ),
					'type'   => 'color',
					'help'   => __( 'Select a background color...', 'squared' ),
					'default' => '444444',
				),
				array(
					'key' => 'head',
					'label' => __( 'Squared Heading', 'squared' ),
					'type'   => 'text',
				),
				array(
					'key' => 'head_color',
					'label' => __( 'Squared Head Color', 'squared' ),
					'type'   => 'color',
					'help'   => __( 'Add a heading text and select a color.. </br>Recommended character limit: 20', 'squared' ),
					'default' => 'ffffff',
				),
				array(
					'key' => 'subhead',
					'label' => __( 'Squared Subheading', 'squared' ),
					'type'   => 'text',
				),
				array(
					'key' => 'subhead_color',
					'label' => __( 'Subhead Color', 'squared' ),
					'type'   => 'color',
					'help'   => __( 'Add a subheading and select a color.. </br>Recommended character limit: 35', 'squared' ),
					'default' => 'ffffff',
				),
				array(
					'key' => 'about_head',
					'label' => __( 'Squared About Heading', 'squared' ),
					'type'   => 'text',
				),
				array(
					'key' => 'about_head_color',
					'label' => __( 'Squared About Head Color', 'squared' ),
					'type'   => 'color',
					'help'   => __( 'Add a about header and select a color..', 'squared' ),
					'default' => 'ffffff',
				),
				array(
					'key' => 'about_body',
					'label' => __( 'Squared About Body', 'squared' ),
					'type'   => 'textarea',
				),
				array(
					'key' => 'about_body_color',
					'label' => __( 'Squared About Body Color', 'squared' ),
					'type'   => 'color',
					'help'   => __( 'Add body text and select a color..', 'squared' ),
					'default' => 'ffffff',
				),
				array(
					'key' => 'icons_1',
					'label' => __( sprintf('Font Awesome Icon %s:', '1'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_1',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '1'), 'squared' ),
                    'type'   => 'text',
                ),
				array(
					'key' => 'icons_2',
					'label' => __( sprintf('Font Awesome Icon %s:', '2'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_2',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '2'), 'squared' ),
                    'type'   => 'text',
                ),
				array(
					'key' => 'icons_3',
					'label' => __( sprintf('Font Awesome Icon %s:', '3'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_3',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '3'), 'squared' ),
                    'type'   => 'text',
                ),
				array(
					'key' => 'icons_4',
					'label' => __( sprintf('Font Awesome Icon %s:', '4'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_4',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '4'), 'squared' ),
                    'type'   => 'text',
                ),
				array(
					'key' => 'icons_5',
					'label' => __( sprintf('Font Awesome Icon %s:', '5'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_5',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '5'), 'squared' ),
                    'type'   => 'text',
               	),
				array(
					'key' => 'icons_6',
					'label' => __( sprintf('Font Awesome Icon %s:', '5'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_6',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '6'), 'squared' ),
                    'type'   => 'text',
                ),
				array(
					'key' => 'icons_7',
					'label' => __( sprintf('Font Awesome Icon %s:', '6'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_7',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '7'), 'squared' ),
                    'type'   => 'text',
                ),
				array(
					'key' => 'icons_7',
					'label' => __( sprintf('Font Awesome Icon %s:', '7'), 'squared' ),
					'type'   => 'select_icon',
				),
				array(
					'key' => 'icons_link_8',
                    'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '8'), 'squared' ),
                    'type'   => 'text',
                ),
			),
			'title'   => __( 'Square ', 'squared' ),
			'help'   => __( 'Setup options for square number ', 'squared' ),
		);

		return $options;
	}

}
