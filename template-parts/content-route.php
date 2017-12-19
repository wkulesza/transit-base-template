<?php
/**
 * Template part for displaying routes
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Transit_Base_Template
 */

?>

<div class="single-route route">

	<?php the_route_title(); ?>

	<div class="entry-content">
		
		<?php the_route_description(); ?>
		
		<?php tcp_do_alerts( array('collapse' => 'false' ) ); ?>
		
		<!-- TODO: Include option of timetable toggle buttons and JS -->
		
		<?php the_timetables(); ?>
		
	</div><!-- .entry-content -->

</div>