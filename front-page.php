<?php
/**
 * The template for displaying a static front page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Transit_Base_Template
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
			get_template_part( 'planner' );
			?>
			
			<div id="homepage-image">
				<?php
				$args = array(
					'post_type'			=> 'attachment',
					'post_mime_type'	=> 'image',
					'posts_per_page'	=> 1,
					'post_name'			=> 'homepage_image',
				);
				$img_query = new WP_Query( $args );
				printf( 
					'<img src="%s" alt="featured homepage image" />',
					$img_query->posts[0]->guid
				);
				?>
			</div>

			<?php
			get_template_part( 'homepage-widgets' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
