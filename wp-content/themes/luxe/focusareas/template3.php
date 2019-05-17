<?php
$focus_area_class = $current_attrs['_thrive_meta_focus_color'][0];
$wrapper_class    = ( $position == "top" ) ? "wrp" : "wrp lfa";
$section_position = ( $position == "bottom" ) ? "farb" : "";
$optin_form_class = "f1f";
if ( $optinFieldsArray ) {
	$optin_form_class = ( count( $optinFieldsArray ) <= 4 ) ? "f" . count( $optinFieldsArray ) . "f" : "f14";
}
?>

<section class="far f3 <?php echo $focus_area_class; ?>">
	<div class="<?php echo $wrapper_class; ?>">
		<div class="colm twc">
			<h4 class="upp"><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?></h4>

			<p><?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?></p>
		</div>
		<div class="colm twc lst">
			<div class="frm <?php echo $optin_form_class; ?> clearfix">
				<form action="<?php echo $optinFormAction; ?>" method="post">
					<?php
					if ( $optinFieldsArray ):
						foreach ( $optinFieldsArray as $name_attr => $field_label ):
							?>
							<input type="text" class="frmN" placeholder="<?php echo $field_label; ?>"
							       name='<?php echo _thrive_get_optin_name_attr_fixed( $name_attr ); ?>'/><br/>
							<?php
						endforeach;
					endif;
					?>
					<input type="submit" class="focus3_submit"
					       value="<?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?>"/>
					<?php echo $optinHiddenInputs; ?>
				</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</section>