<?php
/*
  Template Name: Full Width
 */
?>
<?php
$options            = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );
$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";
$sidebar_is_active  = is_active_sidebar( 'sidebar-appr' );
?>

<?php if ( have_posts() ): ?>
	<?php
	while ( have_posts() ):
		?>
		<?php the_post(); ?>
		<?php get_template_part( "appr/header" ); ?>

		<div class="wrp cnt">
			<?php get_template_part( 'appr/breadcrumbs' ); ?>

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