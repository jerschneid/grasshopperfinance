<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 
?>
</div>
	<footer id="colophon" role="contentinfo">
		<div class="wid960 clearfix">
			<?php
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>
		</div>
		<div id="site-generator">
			<div class="wid960 clearfix">
				<?php do_action( 'sgwp_credits' ); ?>
				<p class="fleft">Proudly powered by <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" title="<?php esc_attr( 'Semantic Personal Publishing Platform', 'sgwp' ); ?>" target="_blank">WordPress</a></p>
				<p class="fright"><a href="http://www.siteground.com/wordpress-hosting.htm" title="Managed WordPress hosting by SiteGround" target="_blank">WordPress hosting</a> by SiteGround</p>
				
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>