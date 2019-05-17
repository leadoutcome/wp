<?php
/*
  Template Name: Landing Page
 */
?>
<?php
$options            = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );
$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";
$sidebar_is_active  = is_active_sidebar( 'sidebar-appr' );
if ( ( $options['featured_title_bg_type'] == 'solid' || $options['featured_title_bg_type'] == "color" ) && $options['show_post_title'] == 0 && get_post_meta( get_the_ID(), "_thrive_meta_show_content_title", true ) != 1 ) {
	$container_class = 'n-t-s';
} else if ( $options['featured_title_bg_type'] == 'image' && $options['show_post_title'] == 0 && get_post_meta( get_the_ID(), "_thrive_meta_show_content_title", true ) != 1 ) {
	$container_class = 'n-t-i';
} else {
	$container_class = '';
}
?>

<?php if ( have_posts() ): ?>
	<?php
	while ( have_posts() ):
		?>
		<?php the_post(); ?>
		<?php get_header( "landing" ); ?>

		<div class="wrp cnt lnd <?php echo $container_class; ?>">

			<?php
			if ( thrive_check_top_focus_area() ):
				thrive_render_top_focus_area();
			endif;
			?>

			<section class="bSe fullWidth">

				<?php get_template_part( "appr/content-single" ); ?>

			</section>

			<div class="clear"></div>

		</div>
		<?php
	endwhile;
	?>
<?php else: ?>
	<!--No contents-->
<?php endif ?>
<?php get_template_part( "appr/footer" ); ?>