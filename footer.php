<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Newton
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php get_sidebar( 'right' ); ?>

		<div id="site-info" class="site-info">
			<span class="site-info-top"><?php echo esc_html__( 'Powered by ', 'newton' ) ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'newton' ) ); ?>" rel="generator">WordPress</a></span>
			<span class="site-info-bottom"><?php printf( esc_html__( '%1$s by %2$s', 'newton' ), '<a href="https://michaelvandenberg.com/themes/#newton" rel="theme">The Newton theme</a>', '<a href="https://michaelvandenberg.com/" rel="designer">Michael Van Den Berg</a>' ); ?></span>
		</div><!-- #site-info -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<a href="#content" class="back-to-top"><span class="genericon genericon-top"></span></a>

<?php wp_footer(); ?>

</body>
</html>
