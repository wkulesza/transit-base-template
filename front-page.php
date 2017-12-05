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
			
			<?php get_template_part( 'planner' ); ?>
			
			<?php tcp_do_alerts( array('collapse' => 'false', 'sep_affected' => ' ' ) ); ?>
			
			<?php get_template_part( 'homepage-widgets' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
