<div class="rltp<?php echo $options['related_posts_images'] == 1 ? 'i' : ''; ?> clearfix">
	<div class="awr">
		<h5><?php echo $options['related_posts_title'] ?></h5>
		<?php foreach ( $relatedPosts as $p ): ?>
			<a href="<?php echo get_permalink( $p->ID ); ?>" class="rlt left">
				<div class="rlti" <?php
				if ( $options['related_posts_images'] == 1 ) {
					echo ' style="background-image: url(\'' . _thrive_get_featured_image_src( $p->ID, array( 'default' => true ) ) . '\')"';
				}
				?>></div>
				<p><?php echo get_the_title( $p->ID ) ?></p>
			</a>
		<?php endforeach; ?>
		<?php if ( empty( $relatedPosts ) ): ?>
			<span><?php echo $options['related_no_text'] ?></span>
		<?php endif; ?>
	</div>
</div>