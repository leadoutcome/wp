<?php
$current_auth_id = ( isset( $_GET['author'] ) && $_GET['author'] ) ? ( intval( $_GET['author'] ) ) : 0;

$options = thrive_get_theme_options();

$sidebar_is_active = is_active_sidebar( 'sidebar-1' );

$next_page_link = get_next_posts_link();
$prev_page_link = get_previous_posts_link();

$section_class = _thrive_get_element_class( "content_section", $options );

$fname = get_the_author_meta( 'first_name', $current_auth_id );
$lname = get_the_author_meta( 'last_name', $current_auth_id );
$desc  = get_the_author_meta( 'description', $current_auth_id );

$user_gplus    = get_the_author_meta( 'gplus', $current_auth_id );
$user_twitter  = get_the_author_meta( 'twitter', $current_auth_id );
$user_facebook = get_the_author_meta( 'facebook', $current_auth_id );

$author_name  = get_the_author_meta( 'display_name', $current_auth_id );
$display_name = empty( $author_name ) ? $fname . " " . $lname : $author_name;

if ( $display_name == "" ) {
	$display_name = get_the_author_meta( 'user_login', $current_auth_id );
}

$next_page_link = get_next_posts_link();
$prev_page_link = get_previous_posts_link();
?>

<?php get_header(); ?>

	<div class="wrp cnt <?php if ( $options['blog_layout'] == "grid_full_width" || $options['blog_layout'] == "grid_sidebar" ): ?> gin <?php endif; ?>">

		<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active && $options['blog_layout'] != "full_width" && $options['blog_layout'] != "grid_full_width" ): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>

		<?php if ( $options['blog_layout'] != "full_width" && $options['blog_layout'] != "grid_full_width" ): ?>
		<div class="bSeCont">
			<?php endif; ?>

			<section class="<?php echo $section_class; ?>">

				<article>
					<div class="scn awr aut">
						<h2><?php _e( "All Posts by", 'thrive' ); ?> <span><?php echo $display_name; ?></span></h2>
					</div>
				</article>
				<div class="spr"></div>

				<?php if ( have_posts() ): ?>
					<?php while ( have_posts() ): ?>
						<?php the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
					<?php if ( _thrive_check_focus_area_for_pages( "archive", "bottom" ) ): ?>
						<?php if ( strpos( $options['blog_layout'], 'masonry' ) === false && strpos( $options['blog_layout'], 'grid' ) === false ): ?>
							<?php thrive_render_top_focus_area( "bottom", "archive" ); ?>
							<div class="spr"></div>
						<?php endif; ?>
					<?php endif; ?>

					<div class="clear"></div>
					<?php if ( $next_page_link || $prev_page_link && ( $next_page_link != "" || $prev_page_link != "" ) ): ?>
						<div class="awr ctr pgn">
							<?php thrive_pagination(); ?>
						</div>
						<div class="bspr"></div>
					<?php endif; ?>
				<?php else: ?>
					<!--No contents-->
				<?php endif ?>
				<div class="clear"></div>
			</section>
			<?php if ( $options['blog_layout'] != "full_width" && $options['blog_layout'] != "grid_full_width" ): ?>
		</div>
	<?php endif; ?>

		<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active && $options['blog_layout'] != "full_width" && $options['blog_layout'] != "grid_full_width" ): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>

		<div class="clear"></div>
	</div>

<?php get_footer(); ?>