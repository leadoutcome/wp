<?php
$options = thrive_get_theme_options();

$main_content_class = ( $options['sidebar_alignement'] == "right" ) ? "main_content" : "right_main_content";

$next_page_link = get_next_posts_link();
$prev_page_link = get_previous_posts_link();
?>
<?php get_header(); ?>
<div class="wrp cnt">
	<section class="bSe fullWidth lost">
		<div class="awr">
			<div class="awr-i">
				<h2>
					<?php _e( "Sorry, the page you are trying to access doesn't exist", 'thrive' ); ?>
				</h2>
				<h5>
					<a href="<?php echo home_url( '/' ); ?>"><?php _e( "Click here", 'thrive' ); ?></a>
					<?php _e( "to return to the homepage or try searching below:", 'thrive' ); ?>
					<a href=""></a>
				</h5>

				<form method="get" action="<?php echo home_url( '/' ); ?>">
					<input class="left" type="text" placeholder="Search keyword..." class="search-field" name="s"/>

					<div class="btn" class="search-button">
						<input type="submit" value=""/>
					</div>
					<div class="clear"></div>
				</form>
				<?php if ( ! empty( $options['404_custom_text'] ) ): ?>
					<p><?php echo do_shortcode( $options['404_custom_text'] ); ?></p>
				<?php endif; ?>
				<?php
				if ( isset( $options['404_display_sitemap'] ) && $options['404_display_sitemap'] == "on" ):
					$categories = get_categories( array( 'parent' => 0 ) );
					$pages = get_pages();
					?>
					<div class="csc">
						<div class="colm thc">
							<h3><?php _e( "Categories", 'thrive' ); ?></h3>
							<ul class="tt_sitemap_list">
								<?php foreach ( $categories as $cat ): ?>
									<li>
										<a href='<?php echo get_category_link( $cat->term_id ); ?>'><?php echo $cat->name; ?></a>
										<?php
										$subcats = get_categories( array( 'child_of' => $cat->term_id ) );
										if ( count( $subcats ) > 0 ):
											?>
											<ul>
												<?php foreach ( $subcats as $subcat ): ?>
												<li>
													<a href='<?php echo get_category_link( $subcat->term_id ); ?>'><?php echo $subcat->name; ?></a>
													<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="colm thc">
							<h3><?php _e( "Archives", 'thrive' ); ?></h3>
							<ul>
								<?php wp_get_archives(); ?>
							</ul>
						</div>
						<div class="colm thc lst">
							<h3><?php _e( "Pages", 'thrive' ); ?></h3>
							<ul class="tt_sitemap_list">
								<?php foreach ( $pages as $page ): ?>
									<li>
										<a href='<?php echo get_page_link( $page->ID ); ?>'><?php echo get_the_title( $page->ID ); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="clear"></div>
					</div>
				<?php endif; ?>
				<div class="bspr"></div>
			</div>
		</div>
	</section>
</div>
<?php get_footer(); ?>
