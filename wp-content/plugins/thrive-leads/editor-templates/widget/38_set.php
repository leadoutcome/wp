<?php
$config = tve_leads_errors_config();
/* always include all elements inside a thrv-leads-widget element */
?>
<div class="thrv-leads-widget thrv_wrapper tve_editor_main_content tve_38_set tve_brdr_solid">
	<h2 style="color: #272c32; font-size: 36px; margin-top: 15px;margin-bottom: 0;" class="rft tve_p_center">
		Subscribe to our Newsletter!
	</h2>

	<p style="color: #5b6168; font-size: 18px; margin-top: 0;">
		Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id
		elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.
	</p>

	<div style="width: 137px;margin-top: 30px;" class="thrv_wrapper tve_image_caption aligncenter">
                 <span class="tve_image_frame">
                    <img class="tve_image"
                         src="<?php echo TVE_LEADS_URL . 'editor-templates/_form_css/images/set_38_icon.png' ?>"
                         style="width: 137px;"/>
                </span>
	</div>
	<div data-tve-style="1"
	     class="thrv_wrapper thrv_lead_generation tve_clearfix tve_blue thrv_lead_generation_vertical tve_3"
	     data-inputs-count="3" style="margin-top: 0;margin-bottom: 0;">
		<div style="display: none;" class="thrv_lead_generation_code"></div>
		<input type="hidden" class="tve-lg-err-msg" value="<?php echo htmlspecialchars( json_encode( $config ) ) ?>"/>

		<div class="thrv_lead_generation_container tve_clearfix">
			<div class="tve_lead_generated_inputs_container tve_clearfix">
				<div class="tve_lead_fields_overlay"></div>
				<div class="tve_lg_input_container  tve_lg_3 tve_lg_input">
					<input type="text" name="name" value="" data-placeholder="name" placeholder="Name">
				</div>
				<div class="tve_lg_input_container  tve_lg_3 tve_lg_input">
					<input type="text" name="email" value="" data-placeholder="email" placeholder="Email">
				</div>
				<div class="tve_lg_input_container tve_submit_container tve_lg_3 tve_lg_submit">
					<button type="Submit">download</button>
				</div>
			</div>
		</div>
	</div>
</div>
