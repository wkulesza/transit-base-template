<?php
/**
 * Template part for displaying board meeting content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Transit_Base_Template
 */

?>

<article <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();

			$archive_year = date("Y");
			if(isset($_GET['archiveyear'])) {
				$archive_year = sanitize_text_field($_GET['archiveyear']);
			}
			?>
			
			<!-- TODO: Automatically infer first year of board meetings -->
			<form method="get" action="">
				<label for="archiveyear">Show different year: </label>
				<select name="archiveyear" id="archiveyear">
					<?php
					$cur = date("Y");
					$first = 2015;
					$range = range($cur, $first);
					foreach($range as $r) {
						echo '<option value="'.$r.'">'.$r.'</option>';
					}
					?>
				</select>
				<input type="submit" value="Get Meetings" />
			</form>
			
			<?php
				$args = array(
					'post_type' => 'board-meeting',
					'meta_key' => 'meeting_date',
					'order' => 'ASC',
					'posts_per_page' => -1,
					'year'	=> $archive_year
				);
				$q = new WP_Query($args);
				if ( $q->have_posts() ) :
			?>
			
			<!-- TODO: Use fields from plugin (get_options). warning: still not set up yet. -->
				
					<h2><?php echo $archive_year; ?> Meeting dates, agendas, and minutes</h2>
					<table id="board-meeting-table" style="text-align: center;">
	
					<tr>
						<th>Meeting</th>
						<th>Date</th>
					</tr>
	
					<?php while ( $q->have_posts() ) : $q->the_post(); ?>
					
						<tr>
							<td><?php the_title(); ?></td>
							<td>
								<?php echo date_format( new DateTime(
									get_post_meta(get_the_ID(), 'meeting_date', true)
								),"F j, Y"); ?>
							</td>
						</tr>
					
					<?php endwhile; wp_reset_postdata(); ?>
					</table>
					
			<?php endif; ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'transit_base_template' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'transit_base_template' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->