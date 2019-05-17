<?php
$options = thrive_get_theme_options();
?>
<?php get_header(); ?>
<div class="wrp cnt">
	<section class="bSe fullWidth">
		<div class="awr">
			<div class="err">
				<div class="scn awr aut">
					<h1>404</h1>
					<h2>
						<?php _e( "Ooops!", 'thrive' ); ?><br/>
						<b><?php _e( "The page you are looking for seems to be missing. Perhaps searching can help.", 'thrive' ); ?></b>
					</h2>
					<div class="csc">
						<div class="colm thc">
							<form action="<?php echo home_url( '/' ); ?>" method="get" class="srh">
								<div>
									<input id="search-field" class="search-field" type="text" placeholder="Search" name="s">
									<button id="search-big-button" class="sBn search-button" type="submit"></button>
								</div>
							</form>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="spr"></div>
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
									<li><a href='<?php echo get_category_link( $cat->term_id ); ?>'><?php echo $cat->name; ?></a>
										<?php
										$subcats = get_categories( array( 'child_of' => $cat->term_id ) );
										if ( count( $subcats ) > 0 ):
											?>
											<ul>
												<?php foreach ( $subcats as $subcat ): ?>
												<li><a href='<?php echo get_category_link( $subcat->term_id ); ?>'><?php echo $subcat->name; ?></a>
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
									<li><a href='<?php echo get_page_link( $page->ID ); ?>'><?php echo get_the_title( $page->ID ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="clear"></div>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</section>
</div>
<?php get_footer(); ?>
