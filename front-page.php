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

			get_template_part( 'template-parts/asset', 'planner' );

			// Only a static front page will potentially have a featured image attached
			if ( has_post_thumbnail() ): ?>

				<div id="homepage-image">
					<?php the_post_thumbnail( 'full' ); ?>
				</div>
				<br style="clear: both; margin-bottom: 2rem;" />

			<?php endif; ?>

			
			<div id="homepage-news">
				
				<?php
				$news_query = new WP_Query( array('posts_per_page' => '3') );
				if ( $news_query->have_posts() ) :
				?>
				
				<h2>Recent News</h2>
				<ul>
					
					<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
						
						<li class="news-item">
							<a class="item-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<span class="date"> <?php the_time( get_option('date_format') ); ?></span>
						</li>
						
					<?php endwhile; ?>
					
				</ul>
				
			<?php endif; ?>
				
			</div>
			
			<?php
			
		    tcp_do_alerts( array('collapse' => 'false', 'sep_affected' => ', ' ) );
			 
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_template_part( 'homepage-widgets' );
get_footer();