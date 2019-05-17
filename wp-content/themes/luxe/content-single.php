<?php
$options = thrive_get_options_for_post( get_the_ID() );

$featured_image_data  = thrive_get_post_featured_image( get_the_ID(), $options['featured_image_style'] );
$featured_image       = $featured_image_data['image_src'];
$featured_image_alt   = $featured_image_data['image_alt'];
$featured_image_title = $featured_image_data['image_title'];
$fname                = get_the_author_meta( 'first_name' );
$lname                = get_the_author_meta( 'last_name' );
$author_name          = get_the_author_meta( 'display_name' );
$display_name         = empty( $author_name ) ? $fname . " " . $lname : $author_name;
$template_name        = _thrive_get_item_template( get_the_ID() );
$current_content      = get_the_content();
?>
<?php tha_entry_before(); ?>
<article>
	<?php tha_entry_top(); ?>
	<div class="awr">
		<?php if ( $template_name != "Landing Page" && ! is_page() ): ?>
			<?php if ( ( $options['meta_post_date'] == 1 || $options['meta_post_category'] == 1 || $options['meta_author_name'] == 1 ) && is_single() && get_post_type() == "post" ):
				?>
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
								<?php $has_sep = false; ?>
								<?php if ( isset( $options['meta_post_category'] ) && $options['meta_post_category'] == 1 ): ?>
									<?php
									$categories = get_the_category();
									if ( $categories && count( $categories ) > 0 ):
										?>
										in
										<?php foreach ( $categories as $key => $cat ): ?>
										<?php $has_sep = true ?>
									<a href="<?php echo get_category_link( $cat->term_id ); ?>">
										<b><?php echo $cat->cat_name; ?></b>
										</a><?php if ( $key != count( $categories ) - 1 && isset( $categories[ $key + 1 ] ) ): ?>
											<b>, </b><?php endif; ?>
									<?php endforeach; ?>
									<?php endif; ?>
								<?php endif; ?>
								<?php if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ): ?>
								<?php $has_sep = true ?>
								by <a
									href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
							</li>
							<?php endif; ?>
							<?php if ( $options['meta_author_name'] == 1 || $options['meta_post_category'] == 1 ): ?>

							<?php endif; ?>
							<?php if ( get_comments_number() && ! empty( $options['meta_comment_count'] ) ) : ?>
								<?php if ( $has_sep )
									echo '<li class="sep">|</li>' ?>
								<li><a href="<?php the_permalink(); ?>#comments"><?php echo get_comments_number(); ?>
										comments</a></li>
							<?php endif ?>
						</ul>
					</div>
					<div class="clear"></div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( $options['show_post_title'] != 0 ): ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php endif; ?>
		<?php if ( ( $options['featured_image_style'] == "wide" || $options['featured_image_style'] == "thumbnail" ) && $featured_image ): ?>
			<img src="<?php echo $featured_image; ?>" alt="<?php echo $featured_image_alt; ?>"
			     title="<?php echo $featured_image_title; ?>"
			     class="<?php if ( $options['featured_image_style'] == "wide" ): ?>fwI<?php else: ?>afim alignright<?php endif; ?>"/>
		<?php endif; ?>
		<?php the_content(); ?>
		<?php if ( $options['enable_social_buttons'] == 1 ): ?>
			<?php get_template_part( 'share-buttons' ); ?>
		<?php endif; ?>
		<div class="clear"></div>
		<?php
		wp_link_pages( array(
			'before'         => '<br><p class="ctr pgn">',
			'after'          => '</p>',
			'next_or_number' => 'next_and_number',
			'echo'           => 1
		) );
		?>
	</div>
	<?php if ( isset( $options['meta_post_tags'] ) && $options['meta_post_tags'] == 1 && is_single() && get_post_type() == "post" ): ?>
		<?php
		$posttags = get_the_tags();
		if ( $posttags ):
			?>
			<footer>
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
			</footer>
		<?php endif; ?>

	<?php endif; ?>
	<?php tha_entry_bottom(); ?>
</article>
<?php _thrive_render_bottom_related_posts( get_the_ID(), $options ); ?>
<?php tha_entry_after(); ?>
<div class="spr"></div>