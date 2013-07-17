<?php
/*
	Section: Revo Head
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	http://revo.ahansson.com
	Description: Custom section in Revo - a PageLines Child Theme made by Aleksander Hansson
	Version: 1.0
	Class Name: RevoHead
	Workswith: main, templates
	Cloning: true
	V3: true
*/

class RevoHead extends PageLinesSection {

    var $tabID = 'revoheader_meta';

	function section_opts(  ){

		$options = array();

		$options[] = array(

			'title' 			=> __( 'Text Settings', 'revo' ),
			'type' 				=> 'multi',
			'opts'	=> array(
				array(
					'key'		=> 'revoheader_title',
					'type'		=> 'text',
					'label'		=> 'Title'
				),
				array(
					'key'	=> 	'revoheader_tagline',
					'type'	=> 	'text',
					'label'	=>	'Tagline'
				),
			)
		);

		$options[] = array(
			'key'		=> 'revoheader_menu',
			'type' 			=> 'select_menu',
			'title'			=> 'Revoheader Menu',
			'inputlabel' 	=> 'Select Revo Header Menu',
		);

		$options[] = array(
			'type' 				=> 'multi',
			'title' 			=> 'Social Buttons',
			'opts'	=> array(
				array(
					'key'		=> 'revohead_facebook',
					'type'		=> 'text',
					'label'		=> 'Facebook Link',
				),
				array(
					'key'		=> 'revohead_twitter',
					'type'		=> 'text',
					'label'		=> 'Twitter Link',
				),
				array(
					'key'		=> 'revohead_pinterest',
					'type'		=> 'text',
					'label'		=> 'Pinterest Link',
				),
				array(
					'key'		=> 'revohead_linkedin',
					'type'		=> 'text',
					'label'		=> 'LinkedIn Link',
				),
				array(
					'key'		=> 'revohead_googleplus',
					'type'		=> 'text',
					'label'		=> 'Google Plus Link',
				),
				array(
					'key'		=> 'revohead_youtube',
					'type'		=> 'text',
					'label'		=> 'YouTube Link',
				),
				array(
					'key'		=> 'revohead_github',
					'type'		=> 'text',
					'label'		=> 'GitHub Link',
				),
			)
		);

		$options[] = array(
			'key'		=> 'revoheader_meta',
			'type' 			=> 'textarea',
			'title'			=> 'Revoheader Meta',
			'inputlabel' 	=> 'Enter Revo Header Meta Text',
		);

		return $options;
	}



	/**
	* Section template.
	*/
   function section_template() {

		global $post;

		$author_id = $post->post_author;

		$author_link = get_author_posts_url( $author_id );

		$author_name = get_the_author_meta( 'display_name', $author_id );

   		if ( is_single() ) {
   			$revo_title = get_the_title();
		} elseif( $this->opt('revoheader_title', $this->oset) ) {
   			$revo_title = $this->opt('revoheader_title', $this->oset);
   		} else {
   			$revo_title = get_bloginfo('name');
   		}

		if ( is_single() ) {
   			$revo_tag = sprintf('%s <a href="%s">%s</a> %s %s', __( 'Written by', 'revo' ), $author_link, $author_name, __( 'on', 'revo' ), do_shortcode( '[post_date]' ) );
		} elseif( $this->opt('revoheader_tagline', $this->oset) ) {
			$revo_tag = $this->opt('revoheader_tagline', $this->oset) ? $this->opt('revoheader_tagline', $this->oset):'</br>';
   		} else {
   			$revo_tag = get_bloginfo('description');
   		}

		$revo_menu = ($this->opt('revoheader_menu', $this->oset)) ? $this->opt('revoheader_menu', $this->oset) : null;
		$revoheader_meta = $this->opt('revoheader_meta', $this->oset);

		$facebook = ($this->opt('revohead_facebook', $this->oset)) ? $this->opt('revohead_facebook', $this->oset) : null;

		$twitter = ($this->opt('revohead_twitter', $this->oset)) ? $this->opt('revohead_twitter', $this->oset) : null;

		$pinterest = ($this->opt('revohead_pinterest', $this->oset)) ? $this->opt('revohead_pinterest', $this->oset) : null;

		$linkedin = ($this->opt('revohead_linkedin', $this->oset)) ? $this->opt('revohead_linkedin', $this->oset) : null;

		$googleplus = ($this->opt('revohead_googleplus', $this->oset)) ? $this->opt('revohead_googleplus', $this->oset) : null;

		$youtube = ($this->opt('revohead_youtube', $this->oset)) ? $this->opt('revohead_youtube', $this->oset) : null;

		$github = ($this->opt('revohead_github', $this->oset)) ? $this->opt('revohead_github', $this->oset) : null;

		?>

			<header class="revoheader">

				<div class="inner">
				  	<?php

				  		printf('<h1 class="revoheader-title" data-sync="pagelines_revoheader_title">%s</h1>',$revo_title);

						printf('<p class="revoheader-tag" data-sync="pagelines_revoheader_tagline">%s</p>',$revo_tag);

					if ( is_single() ) {

						?>
							<div class="revohead-prev-post">

								<?php
									previous_post_link('%link', '<i class="icon-angle-left"></i>', false);
								?>
							</div>
							<div class="revohead-next-post">
								<?php
									next_post_link('%link', '<i class="icon-angle-right"></i>', false);
								?>
							</div>

						<?php
					}

				?>

				</div>
				<div class="revolinks">
					<?php
						if( is_array( wp_get_nav_menu_items( $revo_menu ) ) ) {
							wp_nav_menu(
								array(
									'menu_class'  => 'quick-links',
									'menu' => $revo_menu,
									'container' => null,
									'container_class' => '',
									'depth' => 1,
									'fallback_cb'=>''
								)
							);
						}
					?>
				
				<div class="revo-icons">

					<?php
					
						if ($facebook) {
							?>
								<a href="<?php echo $facebook; ?>"><div class="icon-facebook revo-icon revo-icon-facebook"></div></a> 
							<?php
						}

						if ($twitter) {
							?>
								<a href="<?php echo $twitter; ?>"><div class="icon-twitter revo-icon revo-icon-twitter"></div></a> 
							<?php
						}

						if ($pinterest) {
							?>
								<a href="<?php echo $pinterest; ?>"><div class="icon-pinterest revo-icon revo-icon-pinterest"></div></a> 
							<?php
						}

						if ($linkedin) {
							?>
								<a href="<?php echo $linkedin; ?>"><div class="icon-linkedin revo-icon revo-icon-linkedin"></div></a> 
							<?php
						}

						if ($googleplus) {
							?>
								<a href="<?php echo $googleplus; ?>"><div class="icon-google-plus revo-icon revo-icon-google-plus"></div></a> 
							<?php
						}

						if ($youtube) {
							?>
								<a href="<?php echo $youtube; ?>"><div class="icon-youtube revo-icon revo-icon-youtube"></div></a>
							<?php
						}

						if ($github) {
							?>
								<a href="<?php echo $github; ?>"><div class="icon-github revo-icon revo-icon-github"></div></a>
							<?php
						}


						if($revoheader_meta) {
							printf( '<div class="revometa">%s</div>', do_shortcode($revoheader_meta) );
						}

					?>
				</div>
			</header>

		<?php
	}
}