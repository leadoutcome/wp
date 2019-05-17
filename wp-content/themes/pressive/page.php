<?php
$options = thrive_get_options_for_post( get_the_ID() );

$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";

$sidebar_is_active = _thrive_is_active_sidebar();
if ( ! $sidebar_is_active ) {
	$main_content_class = "fullWidth";
}

$post_template = _thrive_get_item_template( get_the_ID() );

?>

<?php get_header(); ?>

	<div class="wrp cnt">
		<?php get_template_part( 'partials/breadcrumbs' ); ?>

		<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
			<?php get_sidebar(); ?>
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

						<div
							class="awr<?php echo ! empty( $options['comments_on_pages'] ) && ! empty( $options['meta_comment_count'] ) && get_comments_number() ? ' h-me' : '' ?>">
							<?php if ( ! empty( $options['comments_on_pages'] ) && ! empty( $options['meta_comment_count'] ) && get_comments_number() ) : ?>
								<div class="meta">
									<div class="met-c"
									     <?php if ( $options['meta_comment_count'] != 1 || get_comments_number() == 0 ): ?>style='display:none;'<?php endif; ?>>
										<div>
											<a href="#comments"><span></span> <?php echo get_comments_number(); ?></a>
										</div>
									</div>
								</div>
							<?php endif ?>
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

									<?php
									wp_link_pages( array(
										'before'           => '<div class="pgn clearfix">',
										'after'            => '</div>',
										'next_or_number'   => 'next_and_number',
										'nextpagelink'     => __( 'Next', 'thrive' ),
										'previouspagelink' => __( 'Previous', 'thrive' ),
										'echo'             => 1
									) );
									?>

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
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div class="clear"></div>

	</div>
<?php get_footer(); ?>