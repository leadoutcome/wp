<?php
$options            = thrive_get_theme_options();
$sidebar_is_active  = is_active_sidebar( 'sidebar-1' );
$main_content_class = _thrive_get_main_content_class( $options );
$next_page_link     = get_next_posts_link();
$prev_page_link     = get_previous_posts_link();
?>
<?php get_header(); ?>
<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
	<?php get_sidebar(); ?>
<?php endif; ?>
<div class="bSeCont">
	<section class="bSe <?php echo $main_content_class; ?>">
		<article>
			<div class="scn awr aut">
				<h4><?php _e( "Archive", 'thrive' ); ?></h4>
				<p>
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: %s', 'thrive' ), '' . get_the_date() . '' ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: %s', 'thrive' ), '' . get_the_date( _x( 'F Y', 'monthly archives date format', 'thrive' ) ) . '' ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: %s', 'thrive' ), '' . get_the_date( _x( 'Y', 'yearly archives date format', 'thrive' ) ) . '' ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', 'thrive' ); ?>
					<?php endif; ?>
				</p>
			</div>
		</article>
		<div class="bspr"></div>

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

			<?php if ( $next_page_link || $prev_page_link && ( $next_page_link != "" || $prev_page_link != "" ) ): ?>
				<div class="awr">
					<?php thrive_pagination(); ?>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="no_content_msg">
				<p><?php _e( "Sorry, but no results were found.", 'thrive' ); ?></p>
				<p class="ncm_comment"><?php _e( "YOU CAN RETURN", 'thrive' ); ?> <a
						href="<?php echo home_url( '/' ); ?>"><?php _e( "HOME", 'thrive' ) ?></a> <?php _e( "OR SEARCH FOR THE PAGE YOU WERE LOOKING FOR.", 'thrive' ) ?>
				</p>
				<form action="<?php echo home_url( '/' ); ?>" method="get">
					<input type="text" placeholder="<?php _e( "Search Here", 'thrive' ); ?>" class="search_field"
					       name="s"/>
					<input type="submit" value="<?php _e( "Search", 'thrive' ); ?>" class="submit_btn"/>
				</form>
			</div>
		<?php endif ?>

	</section>
</div>
<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
	<?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>
