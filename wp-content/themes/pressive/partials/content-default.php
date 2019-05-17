<?php
$options = thrive_get_theme_options();
if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ) {
	$author_info = _thrive_get_author_info( get_the_author_meta( 'ID' ) );
}
$post_format         = get_post_format();
$post_format_options = _thrive_get_post_format_fields( $post_format, get_the_ID() );

$featured_image       = _thrive_get_featured_image_src( $options['featured_image_style'], get_the_ID() );
$featured_image_data  = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] );
$featured_image_alt   = $featured_image_data['image_alt'];
$featured_image_title = $featured_image_data['image_title'];
?>
<article>
	<?php if ( $post_format == "quote" ): ?>
		<a href="<?php echo the_permalink(); ?>" class="q-lk">
			<div class="ind-q <?php if ( has_post_thumbnail() ): ?>ind-qi<?php endif; ?>"
			     <?php if ( has_post_thumbnail() ): ?>style="background-image: url('<?php echo _thrive_get_featured_image_src( null, get_the_ID(), "large" ); ?>')"<?php endif; ?>>
				<div class="quo">
					<h5><?php echo $post_format_options['quote_text']; ?></h5>
					<?php if ( ! empty( $post_format_options['quote_author'] ) ): ?>
						<p> - <?php echo $post_format_options['quote_author']; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</a>
	<?php elseif ( $post_format == "image" && has_post_thumbnail() ): ?>
		<div
			class="awr hasf  <?php if ( $options['meta_post_date'] == 1 || ( $options['meta_comment_count'] == 1 && get_comments_number() > 0 ) ): ?>h-me<?php endif; ?>">
			<?php $featured_image = thrive_get_post_featured_image( get_the_ID(), thrive_get_theme_options( 'featured_image_style' ) ); ?>
			<a href="<?php echo the_permalink(); ?>" class="fwit">
				<img src="<?php echo $featured_image['image_src'] ?>" alt="<?php echo $featured_image['image_alt'] ?>"
				     title="<?php echo $featured_image['image_title'] ?>"/>
			</a>

			<h2 class="entry-title">
				<a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
		</div>

	<?php else: ?>

		<?php
		if ( $post_format == "gallery" ):
			$thrive_meta_postformat_gallery_images = get_post_meta( get_the_ID(), '_thrive_meta_postformat_gallery_images', true );
			$thrive_gallery_ids = explode( ",", $thrive_meta_postformat_gallery_images );
			?>
			<?php
			if ( count( $thrive_gallery_ids ) > 0 ):
				$first_img_url = wp_get_attachment_url( $thrive_gallery_ids[0] );
				?>
				<div class="hui hru fha" style="background: url('<?php echo trim( $first_img_url ); ?>');"
				     id="thrive-gallery-header-<?php echo get_the_ID(); ?>"
				     data-count="<?php echo count( $thrive_gallery_ids ); ?>" data-index="0">
					<img id="thive-gallery-dummy" class="gallery-dmy" src="<?php echo trim( $first_img_url ); ?>"
					     alt="">

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
			<?php endif; ?>
		<?php endif; ?>


		<?php if ( $post_format == "video" ): ?>
			<?php $wistiaVideoCode = ( strpos( $post_format_options['video_code'], "wistia" ) !== false ) ? ' wistia-video-container' : ''; ?>
			<?php if ( has_post_thumbnail() ): ?>
				<div class="scvps<?php echo $wistiaVideoCode; ?>"
				     style="background-image: url('<?php echo _thrive_get_featured_image_src( null, get_the_ID(), "large" ); ?>')">
					<div class="vdc lv">
						<div class="ltx">
							<div class="pvb">
								<a href=""></a>
							</div>
						</div>
					</div>
					<div style="display:none;" class="vdc lv video-container">
						<div class="vwr">
							<?php echo $post_format_options['video_code']; ?>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="vdc lv video-container">
					<div class="vwr">
						<?php echo $post_format_options['video_code']; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<div
			class="awr <?php if ( $options['meta_post_date'] == 1 || ( $options['meta_comment_count'] == 1 && get_comments_number() > 0 ) ): ?>h-me<?php endif; ?>">

			<?php if ( ( $options['featured_image_style'] == "wide" ) && has_post_thumbnail() && $post_format != "gallery" && $post_format != "video" ): ?>
				<a class="fwit" href="<?php the_permalink(); ?>"
				   <?php if ( $post_format == "audio" && $post_format_options['audio_type'] == "soundcloud" ): ?>style="display:none;"<?php endif; ?>>
					<img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt ?>"
					     title="<?php echo $featured_image_title ?>"/>
				</a>
			<?php endif; ?>

			<div class="awr-i">
				<div class="meta">

					<?php if ( isset( $options['meta_post_date'] ) && $options['meta_post_date'] == 1 ): ?>
						<div class="met-d">
							<?php echo get_the_date( "M" ); ?>
							<span><?php echo get_the_date( "d" ); ?></span>
						</div>
					<?php endif; ?>

					<div class="met-c"
					     <?php if ( $options['meta_comment_count'] != 1 || get_comments_number() == 0 ): ?>style='display:none;'<?php endif; ?>>
						<div>
							<a href="<?php the_permalink(); ?>#comments"><span></span> <?php echo get_comments_number(); ?>
							</a>
						</div>
					</div>

				</div>

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

				<p class="sub-entry-title">
					<?php if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ): ?>
						<?php _e( "By", 'thrive' ); ?>
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
							<?php echo $author_info['display_name']; ?>
						</a>
					<?php endif; ?>
					<?php if ( $options['meta_author_name'] == 1 && $options['meta_post_category'] == 1 ): ?>
						<span class="sep">|</span>
					<?php endif; ?>
					<?php if ( isset( $options['meta_post_category'] ) && $options['meta_post_category'] == 1 ): ?>

						<?php
						$categories = get_the_category();
						if ( $categories && count( $categories ) > 0 ):
							?>
							<?php foreach ( $categories as $key => $cat ): ?>
						<a href="<?php echo get_category_link( $cat->term_id ); ?>">
							<?php echo $cat->cat_name; ?>
							</a><?php if ( $key + 1 != count( $categories ) ): ?>, <?php endif; ?>
						<?php endforeach; ?>
						<?php endif; ?>

					<?php endif; ?>
				</p>

				<?php if ( $post_format == "audio" ): ?>
					<?php if ( $post_format_options['audio_type'] != "soundcloud" ): ?>
						<?php echo do_shortcode( "[audio src='" . $post_format_options['audio_file'] . "'][/audio]" ); ?>
					<?php else: ?>
						<?php echo $post_format_options['audio_soundcloud_embed_code']; ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ( $options['featured_image_style'] == "thumbnail" ) && has_post_thumbnail() && $post_format != "video" ): ?>
					<a class="thi" href="<?php the_permalink(); ?>"
					   <?php if ( $post_format == "audio" && $post_format_options['audio_type'] == "soundcloud" ): ?>style="display:none;"<?php endif; ?>>
						<img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt ?>"
						     title="<?php echo $featured_image_title ?>">
					</a>
				<?php endif; ?>

				<?php if ( $options['other_show_excerpt'] != 1 ): ?>
					<?php the_content(); ?>
				<?php else: ?>
					<?php the_excerpt(); ?>
					<?php $read_more_text = ( $options['other_read_more_text'] != "" ) ? $options['other_read_more_text'] : "Read more"; ?>
					<?php if ( $options['other_read_more_type'] == "button" ): ?>
						<a href="<?php the_permalink(); ?>"
						   class="btn small mrb"><span><?php echo $read_more_text ?></span></a>
					<?php else: ?>
						<a href='<?php the_permalink(); ?>' class=''><?php echo $read_more_text ?></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</article>