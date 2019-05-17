<?php
$options            = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );
$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";
$sidebar_is_active  = is_active_sidebar( 'sidebar-appr' );
if ( ! $sidebar_is_active ) {
	$main_content_class = "fullWidth";
}
?>

<?php if ( have_posts() ): ?>
	<?php
	while ( have_posts() ):
		?>
		<?php the_post(); ?>
		<?php get_template_part( "appr/header" ); ?>

		<div class="wrp cnt">
			<?php get_template_part( 'appr/breadcrumbs' ); ?>

			<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
				<?php get_template_part( "appr/sidebar" ); ?>
			<?php endif; ?>

			<?php if ( $sidebar_is_active ): ?>
			<div class="bSeCont">
				<?php endif; ?>
				<section class="bSe <?php echo $main_content_class; ?>">

					<?php get_template_part( "appr/content-single" ); ?>

				</section>
				<?php if ( $sidebar_is_active ): ?>
			</div>
		<?php endif; ?>

			<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
				<?php get_template_part( "appr/sidebar" ); ?>
			<?php endif; ?>
			<div class="clear"></div>

		</div>


		<?php
	endwhile;
	?>
<?php else: ?>
	<!--No contents-->
<?php endif ?>
<?php get_template_part( "appr/footer" ); ?>