<?php tha_content_bottom(); ?>
<?php
$options        = thrive_get_options_for_post( get_the_ID() );
$f_class        = _thrive_get_element_class( "footer_container", $options );
$active_footers = array();
$num            = 0;
while ( $num < 4 ) {
	$num ++;
	if ( is_active_sidebar( 'footer-' . $num ) ) {
		array_push( $active_footers, 'footer-' . $num );
	}
}
$num_cols = count( $active_footers );
?>
</div>
</div>
<div class="clear"></div>
<?php tha_content_after(); ?>
<?php tha_footer_before(); ?>
<footer>
	<?php tha_footer_top(); ?>
	<div class="fmn">
		<div class="wrp cnt">
			<?php if ( has_nav_menu( "footer" ) ): ?>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'depth' => 1, 'menu_class' => 'footer_menu' ) ); ?>
			<?php endif; ?>
			<p class="copy">
				<?php if ( isset( $options['footer_copyright'] ) && $options['footer_copyright'] ): ?>
					<?php echo str_replace( '{Y}', date( 'Y' ), $options['footer_copyright'] ); ?>
				<?php endif; ?>
				<?php if ( isset( $options['footer_copyright_links'] ) && $options['footer_copyright_links'] == 1 ): ?>
					&nbsp;&nbsp;-&nbsp;&nbsp;Designed by
					<a href="//www.thrivethemes.com" target="_blank" style="text-decoration: underline;">Thrive Themes</a>
					| Powered by <a style="text-decoration: underline;" href="//www.wordpress.org" target="_blank">WordPress</a>
				<?php endif; ?>
			</p>

		</div>
	</div>
	<?php tha_footer_bottom(); ?>
</footer>
<?php tha_footer_after(); ?>

<?php if ( isset( $options['analytics_body_script'] ) && $options['analytics_body_script'] != "" ): ?>
	<?php echo $options['analytics_body_script']; ?>
<?php endif; ?>
<?php wp_footer(); ?>
<?php tha_body_bottom(); ?>
</body>
</html>