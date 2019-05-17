<?php

/**
 * display this video template if user has access set on Paid Membership Pro plugin
 */
$show_video = true;
if ( function_exists( 'pmpro_has_membership_access' ) && ! pmpro_has_membership_access() ) {
	$show_video = false;
}


if ( is_single() ):
	$options = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );

	$current_post_type = get_post_type( get_the_ID() ); ?>

	<?php if ( $current_post_type == TT_APPR_POST_TYPE_LESSON && get_post_meta( get_the_ID(), '_thrive_meta_appr_lesson_type', true ) == "video" && $show_video ):
	$lesson_media_options = _thrive_appr_get_media_options_for_lesson( get_the_ID(), $options );
	?>
	<div class="vt">
		<div class="vt-t">
			<?php if ( $options['show_post_title'] != 0 ): ?>
				<h1><?php the_title(); ?></h1>
			<?php endif; ?>
			<div class="pvb">
				<a href=""></a>
			</div>
		</div>
		<div class="vt-v">
			<div class="vt-vi">
				<?php echo $lesson_media_options['video_code']; ?>
			</div>
		</div>
	</div>
	<?php
else: ?>
	<?php if ( $options['show_post_title'] != 0 ): ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php endif; ?>
<?php endif; ?>
	<?php if ( get_post_meta( get_the_ID(), "_thrive_meta_show_content_title", true ) == 1 ): ?>
	<?php echo do_shortcode( get_post_meta( get_the_ID(), "_thrive_meta_content_title", true ) ); ?>
<?php endif; ?>

	<?php if ( $options['meta_author_name'] == 1 || $options['meta_post_category'] == 1 ):
	?>
	<p>
		<?php if ( $options['meta_author_name'] == 1 && $current_post_type == TT_APPR_POST_TYPE_LESSON ): ?>
			<?php _e( "By", 'thrive' ); ?>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
		<?php endif; ?>
		<?php if ( $options['meta_author_name'] == 1 && $options['meta_post_category'] == 1 ): ?>
			<span class="sep">|</span>
		<?php endif; ?>
		<?php
		if ( $options['meta_post_category'] == 1 ):
			$categories = get_the_category();
			if ( $categories && count( $categories ) > 0 ):
				?>
				<a href="<?php echo get_category_link( $categories[0]->term_id ); ?>"><?php echo $categories[0]->cat_name; ?></a>
			<?php endif; ?>
		<?php endif; ?>
	</p>
<?php endif; ?>

<?php endif; ?>

<?php
if ( is_page() ):
	$options = thrive_get_options_for_post( get_the_ID() );
	?>
	<?php if ( $options['show_post_title'] != 0 ): ?>
	<h1 class="entry-title"><?php the_title(); ?></h1>
<?php endif; ?>
	<?php if ( get_post_meta( get_the_ID(), "_thrive_meta_show_content_title", true ) == 1 ): ?>
	<?php echo do_shortcode( get_post_meta( get_the_ID(), "_thrive_meta_content_title", true ) ); ?>
<?php endif; ?>
<?php endif; ?>

<?php if ( is_author() ): ?>
	<h1 class="entry-title"><?php _e( "All Lessons by", 'thrive' ); ?><?php echo get_the_author(); ?></h1>
<?php endif; ?>

<?php if ( is_tax( "apprentice" ) ):
	$queried_object = get_queried_object();
	?>
	<h1 class="entry-title">
		<?php if ( $queried_object && $queried_object->name ): ?>
			<h1 class="entry-title"><?php printf( __( 'Lessons for "%s"', 'thrive' ), '' . $queried_object->name ); ?></h1>
		<?php else: ?>
			<h1 class="entry-title"><?php _e( 'Lessons', 'thrive' ); ?></h1>
		<?php endif; ?>
	</h1>
<?php elseif ( is_archive() && ! is_author() && ! is_category() && ! is_tag() && ! is_search() ): ?>
	<h1 class="entry-title">
		<?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: %s', 'thrive' ), '' . get_the_date() . '' ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Monthly Archives: %s', 'thrive' ), '' . get_the_date( _x( 'F Y', 'monthly archives date format', 'thrive' ) ) . '' ); ?>
			<?php
		elseif ( is_year() ) : ?>
			<?php printf( __( 'Yearly Archives: %s', 'thrive' ), '' . get_the_date( _x( 'Y', 'yearly archives date format', 'thrive' ) ) . '' ); ?>
			<?php
		else : ?>
			<?php _e( 'Blog Archives', 'thrive' ); ?>
		<?php endif; ?>
	</h1>

<?php endif; ?>

<?php if ( is_category() ): ?>
	<h1 class="entry-title"><?php printf( __( 'Lessons for "%s"', 'thrive' ), '' . single_cat_title( '', false ) . '' ); ?></h1>
<?php endif; ?>

<?php if ( is_search() ): ?>
	<h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'thrive' ), '' . get_search_query() . '' ); ?></h1>
<?php endif; ?>

<?php if ( is_tag() ): ?>
	<h1 class="entry-title"><?php printf( __( 'Tag Archives for " %s " ', 'thrive' ), '' . single_tag_title( '', false ) . '' ); ?></h1>
<?php endif; ?>



