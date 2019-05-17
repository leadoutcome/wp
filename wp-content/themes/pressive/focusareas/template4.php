<?php
$focus_area_class   = $current_attrs['_thrive_meta_focus_color'][0];
$section_position   = ( $position == "bottom" ) ? "farb" : "";
$action_link_target = ( $current_attrs['_thrive_meta_focus_new_tab'][0] == 1 ) ? "_blank" : "_self";
?>
<div class="far f4 <?php echo $focus_area_class; ?> <?php echo $section_position; ?>">
	<div class="tw">
		<a href="<?php echo $current_attrs['_thrive_meta_focus_button_link'][0]; ?>"
		   target="<?php echo $action_link_target; ?>" class="fob">
			<span><?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?></span>
		</a>
		<h4><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?> </h4>
		<p>
			<?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?>
		</p>
	</div>
</div>