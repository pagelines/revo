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

		printf('<div id="squared%s" class="usquare_module_wrapper">', $prefix ) ;

		?>
			<div id="squared" class="usquare_module_wrapper">

				<div class="usquare_module_shade"></div>
					<?php

						$squares = ( $this->opt( 'squared_squares' ) ) ? $this->opt( 'squared_squares' ) : '1' ;

						if ( $this->opt( 'squared_position' ) == 'right' ) {
							$array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30);
						} elseif ( $this->opt( 'squared_position' ) == 'left' ){
							$array = array('');
						} elseif ( $this->opt( 'squared_position' ) == 'mixed_right' ){
							$array = array(1,2,3,7,8,9,13,14,15,19,20,21,25,26,27);
						}else {
							$array = array(4,5,6,10,11,12,16,17,18,22,23,24,28,29,30);
						}

						$output = '';
						for ( $i = 1; $i <= $squares; $i++ ) {

							if ( $this->opt( 'squared_image_'.$i ) ) {

								$the_background_color = ( $this->opt( 'squared_background_color_'.$i ) ) ? pl_hashify( $this->opt( 'squared_background_color_'.$i ) ) : '#444444' ;

								$the_img = $this->opt( 'squared_image_'.$i );

								$the_head_color = ( $this->opt( 'squared_head_color_'.$i ) ) ? pl_hashify( $this->opt( 'squared_head_color_'.$i ) ) : '#ffffff' ;

								$the_subhead_color = ( $this->opt( 'squared_subhead_color_'.$i ) ) ? pl_hashify( $this->opt( 'squared_subhead_color_'.$i ) ) : '#ffffff' ;

								$the_about_head_color = ( $this->opt( 'squared_about_head_color_'.$i ) ) ? pl_hashify( $this->opt( 'squared_about_head_color_'.$i ) ): '#000' ;

								$the_about_head = ( $this->opt( 'squared_about_head_'.$i ) ) ? sprintf( '<span data-sync="squared_about_head_%s" class="bold" style="color:%s;">%s</span>', $i, $the_about_head_color, $this->opt( 'squared_about_head_'.$i) ) :'' ;

								$the_about_body_color = ( $this->opt( 'squared_about_body_color_'.$i ) ) ? pl_hashify( $this->opt( 'squared_about_body_color_'.$i ) ) : '#000' ;

								$the_about_body = ( $this->opt( 'squared_about_body_'.$i ) ) ? sprintf( '<div data-sync="squared_about_body_%s" class="usquare_about" style="color:%s;">%s</div>', $i, $the_about_body_color, $this->opt( 'squared_about_body_'.$i) ) :'' ;

								$filter = ( !$this->opt( 'squared_filter'.$i ) ) ? 'usquare_filter' : '' ;

								$img = ( $the_img ) ? sprintf( '<img data-sync="squared_image_%s" src="%s" class="usquare_square %s" />', $i, $the_img, $filter) : '' ;

								$icons_count = ( $this->opt( 'squared_about_icons_'.$i ) ) ? $this->opt( 'squared_about_icons_'.$i ) : 1 ;

								$link = ( $this->opt( 'squared_link_'.$i ) ) ? $this->opt( 'squared_link_'.$i ) : '' ;

								if ( $this->opt( 'squared_icons_'.$i.'1' ) ) {
									$icons1 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'1' ), $this->opt('squared_icons_'.$i.'1' ) );
								} else {
									$icons1 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'2' ) ) {
									$icons2 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'2' ), $this->opt('squared_icons_'.$i.'2' ) );
								} else {
									$icons2 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'3' ) ) {
									$icons3 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'3' ), $this->opt('squared_icons_'.$i.'3' ) );
								} else {
									$icons3 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'4' ) ) {
									$icons4 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'4' ), $this->opt('squared_icons_'.$i.'4' ) );
								} else {
									$icons4 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'5' ) ) {
									$icons5 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'5' ), $this->opt('squared_icons_'.$i.'5' ) );
								} else {
									$icons5 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'5' ) ) {
									$icons5 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'5' ), $this->opt('squared_icons_'.$i.'5' ) );
								} else {
									$icons5 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'6' ) ) {
									$icons6 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'6' ), $this->opt('squared_icons_'.$i.'6' ) );
								} else {
									$icons6 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'7' ) ) {
									$icons7 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'7' ), $this->opt('squared_icons_'.$i.'7' ) );
								} else {
									$icons7 ='';
								}
								if ( $this->opt( 'squared_icons_'.$i.'8' ) ) {
									$icons8 = sprintf('<li><a href="%s" target="_blank"><i class="icon-%s"></i></a></li>', $this->opt('squared_icons_link_'.$i.'8' ), $this->opt('squared_icons_'.$i.'8' ) );
								} else {
									$icons8 ='';
								}

								if ( in_array( $i, $array, true ) ) {

									$the_head = ( $this->opt( 'squared_head_'.$i ) ) ? sprintf( '<h3 data-sync="squared_head_%s" class="usquare_r" style="color:%s;">%s</h3>', $i, $the_head_color, $this->opt( 'squared_head_'.$i ) ) : '' ;

									$the_subhead = ( $this->opt( 'squared_subhead_'.$i ) ) ? sprintf( '<span data-sync="squared_subhead_%s" class="usquare_r" style="color:%s;">%s</span>', $i, $the_subhead_color, $this->opt( 'squared_subhead_'.$i ) ) : '' ;

									$arrow = ( !$this->opt( 'squared_arrow_'.$i ) ) ? sprintf('<img src="%s" class="usquare_arrow usquare_arrow_r" alt="arrow" />', $this->base_url.'/img/arrow_r.png') : '' ;

									$close = sprintf('<a href="#" class="close close_left_side"><i class="icon-remove"></i></a>');

									$img_position = sprintf('<div class="usquare_square usquare_square_bg%s"><div class="usquare_square_text_wrapper usquare_square_right">%s<div class="row"></div>%s%s<div class="row"></div></div></div>%s', $i, $arrow, $the_head, $the_subhead, $img );

								} else {

									$the_head = ( $this->opt( 'squared_head_'.$i ) ) ? sprintf( '<h3 data-sync="squared_head_%s" style="color:%s;">%s</h3>', $i, $the_head_color, $this->opt( 'squared_head_'.$i ) ) : '' ;

									$the_subhead = ( $this->opt( 'squared_subhead_'.$i ) ) ? sprintf( '<span data-sync="squared_subhead_%s" style="color:%s;">%s</span>', $i, $the_subhead_color, $this->opt( 'squared_subhead_'.$i ) ) : '' ;

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
		echo setup_section_notify($this, __('Please set up Squared.', 'Squared'));
	}

	function section_opts() {

		$options = array();

		$options[] = array(

			'title' => __( 'Settings', 'squared' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
		            'key'           => 'squared_squares',
		            'type'          => 'count_select',
		            'label'			=> __( 'Number of Squares to configure', 'squared' ),
		            'count_start'   => 1,               // Starting Count Number
		            'count_number'  => 30,             // Ending Count Number
		        ),
		        array(
		            'key'           => 'squared_position',
		            'type'          => 'select',
		            'label'			=> __( 'Position of icon', 'squared' ),
		            'default'		=> 'mixed',
		            'opts'			=> array(
		            	'left'			=> array( 'name' => __( 'Icon on left', 'squared' ) ),
		            	'right'			=> array( 'name' => __( 'Icon on right', 'squared' ) ),
		            	'mixed_left'	=> array( 'name' => __( 'Icon mixed for each row, left start', 'squared' ) ),
		            	'mixed_right'	=> array( 'name' => __( 'Icon mixed for each row, right start', 'squared' ) ),
		            ),
		        ),
		    )
		);

		$squares = ( $this->opt( 'squared_squares' ) ) ? $this->opt( 'squared_squares' ) : 1 ;

		for ( $i = 1; $i <= $squares; $i++ ) {

			$options[] = array(

				'title'   => __( 'Square ', 'Squared' ) . $i,
				'type'    => 'multi',
				'opts' => array(

					array(
					 	'key' =>	'squared_image_'.$i,
						'label'  => __( 'Squared Image', 'Squared' ),
						'type'   => 'image_upload',
						'help'   => __( 'Upload an image... </br>Recommended image size: 160x160</br>Images will scale to match the size of the square, not crop.', 'Squared' ),
					),

					array(
					 	'key' =>	'squared_arrow_'.$i,
						'label'  => __( 'Hide arrow?', 'Squared' ),
						'type'   => 'check',
					),

					array(
					 	'key' =>	'squared_filter'.$i,
						'label'  => __( 'Remove grayscale filter?', 'Squared' ),
						'type'   => 'check',
					),

					array(
						'key' =>'squared_link_'.$i,
						'label'  => __( 'Squared Link', 'Squared' ),
						'type'   => 'text',
						'help'   => __( 'Square links to (If this is set, there will be no dropdown)', 'Squared' ),
					),

					array(
						'key' =>	'squared_background_color_'.$i,
						'label' => __( 'Squared Background Color', 'Squared' ),
						'type'   => 'color',
						'help'   => __( 'Select a background color...', 'Squared' ),
						'default' => '444444',
					),

					array(
						'key' => 'squared_head_'.$i,
						'label' => __( 'Squared Heading', 'Squared' ),
						'type'   => 'text',
					),

					array(
						'key' => 'squared_head_color_'.$i,
						'label' => __( 'Squared Head Color', 'Squared' ),
						'type'   => 'color',
						'help'   => __( 'Add a heading text and select a color.. </br>Recommended character limit: 20', 'Squared' ),
						'default' => 'ffffff',
					),

					array(
						'key' => 'squared_subhead_'.$i,
						'label' => __( 'Squared Subheading', 'Squared' ),
						'type'   => 'text',
					),

					array(
						'key' => 'squared_subhead_color_'.$i,
						'label' => __( 'Subhead Color', 'Squared' ),
						'type'   => 'color',
						'help'   => __( 'Add a subheading and select a color.. </br>Recommended character limit: 35', 'Squared' ),
						'default' => 'ffffff',
					),

					array(
						'key' => 'squared_about_head_'.$i,
						'label' => __( 'Squared About Heading', 'Squared' ),
						'type'   => 'text',
					),

					array(
						'key' => 'squared_about_head_color_'.$i,
						'label' => __( 'Squared About Head Color', 'Squared' ),
						'type'   => 'color',
						'help'   => __( 'Add a about header and select a color..', 'Squared' ),
						'default' => 'ffffff',
					),

					array(
						'key' => 'squared_about_body_'.$i,
						'label' => __( 'Squared About Body', 'Squared' ),
						'type'   => 'textarea',
					),

					array(
						'key' => 'squared_about_body_color_'.$i,
						'label' => __( 'Squared About Body Color', 'Squared' ),
						'type'   => 'color',
						'help'   => __( 'Add body text and select a color..', 'Squared' ),
						'default' => 'ffffff',
					),

					array(
						'key' => 'squared_icons_'.$i.'1',
						'label' => __( sprintf('Font Awesome Icon %s:', '1'), 'Squared' ),
						'type'   => 'select_icon',
					),

					array(
						'key' => 'squared_icons_link_'.$i.'1',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '1'), 'Squared' ),
                        'type'   => 'text',
                    ),
					array(
						'key' => 'squared_icons_'.$i.'2',
						'label' => __( sprintf('Font Awesome Icon %s:', '2'), 'Squared' ),
						'type'   => 'select_icon',
					),
					array(
						'key' => 'squared_icons_link_'.$i.'2',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '2'), 'Squared' ),
                        'type'   => 'text',
                    ),
					array(
						'key' => 'squared_icons_'.$i.'3',
						'label' => __( sprintf('Font Awesome Icon %s:', '3'), 'Squared' ),
						'type'   => 'select_icon',
					),
					array(
						'key' => 'squared_icons_link_'.$i.'3',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '3'), 'Squared' ),
                        'type'   => 'text',
                    ),
					array(
						'key' => 'squared_icons_'.$i.'4',
						'label' => __( sprintf('Font Awesome Icon %s:', '4'), 'Squared' ),
						'type'   => 'select_icon',
					),
					array(
						'key' => 'squared_icons_link_'.$i.'4',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '4'), 'Squared' ),
                        'type'   => 'text',
                    ),
					array(
						'key' => 'squared_icons_'.$i.'5',
						'label' => __( sprintf('Font Awesome Icon %s:', '5'), 'Squared' ),
						'type'   => 'select_icon',
					),
					array(
						'key' => 'squared_icons_link_'.$i.'5',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '5'), 'Squared' ),
                        'type'   => 'text',
                    ),
					array(
						'key' => 'squared_icons_'.$i.'6',
						'label' => __( sprintf('Font Awesome Icon %s:', '5'), 'Squared' ),
						'type'   => 'select_icon',
					),
					array(
						'key' => 'squared_icons_link_'.$i.'6',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '6'), 'Squared' ),
                        'type'   => 'text',
                    ),
					array(
						'key' => 'squared_icons_'.$i.'7',
						'label' => __( sprintf('Font Awesome Icon %s:', '6'), 'Squared' ),
						'type'   => 'select_icon',
					),
					array(
						'key' => 'squared_icons_link_'.$i.'7',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '7'), 'Squared' ),
                        'type'   => 'text',
                    ),
					array(
						'key' => 'squared_icons_'.$i.'7',
						'label' => __( sprintf('Font Awesome Icon %s:', '7'), 'Squared' ),
						'type'   => 'select_icon',
					),
					array(
						'key' => 'squared_icons_link_'.$i.'8',
                        'label' => __( sprintf('Icon link %s: <br/>Example: "http://facebook.com".', '8'), 'Squared' ),
                        'type'   => 'text',
                    ),
				),
				'title'   => __( 'Square ', 'Squared' ) . $i,
				'help'   => __( 'Setup options for square number ', 'Squared' ) . $i,
			);

		}

		return $options;
	}

}
