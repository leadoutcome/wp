<?php
$options = thrive_get_theme_options();

$featured_image_data  = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] );
$featured_image       = $featured_image_data['image_src'];
$featured_image_alt   = $featured_image_data['image_alt'];
$featured_image_title = $featured_image_data['image_title'];
$fname                = get_the_author_meta( 'first_name' );
$lname                = get_the_author_meta( 'last_name' );
$author_name          = get_the_author_meta( 'display_name' );
$display_name         = empty( $author_name ) ? $fname . " " . $lname : $author_name;

?>
<?php tha_entry_before(); ?>
<article>
	<?php tha_entry_top(); ?>
	<div class="awr">
		<?php if ( ! is_page() ): ?>
			<div class="inf">
				<?php if ( isset( $options['meta_post_date'] ) && $options['meta_post_date'] == 1 ): ?>
					<div class="left date">
                    <span>
                        <?php if ( $options['relative_time'] == 1 ): ?>
	                        <?php echo thrive_human_time( get_the_time( 'U' ) ); ?>
                        <?php else: ?>
	                        <?php echo get_the_date(); ?>
                        <?php endif; ?>
                    </span>
					</div>
				<?php endif; ?>
				<?php if ( is_sticky() ): ?>
					<div class="stk right"></div>
				<?php endif; ?>
				<div class="right by">
					<ul>
						<li>
							<?php if ( isset( $options['meta_post_category'] ) && $options['meta_post_category'] == 1 ): ?>
								<?php
								$categories = get_the_category();
								if ( $categories && count( $categories ) > 0 ):
									?>
									in
									<?php foreach ( $categories as $key => $cat ): ?>
								<a href="<?php echo get_category_link( $cat->term_id ); ?>">
									<b><?php echo $cat->cat_name; ?></b>
									</a><?php if ( $key != count( $categories ) - 1 && isset( $categories[ $key + 1 ] ) ): ?>
										<b>, </b><?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php _e( "by", 'thrive' ); ?> <a
								href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
						</li>
						<?php $comments_number = get_comments_number(); ?>
						<?php if ( $comments_number && ! empty( $options['meta_comment_count'] ) ) : ?>
							<li class="sep">|</li>
							<li>
								<a href="<?php echo the_permalink() . "#thrive_container_list_comments" ?>"><?php echo $comments_number; ?>
									comments</a></li>
						<?php endif ?>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
		<?php endif; ?>
		<h2 class="entry-title <?php if ( is_page() ): ?> no-margin"<?php endif; ?>"><a
			href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( ! empty( $featured_image ) && ( $options['featured_image_style'] == "wide" || $options['featured_image_style'] == "thumbnail" ) ): ?>
			<a class="psb <?php if ( $options['featured_image_style'] != "wide" ): ?>alignright<?php endif; ?>"
			   href="<?php the_permalink(); ?>">
				<img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>"
				     title="<?php echo $featured_image_title; ?>"
				     class="<?php if ( $options['featured_image_style'] == "wide" ): ?>fwI<?php else: ?>afim<?php endif; ?>"/>
			</a>
		<?php endif; ?>

		<?php if ( $options['other_show_excerpt'] != 1 ): ?>
			<?php the_content(); ?>
		<?php else: ?>
			<?php the_excerpt(); ?>
			<?php $read_more_text = ( $options['other_read_more_text'] != "" ) ? $options['other_read_more_text'] : "Read more"; ?>
			<?php if ( $options['other_read_more_type'] == "button" ): ?>
				<a href='<?php the_permalink(); ?>' class="mre right"><span><?php echo $read_more_text ?></span><span
						class='awe'>&#xe608;</span>

					<div class='clear'></div>
				</a>
			<?php else: ?>
				<a href='<?php the_permalink(); ?>' class='rmt right'><?php echo $read_more_text ?></a>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( isset( $options['meta_post_tags'] ) && $options['meta_post_tags'] == 1 ):
			$posttags = get_the_tags();
			if ( $posttags ):
				?>
				<div class="tgs left">
					<span class="icn icn-1"></span>

					<p class="tagsList">
						<?php foreach ( $posttags as $key => $tag ): ?>
							<a href="<?php echo get_tag_link( $tag->term_id ); ?>">#<?php echo $tag->name; ?></a>
						<?php endforeach; ?>

					<div class="clear"></div>
					</p>
				</div>
				<div class="clear"></div>
			<?php endif; ?>
		<?php endif; ?>

		<div class="clear"></div>
	</div>
	<?php tha_entry_bottom(); ?>
</article>
<?php _thrive_render_bottom_related_posts( get_the_ID(), $options ); ?>
<?php tha_entry_after(); ?>
<div class="spr"></div>