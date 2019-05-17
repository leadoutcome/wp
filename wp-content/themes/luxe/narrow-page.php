<?php
/*
  Template Name: Narrow
 */
?>
<?php
$options        = thrive_get_theme_options();
$next_page_link = get_next_posts_link();
$prev_page_link = get_previous_posts_link();
?>
<?php get_header(); ?>

<section class="bSe bpd">

	<?php if ( have_posts() ): ?>
		<?php while ( have_posts() ): ?>
			<?php the_post(); ?>
			<?php get_template_part( 'content-single', get_post_format() ); ?>

			<?php
			if ( thrive_check_bottom_focus_area() ):
				thrive_render_top_focus_area( "bottom" );
				echo "<div class='spr'></div>";
			endif;
			?>
			<?php if ( isset( $options['bottom_about_author'] ) && $options['bottom_about_author'] == 1 && ! is_page() ): ?>
				<?php get_template_part( 'authorbox' ); ?>
			<?php endif; ?>
			<?php if ( ! post_password_required() && ( ! is_page() || ( is_page() && $options['comments_on_pages'] != 0 ) ) ) : ?>
				<?php comments_template( '', true ); ?>
			<?php elseif ( ( ! comments_open() ) && get_comments_number() > 0 ): ?>
				<?php comments_template( '/comments-disabled.php' ); ?>
			<?php endif; ?>

		<?php endwhile; ?>
		<?php if ( $next_page_link || $prev_page_link && ( $next_page_link != "" || $prev_page_link != "" ) ): ?>
			<div class="awr">
				<?php thrive_pagination(); ?>
			</div>
		<?php endif; ?>
	<?php else: ?>
		<!--No contents-->
	<?php endif ?>

</section>


<?php get_footer(); ?>
