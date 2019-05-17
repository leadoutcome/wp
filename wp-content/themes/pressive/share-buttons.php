<?php
$options = thrive_get_options_for_post( get_the_ID() );
global $wp;
$current_url = get_permalink();
?>
<?php if ( $options['social_attention_grabber'] == "count" ): ?>
	<script type="text/javascript">
		var _thrive_share_no_params = {'url': "<?php echo $current_url; ?>"};
		<?php if ($options['enable_facebook_button'] == 1): ?>_thrive_share_no_params.facebook = true;<?php endif; ?>
		<?php if ($options['enable_twitter_button'] == 1): ?>_thrive_share_no_params.twitter = true;<?php endif; ?>
		<?php if ($options['enable_google_button'] == 1): ?>_thrive_share_no_params.google = true;<?php endif; ?>
		<?php if ($options['enable_linkedin_button'] == 1): ?>_thrive_share_no_params.linkedin = true;<?php endif; ?>
		<?php if ($options['enable_pinterest_button'] == 1): ?>_thrive_share_no_params.pinterest = true;<?php endif; ?>
		jQuery( document ).ready( function () {
			ThriveApp.display_no_shares( _thrive_share_no_params );
		} );
	</script>
<?php endif; ?>
<div class="ssf <?php echo $options['enable_floating_icons'] != 1 ? 'apsf' : ''; ?>">
	<?php if ( $options['social_attention_grabber'] == "cta" ): ?>
		<div class="cou">
			<?php echo $options['social_cta_text']; ?>
		</div>
	<?php endif; ?>
	<?php if ( $options['social_attention_grabber'] == "count" && ( ! empty( $options['enable_facebook_button'] ) || ! empty( $options['enable_google_button'] ) || ! empty( $options['enable_linkedin_button'] ) ) ): ?>
		<div class="cou" id="tt-share-count" style="display: none">
			<span id="share_no_element">0</span>
			<input type="hidden" id="tt-hidden-share-no" value="0"/>
			<?php _e( "Shares", 'thrive' ); ?>
		</div>
	<?php endif; ?>
	<div class="ssf-i">
		<?php if ( $options['enable_facebook_button'] == 1 ): ?>
			<div class="ss">
				<a class="fbk" href="//www.facebook.com/sharer/sharer.php?u=<?php echo $current_url; ?>"
				   onclick="return ThriveApp.open_share_popup(this.href, 545, 433);">
					<span><?php _e( 'Share', 'thrive' ) ?></span>
				</a>
			</div>
		<?php endif; ?>
		<?php if ( $options['enable_twitter_button'] == 1 ):
			$twitter_via_user = ( ! empty( $options['social_twitter_username'] ) ) ? "&via=" . $options['social_twitter_username'] : "";
			?>
			<div class="ss">
				<a class="tw"
				   href="https://twitter.com/share?text=<?php echo rawurlencode( wp_strip_all_tags( get_the_title() ) ); ?>:&url=<?php echo $current_url; ?><?php echo $twitter_via_user; ?>"
				   onclick="return ThriveApp.open_share_popup(this.href, 545, 433);">
					<span><?php _e( 'Tweet', 'thrive' ) ?></span>
				</a>
			</div>
		<?php endif; ?>
		<?php if ( $options['enable_google_button'] == 1 ): ?>
			<div class="ss">
				<a class="gg" href="https://plus.google.com/share?url=<?php echo $current_url; ?>"
				   onclick="return ThriveApp.open_share_popup(this.href, 545, 433);">
					<span><?php _e( 'Share', 'thrive' ) ?></span>
				</a>
			</div>
		<?php endif; ?>
		<?php if ( $options['enable_linkedin_button'] == 1 ): ?>
			<div class="ss">
				<a class="lk" href="https://www.linkedin.com/cws/share?url=<?php echo $current_url; ?>"
				   onclick="return ThriveApp.open_share_popup(this.href, 545, 433);">
					<span><?php _e( 'Share', 'thrive' ) ?></span>
				</a>
			</div>
		<?php endif; ?>
		<?php if ( $options['enable_pinterest_button'] == 1 ):
			$media_param = ( has_post_thumbnail() ) ? "&media=" . thrive_get_post_featured_image_src( get_the_ID(), "full" ) : "";
			?>

			<div class="ss">
				<a class="prinster" href="#"
				   onclick="return ThriveApp.open_share_popup('https://pinterest.com/pin/create/button/?url=<?php echo $current_url . $media_param; ?>', 545, 433);">
					<span data-pin-no-hover="true"><?php _e( 'Share', 'thrive' ) ?></span>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>
