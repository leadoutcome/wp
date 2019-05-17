<?php
$options           = thrive_appr_get_theme_options();
$sidebar_is_active = is_active_sidebar( 'sidebar-appr' );
$term              = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

$main_content_class = $options['sidebar_alignement'] == "left" ? "right" : ( $options['sidebar_alignement'] == "right" ? "left" : "" );
if ( ! $sidebar_is_active ) {
	$main_content_class = "fullWidth";
}
$courses_obj = _thrive_appr_get_category_object( $term->term_id );
$catLevel    = _thrive_appr_get_cat_level( $term->term_id );

$lessonsLevel = thrive_appr_get_lessons_level() - $catLevel;
?>
<?php get_template_part( "appr/header" ); ?>

	<div class="<?php echo _thrive_get_main_wrapper_class( $options ); ?>">

		<?php get_template_part( 'appr/breadcrumbs' ); ?>

		<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
			<?php get_template_part( "appr/sidebar" ); ?>
		<?php endif; ?>
		<?php if ( $sidebar_is_active ): ?>
		<div class="bSeCont"><?php endif; ?>

			<section class="bSe <?php echo $main_content_class; ?>">

				<div class="awr">
					<div class="awr-i">
						<div class="tve-c">
							<p><?php echo $term->description; ?></p>
							<?php if ( $lessonsLevel == 3 ): ?>
								<?php foreach ( $courses_obj['courses'] as $course ): ?>
									<h3><?php echo $course['name']; ?></h3>
									<p><?php echo $course['description']; ?></p>
									<?php foreach ( $course['modules'] as $module ): ?>
										<div class="lvl-2">
											<h3><?php echo $module['name']; ?></h3>

											<p><?php echo $module['description']; ?></p>
										</div>
										<div class="lvl-3">
											<div class="apd apll">
												<?php foreach ( $module['posts'] as $post ): ?>
													<a class="apl" href="<?php echo get_permalink( $post->ID ); ?>">
														<div class="api">
															<span
																class="<?php echo _thrive_app_get_lesson_icon( get_post_meta( $post->ID, '_thrive_meta_appr_lesson_type', true ) ); ?>"></span>
														</div>
														<p>
															<?php echo $post->post_title; ?>
														</p>
														<div class="clear"></div>
													</a>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endforeach; ?>
								<?php endforeach; ?>
							<?php elseif ( $lessonsLevel == 2 ): ?>
								<?php foreach ( $courses_obj['courses'] as $course ): ?>
									<h3><?php echo $course['name']; ?></h3>
									<p><?php echo $course['description']; ?></p>
									<div class="lvl-2">
										<div class="apd apll">
											<?php foreach ( $course['posts'] as $post ): ?>
												<a class="apl" href="<?php echo get_permalink( $post->ID ); ?>">
													<div class="api">
														<span
															class="<?php echo _thrive_app_get_lesson_icon( get_post_meta( $post->ID, '_thrive_meta_appr_lesson_type', true ) ); ?>"></span>
													</div>
													<p>
														<?php echo $post->post_title; ?>
													</p>

													<div class="clear"></div>
												</a>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endforeach; ?>
								<?php
							else:
								$posts = _thrive_appr_get_lessons( $term->term_id );
								?>
								<div class="apd apll">
									<?php foreach ( $posts as $post ):
										?>
										<a class="apl" href="<?php echo get_permalink( $post->ID ); ?>">
											<div class="api">
												<span
													class="<?php echo _thrive_app_get_lesson_icon( get_post_meta( $post->ID, '_thrive_meta_appr_lesson_type', true ) ); ?>"></span>
											</div>
											<p>
												<?php echo $post->post_title; ?>
											</p>
											<div class="clear"></div>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>

			<?php if ( $sidebar_is_active ): ?></div><?php endif; ?>
		<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
			<?php get_template_part( "appr/sidebar" ); ?>
		<?php endif; ?>

	</div>
	<div class="clear"></div>

<?php get_template_part( "appr/footer" ); ?>