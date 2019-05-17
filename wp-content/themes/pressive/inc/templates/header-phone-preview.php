<table>
	<tr>
		<td>Full Screen Preview</td>
		<td>Mobile Screen Preview</td>
	</tr>
	<tr class="phone_background_set">
		<td>
			<div class="phone">
				<a href="tel:<?php echo $preview_params['header_phone_no']; ?>">
					<div class="phr">
						<span class="fphr"><?php echo $preview_params['header_phone_text']; ?></span>
						<span class="apnr"><?php echo $preview_params['header_phone_no']; ?></span>
					</div>
				</a>
			</div>
		</td>
		<td>
			<div class="phone_mobile <?php echo $preview_params['header_phone_btn_color'] ?>">
				<a href="tel:<?php echo $preview_params['header_phone_no']; ?>">
					<div class="phr">
						<span class="mphr"><?php echo $preview_params['header_phone_text_mobile']; ?></span>
						<span class="apnr"><?php echo $preview_params['header_phone_no']; ?></span>
					</div>
				</a>
			</div>
		</td>
	</tr>
</table>



