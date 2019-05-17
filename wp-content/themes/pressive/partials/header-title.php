<?php
if ( is_single() ):
	$options = thrive_get_options_for_post( get_the_ID() );
	$post_format = get_post_format();
	$post_format_options = _thrive_get_post_format_fields( $post_format, get_the_ID() );
	if ( isset( $options['meta_author_name'] ) && $options['meta_author_name'] == 1 ) {
		$author_info = _thrive_get_author_info( get_the_author_meta( 'ID' ) );
	}
	$thrive_meta_postformat_video_type = get_post_meta( get_the_ID(), '_thrive_meta_postformat_video_type', true );
	$vimeo_embed_class                 = '';
	if ( $thrive_meta_postformat_video_type == "vimeo" ) {
		$vimeo_embed_class = "v-cep";
	}
	?>

	<?php if ( $post_format == "quote" ): ?>
	<div class="quo">
		<h1><?php echo $post_format_options['quote_text']; ?></h1>
		<?php if ( ! empty( $post_format_options['quote_author'] ) ): ?>
			<p> <?php echo $post_format_options['quote_author']; ?></p>
		<?php endif; ?>
	</div>
<?php elseif ( $post_format == "video" ): ?>
	<?php $wistiaVideoCode = ( strpos( $post_format_options['video_code'], "wistia" ) !== false ) ? ' wistia-video-container' : ''; ?>
	<div class="vt <?php echo $vimeo_embed_class;
	echo $wistiaVideoCode; ?>">
		<div class="vt-t">
			<?php if ( $options['show_post_title'] != 0 ): ?>
				<h1><?php the_title(); ?></h1>
			<?php endif; ?>
			<?php if ( ! empty( $post_format_options['video_code'] ) ) : ?>
				<div class="pvb">
					<a href=""></a>
				</div>
			<?php endif ?>
		</div>
		<?php if ( ! empty( $post_format_options['video_code'] ) ) : ?>
			<div class="vt-v">
				<div class="vt-vi">
					<?php echo $post_format_options['video_code']; ?>
				</div>
			</div>
		<?php endif ?>
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
		<?php if ( $options['meta_author_name'] == 1 ): ?>
			<?php _e( "By", 'thrive' ); ?>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo $author_info['display_name']; ?></a>
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
	<h1 class="entry-title"><?php _e( "All Posts by ", 'thrive' ); ?><?php echo get_the_author(); ?></h1>
<?php endif; ?>

<?php $is_shop_page = function_exists( 'is_shop' ) ? is_shop() : false; ?>

<?php if ( is_archive() && ! is_author() && ! is_category() && ! is_tag() && ! is_search() && ! $is_shop_page ): ?>
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

<?php if ( is_category() || is_tax() ): ?>
	<h1 class="entry-title"><?php printf( __( 'Category Archives for "%s"', 'thrive' ), '' . single_cat_title( '', false ) . '' ); ?></h1>
<?php endif; ?>

<?php if ( is_search() ): ?>
	<h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'thrive' ), '' . get_search_query() . '' ); ?></h1>
<?php endif; ?>

<?php if ( is_tag() ): ?>
	<h1 class="entry-title"><?php printf( __( 'Tag Archives for " %s " ', 'thrive' ), '' . single_tag_title( '', false ) . '' ); ?></h1>
<?php endif; ?>



