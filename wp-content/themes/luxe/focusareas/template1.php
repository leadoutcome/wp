<?php
$focus_area_class   = $current_attrs['_thrive_meta_focus_color'][0];
$action_link_target = ( $current_attrs['_thrive_meta_focus_new_tab'][0] == 1 ) ? "_blank" : "_self";
$wrapper_class      = ( $position == "top" ) ? "wrp" : "wrp lfa";
$section_position   = ( $position == "bottom" ) ? "farb" : "";
?>

<section class="far f1 <?php echo $focus_area_class; ?>">
	<div class="<?php echo $wrapper_class; ?>">
		<div class="left">
			<h4 class="upp"><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?></h4>
			<p><?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?></p>

		</div>
		<div class="right">
			<a href="<?php echo $current_attrs['_thrive_meta_focus_button_link'][0]; ?>" class="gBt upp"
			   target="<?php echo $action_link_target; ?>">
				<?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?>
			</a>
		</div>
		<div class="clear"></div>
	</div>
</section>