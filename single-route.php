<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Transit_Base_Template
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post();
		
			the_route_title();
			 
		?>
		
			<div class="entry-content">
				
				<?php the_route_description(); ?>
				
				<?php tcp_do_alerts( array('collapse' => 'false' ) ); ?>
				
				<!-- TODO: Include option of timetable toggle buttons and JS -->
				
				<?php the_timetables(); ?>
				
			</div>
		
		<?php
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_template_part('sidebar-left');
get_template_part('sidebar-right');
get_footer();