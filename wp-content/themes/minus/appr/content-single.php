<?php
$options = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );

$featured_image     = null;
$featured_image_alt = $featured_image_title = '';
$thrive_lesson_type = get_post_meta( get_the_ID(), '_thrive_meta_appr_lesson_type', true );
if ( has_post_thumbnail( get_the_ID() ) && $thrive_lesson_type != "audio" && $thrive_lesson_type != "video" ) {
	$featured_image_data  = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] );
	$featured_image       = $featured_image_data['image_src'];
	$featured_image_alt   = $featured_image_data['image_alt'];
	$featured_image_title = $featured_image_data['image_title'];
}

$template_name = _thrive_get_item_template( get_the_ID() );
if ( $template_name == "Landing Page" ) {
	$options['display_meta'] = 0;
}
$current_post_type = get_post_type( get_the_ID() );
?>
<?php tha_entry_before(); ?>
	<article>
		<div class="awr <?php if ( $template_name == "Narrow" || $template_name == "Landing Page" || $template_name == "Full Width" ): ?>lnd<?php endif; ?>">
			<?php if ( $options['featured_image_style'] == "wide" && $featured_image ): ?>
				<img class="fwit" src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>" title="<?php echo $featured_image_title; ?>">
			<?php endif; ?>

			<?php if ( $options['show_post_title'] != 0 ): ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php endif; ?>

			<?php if ( $options['featured_image_style'] == "thumbnail" && $featured_image ): ?>
				<img class="fwI alignright" src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>" title="<?php echo $featured_image_title; ?>">
			<?php endif; ?>

			<?php if ( $options['featured_image_style'] == "round" && $featured_image ): ?>
				<div class="rnd prnd alignright" style="background-image: url('<?php echo $featured_image; ?>')"></div>
			<?php endif; ?>
			<?php the_content(); ?>

			<div class="clear"></div>

			<?php get_template_part( 'appr/download-box' ); ?>

			<?php if ( $options['enable_social_buttons'] == 1 ): ?>
				<?php get_template_part( 'share-buttons' ); ?>
			<?php endif; ?>

			<?php if ( is_user_logged_in() && $current_post_type == TT_APPR_POST_TYPE_LESSON ): ?>
				<?php if ( $options['appr_progress_track'] == 1 ): ?>
					<?php
					$current_lesson_progress = _thrive_appr_get_progress( get_the_ID() );
					if ( $current_lesson_progress == THRIVE_APPR_PROGRESS_NEW ) {
						_thrive_appr_set_progress( get_the_ID(), 0, THRIVE_APPR_PROGRESS_STARTED );
					}
					?>
					<div class="acl clearfix">
						<input id="completed-lesson" type="checkbox" value="completedLesson" name="completedLesson"
						       <?php if ( $current_lesson_progress == THRIVE_APPR_PROGRESS_COMPLETED ): ?>checked<?php endif; ?> />
						<label for="completed-lesson">
							<div><a></a></div>
							<span><?php echo $options['appr_completed_text']; ?></span>
						</label>
					</div>

				<?php endif; ?>
				<?php if ( $options['appr_favorites'] == 1 ): ?>
					<div class="fav left" id="tt-favorite-lesson">
						<a class="heart left<?php if ( _thrive_appr_check_favorite( get_the_ID() ) ): ?> fill<?php endif; ?>"></a>
                    <span class="left">
                        <?php if ( _thrive_appr_check_favorite( get_the_ID() ) ): ?>
	                        <?php _e( "Remove from Favorites", 'thrive' ); ?>
                        <?php else: ?>
	                        <?php _e( "Mark as Favorite", 'thrive' ); ?>
                        <?php endif; ?>
                    </span>
						<div class="clear"></div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( isset( $options['display_meta'] ) && $options['display_meta'] == 1 && $current_post_type != TT_APPR_POST_TYPE_PAGE ): ?>
				<footer class="right">
					<div class="meta">
						<?php if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ): ?>
							<span>
                            <?php _e( "Posted by", 'thrive' ); ?>
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
                        </span><br/>
						<?php endif; ?>
						<span>
                        <?php if ( isset( $options['meta_post_date'] ) && $options['meta_post_date'] == 1 ): ?>
	                        <?php if ( $options['relative_time'] == 1 ): ?>
		                        <?php echo thrive_human_time( get_the_time( 'U' ) ); ?>
	                        <?php else: ?>
		                        <?php echo get_the_date(); ?>
	                        <?php endif; ?>
                        <?php endif; ?>

							<?php if ( isset( $options['meta_post_category'] ) && $options['meta_post_category'] == 1 ): ?>
								<?php
								$categories = wp_get_post_terms( get_the_ID(), "apprentice" );
								if ( $categories && count( $categories ) > 0 ):
									?>
									<?php _e( "in", 'thrive' ); ?>
									<?php foreach ( $categories as $key => $cat ): ?>
									<a href="<?php echo get_term_link( $cat ); ?>">
										<?php echo $cat->name; ?>
									</a>
									<?php if ( $key != count( $categories ) - 1 && isset( $categories[ $key + 1 ] ) ): ?><span>,</span><?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
							<?php endif; ?>
                    </span>
					</div>
					<div class="clear"></div>
				</footer>
			<?php endif; ?>
			<div class="clear"></div>
			<?php tha_entry_bottom(); ?>

		</div>
	</article>
<?php tha_entry_after(); ?>