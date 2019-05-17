<?php
$focus_area_class     = $current_attrs['_thrive_meta_focus_color'][0];
$section_position     = ( $position == "bottom" ) ? "fab" : "fat";
$form_container_class = ( count( $optinFieldsArray ) <= 4 ) ? "i" . count( $optinFieldsArray ) : "i4";
?>

<div class="far f3 <?php echo $focus_area_class; ?> <?php echo $section_position; ?>">
	<div class="tw">
		<?php if ( $current_attrs['_thrive_meta_focus_image'][0] != "" ): ?>
			<div class="iw"><img src="<?php echo $current_attrs['_thrive_meta_focus_image'][0]; ?>"></div>
		<?php endif; ?>
		<div class="twr">
			<div class="wh" style="display: block;">
				<h4><?php echo $current_attrs['_thrive_meta_focus_heading_text'][0]; ?></h4>

				<div class="db"></div>
			</div>

			<div class="clear"></div>
			<p>
				<?php echo nl2br( do_shortcode( $current_attrs['_thrive_meta_focus_subheading_text'][0] ) ); ?>
			</p>
		</div>
		<div class="clear"></div>
	</div>

	<div class="frm <?php echo $form_container_class; ?>">
		<form action="<?php echo $optinFormAction; ?>" method="<?php echo $optinFormMethod ?>">

			<?php echo $optinHiddenInputs; ?>

			<?php echo $optinNotVisibleInputs; ?>

			<?php if ( $optinFieldsArray ): ?>
				<?php foreach ( $optinFieldsArray as $name_attr => $field_label ): ?>
					<?php echo Thrive_OptIn::getInstance()->getInputHtml( $name_attr, $field_label ); ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="fob">
				<input type="submit" value="<?php echo $current_attrs['_thrive_meta_focus_button_text'][0]; ?>"/>
			</div>
		</form>
	</div>
</div>