<?php
$options = thrive_get_theme_options();

$featured_image = thrive_get_post_featured_image( get_the_ID(), "wide" );

?>
<?php tha_entry_before(); ?>
	<article <?php if ( is_sticky() ): ?>class="sticky"<?php endif; ?>>
		<?php tha_entry_top(); ?>
		<div
			class="awr lnd <?php if ( $options['featured_image_style'] == "wide" && $featured_image['image_src'] ): ?>hasf<?php endif; ?>">
			<a class="ccb" href="<?php the_permalink(); ?>#comments"
			   <?php if ( $options['meta_comment_count'] != 1 || get_comments_number() == 0 ): ?>style='display:none;'<?php endif; ?>>
				<?php echo get_comments_number(); ?>
			</a>
			<?php if ( $featured_image ): ?>
				<div class="fwi">
					<img src="<?php echo $featured_image['image_src']; ?>"
					     alt="<?php echo $featured_image['image_alt'] ?>"
					     title="<?php echo $featured_image['image_title'] ?>"/>
					<h1 class="entry-title gts">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h1>
				</div>
			<?php endif; ?>
		</div>
		<?php tha_entry_bottom(); ?>
	</article>
<?php tha_entry_after(); ?>