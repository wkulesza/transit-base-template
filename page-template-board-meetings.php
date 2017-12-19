<?php
/**
* Template Name: Board Meetings
*
* @package Transit_Base_Template
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'board-meetings' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_template_part('sidebar-left');
get_template_part('sidebar-right');
get_footer();