<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NWOTA
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
            <!--TODO: Get rid of 'powered by wordpress', and 'theme by'. Add link to a 'site credits page. -->
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'nwota' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'nwota' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'nwota' ), 'nwota', '<a href="https://automattic.com/" rel="designer">Trillium Transit</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
