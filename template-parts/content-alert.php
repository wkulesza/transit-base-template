?php
/**
 * Template part for displaying alerts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Transit_Base_Template
 */
?>

<div class="single-alert alert">

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		
    <div>
			Affected Routes: <?php echo tcp_get_affected( $post->ID ); ?>
		</div>
		<div>
			<?php echo tcp_get_alert_dates( $post->ID ); ?>
		</div>
		
	</div><!-- .entry-content -->

</div>
