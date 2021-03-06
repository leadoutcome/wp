<?php
$options            = thrive_get_theme_options();
$sidebar_is_active  = is_active_sidebar( 'sidebar-1' );
$sidebar_is_active  = ! ( $options['blog_post_layout'] === 'full_width' || $options['blog_post_layout'] === 'narrow' );
$main_content_class = _thrive_get_main_content_class( $options );
$next_page_link     = get_next_posts_link();
$prev_page_link     = get_previous_posts_link();
$exclude_woo_pages  = array(
	intval( get_option( 'woocommerce_cart_page_id' ) ),
	intval( get_option( 'woocommerce_checkout_page_id' ) ),
	intval( get_option( 'woocommerce_pay_page_id' ) ),
	intval( get_option( 'woocommerce_thanks_page_id' ) ),
	intval( get_option( 'woocommerce_myaccount_page_id' ) ),
	intval( get_option( 'woocommerce_edit_address_page_id' ) ),
	intval( get_option( 'woocommerce_view_order_page_id' ) ),
	intval( get_option( 'woocommerce_terms_page_id' ) )
);
?>
<?php get_header(); ?>
<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
	<?php get_sidebar(); ?>
<?php endif; ?>
<div class="bSeCont">
	<section class="bSe <?php echo $main_content_class; ?>">
		<article>
			<div class="scn awr aut">
				<h4><?php _e( "Results", 'thrive' ); ?></h4>
				<p>
					<?php printf( __( 'Search Results for: %s', 'thrive' ), '' . get_search_query() . '' ); ?>
				</p>
			</div>
		</article>
		<div class="bspr"></div>

		<?php if ( have_posts() ): ?>
			<?php while ( have_posts() ): ?>
				<?php the_post(); ?>
				<?php if ( in_array( get_the_ID(), $exclude_woo_pages ) ): continue; endif; ?>
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
			<article>
				<div class="awr">
					<div class="no_content_msg">
						<h3 class="upp"><?php _e( "Sorry, but no results were found.", 'thrive' ); ?></h3>

						<h4 class="ncm_comment">
							<b>
								<?php _e( "YOU CAN RETURN", 'thrive' ); ?> <a
									href="<?php echo home_url( '/' ); ?>"><?php _e( "HOME", 'thrive' ) ?></a> <?php _e( "OR SEARCH FOR THE PAGE YOU WERE LOOKING FOR.", 'thrive' ) ?>
							</b>
						</h4>

						<form action="<?php echo home_url( '/' ); ?>" method="get" class="srh lost">
							<div>
								<input type="text" placeholder="<?php _e( "Search Here", 'thrive' ); ?>"
								       class="search_field"
								       name="s"/>
								<input type="submit" value="&#xe610;" class="submit_btn"/>
							</div>
						</form>
					</div>
				</div>
			</article>
		<?php endif ?>

	</section>
</div>
<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
	<?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>
