<article id="comments">
	<div class="awr">
		<div id="thrive_container_list_comments">
			<?php wp_list_comments( array( 'callback' => 'thrive_comments' ) ); ?>
		</div>
	</div>
	<div class="no_comm">
		<h4 class="ctr">
			<?php _e( "Comments are closed", 'thrive' ); ?>
		</h4>
	</div>
</article>