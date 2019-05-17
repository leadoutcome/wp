<?php
$focus_area_class = $current_attrs['_thrive_meta_focus_color'][0];
$wrapper_class    = ( $position == "top" ) ? "wrp" : "wrp lfa";
$section_position = ( $position == "bottom" ) ? "farb" : "";
$optin_form_class = "f1f";
if ( $optinFieldsArray ) {
	$optin_form_class = ( count( $optinFieldsArray ) <= 4 ) ? "f" . count( $optinFieldsArray ) . "f" : "f14";
}
?>

<section class="far f4 <?php echo $focus_area_class; ?>">
	<div class="<?php echo $wrapper_class; ?>">
		<?php if ( $current_attrs['_thrive_meta_focus_image'][0] != "" ): ?>
			<div class="left fon">
				<img src="<?php echo $current_attrs['_thrive_meta_focus_image'][0]; ?>" alt=""/>
			</div>
			<div class="left ftw">
				<h4 class="upp">
					<?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?>
				</h4>

				<p>
					<?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?>
				</p>
			</div>
			<div class="clear"></div>
		<?php else: ?>
			<div class="left fac">
				<h4 class="upp">
					<?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?>
				</h4>

				<p>
					<?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?>
				</p>
			</div>
		<?php endif; ?>
		<div class="clear"></div>
		<div class="fth">
			<div class="frm <?php echo $optin_form_class; ?> clearfix">
				<form action="<?php echo $optinFormAction; ?>" method="<?php echo $optinFormMethod ?>">
					<?php echo $optinHiddenInputs; ?>

					<?php echo $optinNotVisibleInputs; ?>

					<?php if ( $optinFieldsArray ): ?>
						<?php foreach ( $optinFieldsArray as $name_attr => $field_label ): ?>
							<?php echo Thrive_OptIn::getInstance()->getInputHtml( $name_attr, $field_label, array( 'frmN' ) ); ?>
						<?php endforeach; ?>
					<?php endif; ?>

					<input type="submit" class="focus_submit"
					       value="<?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?>"/>

				</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</section>
