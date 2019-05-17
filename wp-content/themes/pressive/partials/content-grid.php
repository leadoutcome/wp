<?php
$options                         = thrive_get_theme_options();
$GLOBALS['thrive_theme_options'] = $options;
if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ) {
	$author_info = _thrive_get_author_info( get_the_author_meta( 'ID' ) );
}
$post_format         = get_post_format();
$post_format_options = _thrive_get_post_format_fields( $post_format, get_the_ID() );
?>

<article class="gr-i">
	<?php if ( $options['featured_image_style'] != 'no_image' ): ?>
		<?php if ( has_post_thumbnail() ): ?>
			<a class="fwit" href="<?php the_permalink(); ?>"
			   style="background-image: url('<?php echo thrive_get_post_featured_image_src( get_the_ID(), "tt_grid_layout" ); ?>')"></a>
		<?php else: ?>
			<a class="fwit" href="<?php the_permalink(); ?>"
			   style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/default_featured.jpg')"></a>
		<?php endif; ?>
	<?php endif; ?>
	<div
		class="awr <?php if ( $options['meta_post_date'] == 1 || ( $options['meta_comment_count'] == 1 && get_comments_number() > 0 ) ): ?>h-me<?php endif; ?>">
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

				<?php if ( isset( $options['meta_post_category'] ) && $options['meta_post_category'] == 1 ): ?>

					<?php
					$categories = get_the_category();
					if ( $categories && isset( $categories[0] ) ):
						?>
						<span class="sep">|</span>
						<a href="<?php echo get_category_link( $categories[0]->term_id ); ?>">
							<?php echo $categories[0]->cat_name; ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>
			</p>

			<div class="pl-c">
				<p>
					<?php if ( has_excerpt() ): ?>
						<?php echo _thrive_get_post_text_content_excerpt( get_the_excerpt(), get_the_ID(), 140 ); ?>
					<?php else: ?>
						<?php //echo _thrive_get_post_text_content_excerpt( get_the_content(), get_the_ID(), 140 ); ?>
						<?php
						//as it is on content-default.php partial
						the_excerpt(); //this is a risky one but I assume a re-release :)
						?>
					<?php endif; ?>
				</p>
			</div>
		</div>
	</div>
	<?php if ( ! isset( $GLOBALS['thrive_theme_options']['other_show_excerpt'] ) || $GLOBALS['thrive_theme_options']['other_show_excerpt'] == 1 ) { ?>
		<?php $read_more_text = ( $options['other_read_more_text'] != "" ) ? $options['other_read_more_text'] : "Read more"; ?>
		<?php if ( $options['other_read_more_type'] == "button" ): ?>
			<a href="<?php the_permalink(); ?>" class="btn small mrb"><span><?php echo $read_more_text ?></span></a>
		<?php else: ?>
			<a href='<?php the_permalink(); ?>' class='mre'><?php echo $read_more_text ?></a>
		<?php endif; ?>
	<?php } ?>
</article>