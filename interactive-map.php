<?php
/*
Template Name: Interactive Map
*/

get_header(); ?>

	<div id="primary" class="content-area">
	    <main id="main" class="site-main">
            <?php 
                $map_key = get_theme_mod('tb_theme_interactive_map_key');
                if ( ! empty( $map_key ) ) { ?>
		            <iframe id="full-page-map" src="<?php echo esc_url( $map_key ); ?>"></iframe>
                <?php } ?>    
        </main><!-- #main -->
	</div><!-- #primary -->
<?php
get_template_part('sidebar-left');
get_template_part('sidebar-right');
get_footer();
