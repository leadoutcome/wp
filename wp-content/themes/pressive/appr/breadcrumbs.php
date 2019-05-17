<?php
$options = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );
?>
<?php if ( $options['display_breadcrumbs'] && $options['display_breadcrumbs'] == 1 && ! is_front_page() && ! is_search() && ! is_404() ): ?>
	<section class="brd">
		<ul xmlns:v="http://rdf.data-vocabulary.org/#">
			<li> <?php _e( "You are here", 'thrive' ); ?>:</li>
			<?php thrive_appr_breadcrumbs(); ?>
		</ul>
	</section>
<?php endif; ?>

<?php
if ( ( is_archive() || is_search() ) && _thrive_check_focus_area_for_pages( "archive", "top" ) ) {
	thrive_render_top_focus_area( "top", "archive" );
} elseif ( is_home() && _thrive_check_focus_area_for_pages( "blog", "top" ) ) {
	thrive_render_top_focus_area( "top", "blog" );
} elseif ( thrive_check_top_focus_area() ) {
	thrive_render_top_focus_area();
}
?>