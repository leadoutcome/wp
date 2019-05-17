<?php
$focus_area_class   = $current_attrs['_thrive_meta_focus_color'][0];
$section_position   = ( $position == "bottom" ) ? "fab" : "fat";
$action_link_target = ( $current_attrs['_thrive_meta_focus_new_tab'][0] == 1 ) ? "_blank" : "_self";
?>

<a class="far f1 <?php echo $focus_area_class; ?> <?php echo $section_position; ?>"
   href="<?php echo $current_attrs['_thrive_meta_focus_button_link'][0]; ?>"
   target="<?php echo $action_link_target; ?>">
	<h4>
		<?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?>
		<span><?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?></span>
	</h4>
</a>
