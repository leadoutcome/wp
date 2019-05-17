<?php
global $post;
$lazy_load_comments = thrive_get_theme_options( "comments_lazy" );
$enable_fb_comments = thrive_get_theme_options( "enable_fb_comments" );
$fb_app_id          = thrive_get_theme_options( "fb_app_id" );

?>

<?php if ( $lazy_load_comments == 1 ): ?>
	<script type="text/javascript">
		_thriveCurrentPost = <?php echo json_encode( get_the_ID() ); ?>;
	</script>

<?php endif; ?>
<?php tha_comments_before(); ?>
<?php if ( $enable_fb_comments != "only_fb" ): ?>
	<article id="comments">
		<?php if ( comments_open() && ! post_password_required() ) : ?>
			<div class="awr">
				<div class="lrp" id="thrive_container_form_add_comment"
				     <?php if ( $lazy_load_comments == 1 ): ?>style="display:none;"<?php endif; ?>>
					<h4><?php _e( "Leave a Comment:", 'thrive' ); ?></h4>

					<form action="<?php echo site_url( '/wp-comments-post.php' ) ?>" method="post" id="commentform">
						<?php if ( ! is_user_logged_in() ): ?>
							<label
									for="author"><?php _e( 'Name', 'thrive' ) ?> <?php if ( get_option( "require_name_email" ) == 1 ) { ?>*<?php } ?></label>
							<label
									for="email"><?php _e( 'E-Mail', 'thrive' ) ?> <?php if ( get_option( "require_name_email" ) == 1 ) { ?>*<?php } ?></label>
							<label class="l-lst"><?php _e( 'Website', 'thrive' ) ?></label>
							<div class="clear"></div>

							<input type="text" id="author" author="author" class="text_field author" name="author"/>
							<input type="text" id="email" author="email" class="text_field email" name="email"/>
							<input type="text" id="website" author="website" class="text_field website l-lst"
								   name="url"/>
							<div class="clear"></div>

						<?php endif; ?>
						<label for="comment"><?php _e( 'Comments', 'thrive' ) ?>:</label>
						<textarea id="comment" name="comment" class="textarea"></textarea>
						<?php
						/**
						 * For Subscribe to Comments Reloaded
						 *
						 * The 'comment_form_submit_field' filter needs to be applied because the Theme Form is not constructed via comment_form function
						 */
						apply_filters( 'comment_form_submit_field', '' );
						echo '<style>label[for=subscribe-reloaded]{width: 100%;}</style>'
						?>
						<div class="clear"></div>
						<div class="btn dark small">
							<input type="submit" value="<?php _e( "Post Comment", 'thrive' ); ?>">
						</div>

						<?php comment_id_fields(); ?>
						<?php do_action( 'comment_form', $post->ID ); ?>
						<div class="clear"></div>
					</form>
				</div>
			</div>
			<div class="awr cmm" <?php if ( get_comments_number() == 0 ): ?>style="display: none;<?php endif; ?>">
				<h4>(<?php echo get_comments_number(); ?>) <?php echo _thrive_get_comments_label( get_comments_number() ); ?></h4>
			</div>
		<?php endif; ?>
		<div class="awr">
			<?php if ( $lazy_load_comments != 1 ):
				thrive_theme_comment_nav();
			endif; ?>

			<div class="cmb" style="margin-left: 0px;" id="thrive_container_list_comments">
				<?php if ( $lazy_load_comments != 1 ): ?>
					<?php wp_list_comments( array( 'callback' => 'thrive_comments' ) ); ?>
				<?php endif; ?>
			</div>

			<?php if ( $lazy_load_comments != 1 ):
				thrive_theme_comment_nav();
			endif; ?>
			<!-- /comment_list -->
			<?php if ( comments_open() && ! post_password_required() ) : ?>
				<div class="clear"></div>
				<div class="a-cml" <?php if ( get_comments_number() == 0 ): ?>style="display: none;"<?php endif; ?>>
					<div class="a-cm1"></div>
					<div class="btn small" id="shf">
						<span><?php _e( 'Add Your Reply', 'thrive' ) ?></span>
					</div>
					<div class="a-cm2"></div>
				</div>
				<?php if ( $lazy_load_comments == 1 ): ?>
					<div class="ctb ctr" style="display: none;" id="thrive_container_preload_comments">
						<img class="preloader" src="<?php echo get_template_directory_uri() ?>/images/loading.gif"
							 alt=""/>
					</div>
				<?php endif; ?>
				<div class="lrp hid" id="thrive_container_form_add_comment"
				     <?php if ( $lazy_load_comments == 1 ): ?>style="display:none;"<?php endif; ?>>
					<h4><?php _e( "Leave a Comment:", 'thrive' ); ?></h4>

					<form action="<?php echo site_url( '/wp-comments-post.php' ) ?>" method="post" id="commentform">
						<?php if ( ! is_user_logged_in() ): ?>
							<label for="author"><?php _e( 'Name', 'thrive' ) ?> *</label>
							<label for="email"><?php _e( 'E-Mail', 'thrive' ) ?> *</label>
							<label class="l-lst"><?php _e( 'Website', 'thrive' ) ?></label>
							<div class="clear"></div>

							<input type="text" id="author" author="author" class="text_field author" name="author"/>
							<input type="text" id="email" author="email" class="text_field email" name="email"/>
							<input type="text" id="website" author="website" class="text_field website l-lst"
								   name="url"/>
							<div class="clear"></div>

						<?php endif; ?>
						<label for="comment"><?php _e( 'Comments', 'thrive' ) ?>:</label>
						<textarea id="comment" name="comment" class="textarea"></textarea>
						<?php
						//	WP ReCaptcha Intergration filter - displays a recaptcha integration if the WP ReCaptcha plugin is active
						echo apply_filters( 'comments_recaptcha_html', '' );
						?>
						<div class="clear"></div>
						<div class="btn dark small">
							<input type="submit" value="<?php _e( "Post Comment", 'thrive' ); ?>">
						</div>
						<?php comment_id_fields(); ?>
						<?php do_action( 'comment_form', $post->ID ); ?>
						<div class="clear"></div>
					</form>
				</div>
			<?php elseif ( ( ! comments_open() || post_password_required() ) && get_comments_number() > 0 ): ?>
				<div class="no_comm">
					<h4 class="ctr">
						<?php _e( "Comments are closed", 'thrive' ); ?>
					</h4>
				</div>
			<?php endif; ?>
		</div>
		<div id="comment-bottom"></div>
	</article>
<?php endif; ?>
<?php if ( ( $enable_fb_comments == "only_fb" || $enable_fb_comments == "both_fb_regular" || ( ! comments_open() && $enable_fb_comments == "fb_when_disabled" ) ) && ! empty( $fb_app_id ) ) : ?>
	<article id="comments_fb" style="min-height: 100px; border: 1px solid #ccc;">
		<div class="fb-comments" data-href="<?php echo get_permalink( get_the_ID() ); ?>"
			 data-numposts="<?php echo thrive_get_theme_options( "fb_no_comments" ) ?>" data-width="100%"
			 data-colorscheme="<?php echo thrive_get_theme_options( "fb_color_scheme" ) ?>"></div>
	</article>
<?php endif; ?>
<?php tha_comments_after(); ?>