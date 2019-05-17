<?php
/*
  Template Name: Landing Page
 */
?>
<?php
$options = thrive_get_theme_options();

$sidebar_is_active = is_active_sidebar( 'sidebar-1' );

$next_page_link = get_next_posts_link();
$prev_page_link = get_previous_posts_link();

$section_class = _thrive_get_element_class( "content_single_section", $options );
?>

<?php get_header( "landing" ); ?>
	<div class="wrp cnt">

		<section class="bSe fullWidth">

			<?php if ( have_posts() ): ?>

				<?php while ( have_posts() ): ?>

					<?php the_post(); ?>

					<?php get_template_part( 'content-single', get_post_format() ); ?>

					<?php
					if ( thrive_check_bottom_focus_area() ):
						thrive_render_top_focus_area( "bottom" );
						?>
						<div class="spr"></div>
					<?php endif; ?>

					<?php if ( isset( $options['bottom_about_author'] ) && $options['bottom_about_author'] == 1 && ! is_page() ): ?>
						<?php get_template_part( 'authorbox' ); ?>
					<?php endif; ?>

					<?php if ( ! post_password_required() && ( ! is_page() || ( is_page() && $options['comments_on_pages'] != 0 ) ) ) : ?>
						<?php comments_template( '', true ); ?>
					<?php elseif ( ( ! comments_open() ) && get_comments_number() > 0 ): ?>
						<?php comments_template( '/comments-disabled.php' ); ?>
					<?php endif; ?>

					<?php
					if ( isset( $options['bottom_previous_next'] ) && $options['bottom_previous_next'] == 1 && get_permalink( get_adjacent_post( false, '', false ) ) != "" && get_permalink( get_adjacent_post( false, '', true ) ) != "" && ! is_page() ):
						?>
						<div class="spr"></div>
						<div class="awr ctr pgn">
							<?php $prev_post = get_adjacent_post( false, '', true ); ?>
							<?php if ( $prev_post ) : ?>
								<a class="page-numbers nxt" href='<?php echo get_permalink( get_adjacent_post( false, '', true ) ); ?>'>&larr;<?php _e( "Previous post", 'thrive' ); ?> </a>
							<?php endif; ?>
							<?php $next_post = get_adjacent_post( false, '', false ); ?>
							<?php if ( $next_post ) : ?>
								<a class="page-numbers prv" href='<?php echo get_permalink( get_adjacent_post( false, '', false ) ); ?>'><?php _e( "Next post", 'thrive' ) ?>&rarr;</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				<?php endwhile; ?>

			<?php else: ?>
				<div class="no_content_msg">
					<p><?php _e( "Sorry, but no results were found.", 'thrive' ); ?></p>
					<p class="ncm_comment"><?php _e( "YOU CAN RETURN", 'thrive' ); ?> <a href="<?php echo home_url( '/' ); ?>"><?php _e( "HOME", 'thrive' ) ?></a> <?php _e( "OR SEARCH FOR THE PAGE YOU WERE LOOKING FOR.", 'thrive' ) ?></p>
					<form action="<?php echo home_url( '/' ); ?>" method="get">
						<input type="text" placeholder="<?php _e( "Search Here", 'thrive' ); ?>" class="search_field" name="s"/>
						<input type="submit" value="<?php _e( "Search", 'thrive' ); ?>" class="submit_btn"/>
					</form>
				</div>
			<?php endif; ?>

		</section>


	</div>

<?php get_footer( "landing" ); ?>