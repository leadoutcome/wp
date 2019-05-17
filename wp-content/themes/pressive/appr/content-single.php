<?php $options     = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );
$current_post_type = get_post_type( get_the_ID() );
$lesson_comments   = thrive_get_theme_options( 'appr_page_comments' ); ?>

<?php if ( $current_post_type == TT_APPR_POST_TYPE_LESSON && get_post_meta( get_the_ID(), '_thrive_meta_appr_lesson_type', true ) == "audio" ):
	$lesson_media_options = _thrive_appr_get_media_options_for_lesson( get_the_ID(), $options );
	?>
	<?php if ( $lesson_media_options['audio_type'] != "soundcloud" ): ?>
	<?php echo do_shortcode( "[audio src='" . $lesson_media_options['audio_file'] . "'][/audio]" ); ?>
<?php else: ?>
	<?php echo $lesson_media_options['soundcloud_embed_code']; ?>
<?php endif; ?>
<?php endif; ?>

<div
	class="awr <?php if ( ( $options['meta_post_date'] == 1 && $current_post_type == TT_APPR_POST_TYPE_LESSON ) || ( $options['meta_comment_count'] == 1 && get_comments_number() > 0 && $current_post_type == TT_APPR_POST_TYPE_LESSON ) ): ?>h-me<?php endif; ?>">
	<div class="meta">
		<?php if ( $options['meta_post_date'] == 1 && $current_post_type == TT_APPR_POST_TYPE_LESSON ): ?>
			<div class="met-d">
				<?php echo get_the_date( "M" ); ?>
				<span><?php echo get_the_date( "d" ); ?></span>
			</div>
		<?php endif; ?>
		<div class="met-c"
		     <?php if ( $options['meta_comment_count'] != 1 || get_comments_number() == 0 ): ?>style='display:none;'<?php endif; ?>>
			<div>
				<a href="#comments"><span></span> <?php echo get_comments_number(); ?></a>
			</div>
		</div>
	</div>
	<div class="awr-i">

		<?php if ( $options['featured_image_style'] == "wide" && has_post_thumbnail() ): ?>
			<?php $featured_image = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] ) ?>
			<div class="fwit">
				<img src="<?php echo $featured_image['image_src'] ?>" alt="<?php echo $featured_image['image_alt'] ?>"
				     title="<?php echo $featured_image['image_title'] ?>"/>
			</div>
		<?php endif; ?>

		<?php if ( ( $options['featured_image_style'] == "thumbnail" ) && has_post_thumbnail() ): ?>
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

		<?php get_template_part( 'appr/download-box' ); ?>

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
						<span class="left"><?php echo $options['appr_completed_text']; ?></span>
					</label>
					<?php if ( $options['appr_favorites'] == 1 ): ?>
						<div class="fav right" id="tt-favorite-lesson">
							<a class="heart left<?php if ( _thrive_appr_check_favorite( get_the_ID() ) ): ?> fill<?php endif; ?>"></a>
                            <span class="left">
                                <?php if ( _thrive_appr_check_favorite( get_the_ID() ) ): ?>
	                                <?php _e( "Remove from Favorites", 'thrive' ); ?>
                                <?php else: ?>
	                                <?php _e( "Favorite", 'thrive' ); ?>
                                <?php endif; ?>
                            </span>

							<div class="clear"></div>
						</div>
					<?php endif; ?>
				</div>

			<?php endif; ?>
		<?php endif; ?>

		<?php if ( isset( $options['bottom_about_author'] ) && $options['bottom_about_author'] == 1 && $current_post_type == TT_APPR_POST_TYPE_LESSON ): ?>
			<?php get_template_part( "partials/authorbox" ); ?>
		<?php endif; ?>

		<?php
		if ( thrive_check_bottom_focus_area() ):
			thrive_render_top_focus_area( "bottom" );
		endif;
		?>

		<?php _thrive_render_bottom_related_posts( get_the_ID(), $options ); ?>
		<?php if ( ! empty ( $lesson_comments ) ) : ?>
			<?php if ( ! post_password_required() && $options['comments_on_pages'] != 0 ) : ?>
				<?php comments_template( '', true ); ?>
			<?php elseif ( ( ! comments_open() ) && get_comments_number() > 0 ): ?>
				<?php comments_template( '/comments-disabled.php' ); ?>
			<?php endif; ?>
		<?php endif ?>

		<?php
		$next_lesson_link = _thrive_get_next_prev_lesson_link( get_the_ID(), true );
		$prev_lesson_link = _thrive_get_next_prev_lesson_link( get_the_ID(), false );
		if ( isset( $options['bottom_previous_next'] ) && $options['bottom_previous_next'] == 1 && ( $next_lesson_link != false || $prev_lesson_link != false ) ):
			?>

			<?php
			$next_lesson_link = _thrive_get_next_prev_lesson_link( get_the_ID(), true );
			$prev_lesson_link = _thrive_get_next_prev_lesson_link( get_the_ID(), false );
			if ( isset( $options['bottom_previous_next'] ) && $options['bottom_previous_next'] == 1 && ( $next_lesson_link != false || $prev_lesson_link != false ) ):
				?>
				<?php if ( $prev_lesson_link ): ?>
				<a href='<?php echo $prev_lesson_link; ?>' class="btn small aprb left">
					<span>« <?php _e( "Previous lesson", 'thrive' ); ?></span>
				</a>
			<?php endif; ?>
				<?php if ( $next_lesson_link ): ?>
				<a href='<?php echo $next_lesson_link; ?>' class="btn small aprb right">
					<span><?php _e( "Next lesson", 'thrive' ); ?> »</span>
				</a>
			<?php endif; ?>

			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>