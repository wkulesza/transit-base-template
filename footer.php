<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Transit_Base_Template
 */

?>

		</div><!-- #content -->
	</div><!-- .content-wrap -->

	<footer id="colophon" class="site-footer">
		<div id="footer-content">
			<?php wp_nav_menu( array( 'theme_location' => 'menu-2' ) ); ?>
			<div class="site-info">
				<span>Copyright &copy; <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?> </span>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'transit-base-template' ) ); ?>"><?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'transit-base-template' ), 'WordPress' );
				?></a>
				<span class="sep"> | </span>
				<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %1$s by %2$s.', 'transit-base-template' ), 'transit-base-template', '<a href="http://underscores.me/">Trillium Solutions</a>' );
				?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
