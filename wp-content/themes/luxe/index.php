<?php
$options            = thrive_get_theme_options();
$sidebar_is_active  = _thrive_is_active_sidebar( $options );
$main_content_class = _thrive_get_main_content_class( $options );
$next_page_link     = get_next_posts_link();
$prev_page_link     = get_previous_posts_link();
?>
<?php get_header(); ?>
<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
	<?php get_sidebar(); ?>
<?php endif; ?>

<?php if ( _thrive_is_active_sidebar() ): ?>
<div class="bSeCont">
	<?php endif; ?>
	<section class="bSe <?php echo $main_content_class; ?>">

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
			<!--No contents-->
		<?php endif ?>

	</section>
	<?php if ( _thrive_is_active_sidebar() ): ?>
</div>
<?php endif; ?>
<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
	<?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>
