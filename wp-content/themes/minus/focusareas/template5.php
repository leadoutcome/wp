<?php
$focus_area_class = $current_attrs['_thrive_meta_focus_color'][0];
$wrapper_class    = ( $position == "top" ) ? "wrp" : "wrp lfa";
$section_position = ( $position == "bottom" ) ? "farb" : "";
$btn_class        = ( empty( $current_attrs['_thrive_meta_focus_button_color'][0] ) ) ? "blue" : strtolower( $current_attrs['_thrive_meta_focus_button_color'][0] );
if ( ! is_array( $optinFieldsArray ) ) {
	$optinFieldsArray = array();
}
if ( count( $optinFieldsArray ) > 2 ) {
	echo "This focus area template supports only 2 input fields. Please check your opt-in configuration in order to use this template.";

	return;
}
?>

<section class="far f5 <?php echo $focus_area_class; ?> <?php echo $section_position; ?>">
	<div class="<?php echo $wrapper_class; ?>">
		<?php if ( $current_attrs['_thrive_meta_focus_image'][0] != "" ): ?>
			<div class="left">
				<img class="f5l left" src="<?php echo $current_attrs['_thrive_meta_focus_image'][0]; ?>" alt="">
				<div class="f5r left">
					<h4 class="upp"><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?></h4>
					<p>
						<?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?>
					</p>
				</div>
				<div class="clear"></div>
			</div>
		<?php else: ?>
			<div class="left">
				<h4 class="upp"><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?></h4>
				<p>
					<?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?>
				</p>
			</div>
		<?php endif; ?>
		<div class="clear"></div>
		<hr>
		<div class="frm">
			<form action="<?php echo $optinFormAction; ?>" method="post">
				<?php
				$index = 0;
				if ( $optinFieldsArray && is_array( $optinFieldsArray ) ):
					if ( count( $optinFieldsArray ) == 2 ) {
						$input_class = "input_for_2_fields";
					} else {
						$input_class = "input_for_1_fields";
					}
					foreach ( $optinFieldsArray as $name_attr => $field_label ):?>
						<input type="text" placeholder="<?php echo $field_label; ?>" name='<?php echo _thrive_get_optin_name_attr_fixed( $name_attr ); ?>'
						       class="<?php echo $input_class; ?> left"/>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php
				if ( count( $optinFieldsArray ) == 2 ) {
					$submit_class = "submit_with_2_fields";
				} else {
					$submit_class = "submit_with_1_fields right";
				}
				?>
				<div class="btn <?php echo $btn_class; ?> <?php echo $submit_class; ?>">
					<input type="submit" value="<?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?>"
					       class="fbt right focus_submit"/>
				</div>
				<?php echo $optinHiddenInputs; ?>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</section>