<?php
/*
	Section: Revo Latest
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://revo.ahansson.com
	Version: 1.0
	Description: Custom section in Revo - a PageLines Child Theme made by Aleksander Hansson
	Class Name: RevoLatest
	Workswith: main, templates
	Cloning: true
	V3: true
*/

class RevoLatest extends PageLinesSection {

	function section_styles() {

	}

	function section_head() {

	}

	function section_template() {;

		$post_per_page = $this->opt('number_of_posts', $this->oset) ? $this->opt('number_of_posts', $this->oset): 3;

		$args = array(
		    'orderby' => 'post_date',
		    'posts_per_page' => $post_per_page,
		);
		$query = new WP_Query($args);

		if($query->have_posts()) {

			while($query->have_posts()) : $query->the_post();

			global $post;

			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );

				?>

					<div class="row revo-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="span4">
							<div class="entry-meta">
								<div class="revo-meta">
									<div><strong>Meta:</strong></div>
								</div>
								<div class="revo-author">
									<i class="icon-user"></i>
									<?php the_author_posts_link(); ?>
								</div>
								<div class="revo-date">
									<i class="icon-calendar"></i>
									<abbr class="published" title="<?php the_time(__('l, F jS, Y, g:i a', 'revo')); ?>"><?php the_time(__('F j, Y', 'revo')); ?></abbr>
								</div>
								<div class="revo-categories">
									<i class="icon-reorder"></i>
									<?php the_category(', '); ?>
								</div>
								<div class="revo-tags">
									<i class="icon-tags"></i>
									<?php the_tags(' '); ?>
								</div>
							</div>
						</div>


						<div class="span8 revo-postloop-content">

							<div class="revo-postloop-thumbnail">
								<a href="<?php get_permalink(); ?>"><img class="attachment-thumbnail" src="<?php echo $thumb['0']; ?>"></a>
							</div>
							<div class="revo-postloop-title">
								<?php the_title('<h3><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h3>');?>
							</div>

						</div>

					</div>

				<?php

			endwhile;

			$postsPageId = get_option('page_for_posts');

			?>

				<div class="center">

					<a class="btn btn-primary" href="index.php?p=<?php echo $postsPageId; ?>"><strong>Visit Our Blog &rarr;</strong></a>

				</div>

			<?php

		} else {

			?>

				<p class="no-posts"><?php _e('There is no posts to show!', 'revo'); ?></p>

			<?php

		}

	}

	function section_opts() {

		$options = array();

		$options[] = array(

			'title' => __( 'Settings', 'revo' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
		            'key'           => 'number_of_posts',
		            'type'          => 'count_select',
		            'label'			=> __( 'Number of posts to show', 'revo' ),
		            'count_start'   => 1,               // Starting Count Number
		            'count_number'  => 20,             // Ending Count Number
		        ),
		    )
		);

		return $options;
	}

}
