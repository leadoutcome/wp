<?php
$options = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );

$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";
$sidebar_is_active  = is_active_sidebar( 'sidebar-appr' );
if ( ! $sidebar_is_active ) {
	$main_content_class = "fullWidth";
}
$post_template = _thrive_get_item_template( get_the_ID() );
?>

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
				<?php if ( have_posts() ): ?>
					<?php
					while ( have_posts() ):
						?>
						<?php the_post(); ?>


						<div class="awr">
							<div class="awr-i">

								<?php if ( $options['featured_image_style'] == "wide" && has_post_thumbnail() ): ?>
									<?php $featured_image = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] ) ?>
									<div class="fwit">
										<img src="<?php echo $featured_image['image_src'] ?>"
										     alt="<?php echo $featured_image['image_alt'] ?>"
										     title="<?php echo $featured_image['image_title'] ?>"/>
									</div>
								<?php endif; ?>

								<?php if ( $options['featured_image_style'] == "thumbnail" && has_post_thumbnail() ): ?>
									<?php $featured_image = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] ) ?>
									<span class="thi">
                                        <img src="<?php echo $featured_image['image_src'] ?>"
                                             alt="<?php echo $featured_image['image_alt'] ?>"
                                             title="<?php echo $featured_image['image_title'] ?>"/>
                                    </span>
								<?php endif; ?>

								<div class="tve-c">
									<?php the_content(); ?>
									<?php if ( $options['enable_social_buttons'] == 1 ): ?>
										<?php get_template_part( 'share-buttons' ); ?>
									<?php endif; ?>
								</div>

								<div class="clear"></div>

								<?php
								if ( thrive_check_bottom_focus_area() ):
									thrive_render_top_focus_area( "bottom" );
								endif;
								?>

								<?php if ( ! post_password_required() && $options['comments_on_pages'] != 0 ) : ?>
									<?php comments_template( '', true ); ?>
								<?php elseif ( ( ! comments_open() || post_password_required() ) && get_comments_number() > 0 ): ?>
									<?php comments_template( '/comments-disabled.php' ); ?>
								<?php endif; ?>

							</div>
						</div>

						<?php
					endwhile;
					?>
				<?php else: ?>
					<!--No contents-->
				<?php endif ?>
			</section>
			<?php if ( $sidebar_is_active ): ?>
		</div>
	<?php endif; ?>

		<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
			<?php get_template_part( "appr/sidebar" ); ?>
		<?php endif; ?>
		<div class="clear"></div>

	</div>
<?php get_template_part( "appr/footer" ); ?>