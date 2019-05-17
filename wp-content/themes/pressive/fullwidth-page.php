<?php
/*
  Template Name: Full Width
 */
?>
<?php
$options = thrive_get_options_for_post( get_the_ID() );

$post_format         = get_post_format();
$post_format_options = _thrive_get_post_format_fields( $post_format, get_the_ID() );

// conflict with The Events Calendar plugin - post content appearing twice
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		get_header();
	}
}
wp_reset_query();
?>

<?php if ( have_posts() ): ?>
	<?php
	while ( have_posts() ):
		?>
		<?php the_post(); ?>

		<div class="wrp cnt">
			<?php get_template_part( 'partials/breadcrumbs' ); ?>

			<section class="bSe fullWidth">


				<?php if ( $post_format == "audio" && $options['featured_image_style'] == "wide" && has_post_thumbnail() && $post_format_options['audio_type'] != "soundcloud" ): ?>
					<?php $featured_image = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] ) ?>
					<div class="fwit">
						<img src="<?php echo $featured_image['image_src'] ?>"
						     alt="<?php echo $featured_image['image_alt'] ?>"
						     title="<?php echo $featured_image['image_title'] ?>"/>
					</div>
				<?php endif; ?>

				<?php if ( $post_format == "audio" ): ?>
					<?php if ( $post_format_options['audio_type'] != "soundcloud" ): ?>
						<?php echo do_shortcode( "[audio src='" . $post_format_options['audio_file'] . "'][/audio]" ); ?>
					<?php else: ?>
						<?php echo $post_format_options['audio_soundcloud_embed_code']; ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				if ( $post_format == "gallery" ):
					$thrive_meta_postformat_gallery_images = get_post_meta( get_the_ID(), '_thrive_meta_postformat_gallery_images', true );
					$thrive_gallery_ids = explode( ",", $thrive_meta_postformat_gallery_images );
					?>
					<?php
					if ( count( $thrive_gallery_ids ) > 0 ):
						$first_img_url = wp_get_attachment_url( $thrive_gallery_ids[0] );
						?>
						<div class="awr">
							<div class="hui hru fha "
							     style="background-image: url('<?php echo trim( $first_img_url ); ?>');"
							     id="thrive-gallery-header" data-count="<?php echo count( $thrive_gallery_ids ); ?>"
							     data-index="0">
								<img id="thive-gallery-dummy" class="gallery-dmy"
								     src="<?php echo trim( $first_img_url ); ?>" alt="">

								<div class="gnav clearfix">
									<div class="gwrp">
										<a class="gprev" href=""></a>
										<ul class="clearfix">
											<?php
											foreach ( $thrive_gallery_ids as $key => $id ):
												$img_url = wp_get_attachment_url( $id );
												if ( $img_url ):
													?>
													<li id="li-thrive-gallery-item-<?php echo $key; ?>">
														<a class="thrive-gallery-item" href=""
														   style="background-image: url('<?php echo $img_url; ?>');"
														   data-image="<?php echo $img_url; ?>"
														   data-index="<?php echo $key; ?>"></a>
													</li>
													<?php
												endif;
											endforeach;
											?>
										</ul>
										<a class="gnext" href=""></a>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $post_format == "image" && has_post_thumbnail() ): ?>
					<?php $featured_image = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] ) ?>
					<div class="fwit">
						<img src="<?php echo $featured_image['image_src'] ?>"
						     alt="<?php echo $featured_image['image_alt'] ?>"
						     title="<?php echo $featured_image['image_title'] ?>"/>
					</div>
				<?php endif; ?>

				<div
					class="awr <?php if ( $options['meta_post_date'] == 1 || ( ! empty( $options['comments_on_pages'] ) && $options['meta_comment_count'] == 1 && get_comments_number() > 0 ) ): ?>h-me<?php endif; ?>">
					<div class="meta">
						<?php if ( $options['meta_post_date'] == 1 ): ?>
							<div class="met-d">
								<?php echo get_the_date( "M" ); ?>
								<span><?php echo get_the_date( "d" ); ?></span>
							</div>
						<?php endif; ?>
						<div class="met-c"
						     <?php if ( empty( $options['comments_on_pages'] ) || $options['meta_comment_count'] != 1 || get_comments_number() == 0 ): ?>style='display:none;'<?php endif; ?>>
							<div>
								<a href="#comments"><span></span> <?php echo get_comments_number(); ?></a>
							</div>
						</div>
					</div>
					<div class="awr-i">

						<?php if ( ( $options['featured_image_style'] == "wide" ) && $post_format != "audio" && $post_format != "gallery" && $post_format != "quote" && $post_format != "image" && $post_format != "video" && has_post_thumbnail() ): ?>
							<?php $featured_image = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] ) ?>
							<div class="fwit">
								<img src="<?php echo $featured_image['image_src'] ?>"
								     alt="<?php echo $featured_image['image_alt'] ?>"
								     title="<?php echo $featured_image['image_title'] ?>"/>
							</div>
						<?php endif; ?>

						<?php if ( ( $options['featured_image_style'] == "thumbnail" ) && $post_format != "quote" && $post_format != "image" && $post_format != "video" && has_post_thumbnail() ): ?>
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

						<?php if ( isset( $options['bottom_about_author'] ) && $options['bottom_about_author'] == 1 ): ?>
							<?php get_template_part( "partials/authorbox" ); ?>
						<?php endif; ?>

						<?php _thrive_render_bottom_related_posts( get_the_ID(), $options ); ?>

						<?php if ( ! post_password_required() && ( ! is_page() || ( is_page() && $options['comments_on_pages'] != 0 ) ) ) : ?>
							<?php comments_template( '', true ); ?>
						<?php elseif ( ( ! comments_open() || post_password_required() ) && get_comments_number() > 0 ): ?>
							<?php comments_template( '/comments-disabled.php' ); ?>
						<?php endif; ?>

						<?php
						$prev_post = get_adjacent_post( false, '', true );
						$next_post = get_adjacent_post( false, '', false );
						if ( isset( $options['bottom_previous_next'] ) && $options['bottom_previous_next'] == 1 && get_permalink( $prev_post ) != "" && get_permalink( $next_post ) != "" ):
							?>
							<div class="pnav">
								<a class="pav left" href="<?php echo get_permalink( $prev_post ); ?>">
									<span><?php _e( "Previous Post", 'thrive' ); ?></span>
									<span><?php echo get_the_title( $prev_post ); ?></span>
								</a>
								<a class="pav right" href="<?php echo get_permalink( $next_post ); ?>">
									<span><?php _e( "Next Post", 'thrive' ); ?></span>
									<span><?php echo get_the_title( $next_post ); ?></span>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</div>

			</section>

			<div class="clear"></div>

		</div>
		<?php
	endwhile;
	?>
<?php else: ?>
	<!--No contents-->
<?php endif ?>
<?php get_footer(); ?>