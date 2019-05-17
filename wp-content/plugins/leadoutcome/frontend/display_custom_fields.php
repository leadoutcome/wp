<?php if (!defined('ABSPATH')) die('No direct access allowed!'); ?>

<?php
global $post;

$output = false;
?>

<div class="form-wrap">
	<div class="form-field form-required">
		<table class="form-table">

		<?php foreach ( $GLOBALS['DS_POST_CUSTOM_FIELDS'] as $custom_field ): ?>
			<?php //var_dump($custom_field); ?>
			<?php foreach ( $custom_field['object_type'] as $custom_field_object_type ): ?>
				<?php if ( $custom_field_object_type == $post->post_type ): ?>
					<?php $output = true; break; ?>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php if ( $output ): ?>
					<?php if ( $custom_field['field_type'] == 'hidden' ): ?>
						<input type="hidden" name="<?php echo ( $custom_field['field_id'] ); ?>" id="<?php echo ( $custom_field['field_id'] ); ?>" value="<?php echo ( get_post_meta( $post->ID, $custom_field['field_id'], true )); ?>" />
					<?php endif; ?>

					<?php if ( $custom_field['field_type'] == 'text' ): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td>
								<input type="text" <?php if(isset($custom_field['field_length'])) { if((int)$custom_field['field_length']*10 < 150) { ?> size="<?php echo $custom_field['field_length']; ?>" style="width:<?php echo ((int)$custom_field['field_length']*10); ?>px;"<?php } ?> maxlength="<?php echo $custom_field['field_length']; ?>" <?php } ?> name="<?php echo ( $custom_field['field_id'] ); ?>" id="<?php echo ( $custom_field['field_id'] ); ?>" value="<?php echo ( get_post_meta( $post->ID, $custom_field['field_id'], true )); ?>" />
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>
					<?php endif; ?>

					<?php if ( $custom_field['field_type'] == 'wysiwyg' ): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td>
								<div style="width:100%;">
								<?php wp_editor(get_post_meta( $post->ID, $custom_field['field_id'], true ), $custom_field['field_id'], array('media_buttons'=>true,'teeny'=>false,)); ?>
								</div>
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>
					<?php endif; ?>

					<?php if ( $custom_field['field_type'] == 'textarea' ): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td>
								<textarea name="<?php echo ( $custom_field['field_id'] ); ?>" id="<?php echo ( $custom_field['field_id'] ); ?>" rows="5" cols="40" ><?php echo ( get_post_meta( $post->ID, $custom_field['field_id'], true )); ?></textarea>
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>
					<?php endif; ?>

					<?php if ( $custom_field['field_type'] == 'radio' ): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td>
								<?php if ( get_post_meta( $post->ID, $custom_field['field_id'], true )): ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<input type="radio" name="<?php echo ( $custom_field['field_id'] ); ?>" id="<?php echo ( $custom_field['field_id'] ); ?>" value="<?php echo ( $field_option ); ?>" <?php if ( get_post_meta( $post->ID, $custom_field['field_id'], true ) == $field_option ) echo ( 'checked="checked"' ); ?>  style="width:auto !important;" /> <?php echo ( $field_option ); ?><br />
									<?php endforeach; ?>
								<?php else: ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<input type="radio" name="<?php echo ( $custom_field['field_id'] ); ?>" id="<?php echo ( $custom_field['field_id'] ); ?>" value="<?php echo ( $field_option ); ?>" <?php if ( $custom_field['field_default_option'] == $key ) echo ( 'checked="checked"' ); ?>   style="width:auto !important;" /> <?php echo ( $field_option ); ?><br />
									<?php endforeach; ?>
								<?php endif; ?>
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>
					<?php endif; ?>

					<?php if ( $custom_field['field_type'] == 'checkbox' ): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td>
								<?php if ( get_post_meta( $post->ID, $custom_field['field_id'], true )): ?>
									<?php $field_values = get_post_meta( $post->ID, $custom_field['field_id'], true ); ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<input type="checkbox" name="<?php echo ( $custom_field['field_id'] ); ?>[<?php echo ( $key ); ?>]" id="<?php echo ( $custom_field['field_id'] ); ?>" value="<?php echo ( $field_option ); ?>" <?php if ( $field_values[$key] == $field_option ) echo ( 'checked="checked"' ); ?> /> <?php echo ( $field_option ); ?><br />
									<?php endforeach; ?>
								<?php else: ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<input type="checkbox" name="<?php echo ( $custom_field['field_id'] ); ?>[<?php echo ( $key ); ?>]" id="<?php echo ( $custom_field['field_id'] ); ?>" value="<?php echo ( $field_option ); ?>" <?php if ( $custom_field['field_default_option'] == $key ) echo ( 'checked="checked"' ); ?> /> <?php echo ( $field_option ); ?><br />
									<?php endforeach; ?>
								<?php endif; ?>
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>
					<?php endif; ?>

					<?php if ( $custom_field['field_type'] == 'selectbox' ): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td>
								<select name="<?php echo ( $custom_field['field_id'] ); ?>" id="<?php echo ( $custom_field['field_id'] ); ?>">
								<?php if ( get_post_meta( $post->ID, $custom_field['field_id'], true )): ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<option value="<?php echo ( $field_option ); ?>" <?php if ( get_post_meta( $post->ID, $custom_field['field_id'], true ) == $field_option ) echo ( 'selected="selected"' ); ?> ><?php echo ( $field_option ); ?></option>
									<?php endforeach; ?>
								<?php else: ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<option value="<?php echo ( $field_option ); ?>" <?php if ( $custom_field['field_default_option'] == $key ) echo ( 'selected="selected"' ); ?> ><?php echo ( $field_option ); ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
								</select>
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>
					<?php endif; ?>

					<?php if ( $custom_field['field_type'] == 'multiselectbox' ): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td>
								<select name="<?php echo ( $custom_field['field_id'] ); ?>[]" id="<?php echo ( $custom_field['field_id'] ); ?>" multiple="multiple" class="ct-select-multiple">
								<?php if ( get_post_meta( $post->ID, $custom_field['field_id'], true )): ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<option value="<?php echo ( $field_option ); ?>"
										<?php foreach ( get_post_meta( $post->ID, $custom_field['field_id'], true ) as $field_value ): ?>
											<?php if ( $field_value == $field_option ) { echo ( 'selected="selected"' ); break; } ?>
										<?php endforeach; ?> ><?php echo ( $field_option ); ?></option>
									<?php endforeach; ?>
								<?php else: ?>
									<?php foreach ( $custom_field['field_options'] as $key => $field_option ): ?>
										<option value="<?php echo ( $field_option ); ?>" <?php if ( $custom_field['field_default_option'] == $key ) echo ( 'selected="selected"' ); ?> ><?php echo ( $field_option ); ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
								</select>
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>
					<?php endif; ?>

					<?php if($custom_field['field_type'] == 'image_upload'): ?>
						<tr>
							<th>
								<label for="<?php echo ( $custom_field['field_id'] ); ?>"><?php echo ( $custom_field['field_title'] ); ?></label>
							</th>
							<td><?php $this_img_src = wp_get_attachment_image_src( get_post_meta( $post->ID, $custom_field['field_id'], true ),'',false ); ?>
								<img id="<?php echo $custom_field['field_id']; ?>_img" src="<?php echo $this_img_src[0]; ?>" style="width:auto;min-width:0px;max-width:500px;" />
								<input id="<?php echo $custom_field['field_id']; ?>" name="<?php echo $custom_field['field_id']; ?>" type="hidden" value="<?php echo ( get_post_meta( $post->ID, $custom_field['field_id'], true )); ?>" />
								<input id="<?php echo $custom_field['field_id']; ?>_btn" type="button" value="<?php echo $custom_field['field_title']; ?>" />
								<p><?php echo ( $custom_field['field_description'] ); ?></p>
							</td>
						</tr>

					<script>
					(function($) {
						$(document).ready(function() {
							window.send_to_editor_default = window.send_to_editor;
							$('#<?php echo $custom_field['field_id']; ?>_btn').click(function() {
								// replace the default send_to_editor handler function with our own
								window.send_to_editor = window.<?php echo $custom_field['field_id']; ?>_attach_image;
								tb_show('', 'media-upload.php?post_id=<?php echo $post->ID ?>&amp;type=image&amp;TB_iframe=true');
								return false;
							});

							// handler function which is invoked after the user selects an image from the gallery popup.
							// this function displays the image and sets the id so it can be persisted to the post meta
							window.<?php echo $custom_field['field_id']; ?>_attach_image = function(html) {
								// turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
								$('body').append('<div id="temp_image">' + html + '</div>');

								var img = $('#temp_image').find('img');

								imgurl   = img.attr('src');
								imgclass = img.attr('class');
								imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);

								$('#<?php echo $custom_field['field_id']; ?>').val(imgid);

								$('img#<?php echo $custom_field['field_id']; ?>_img').attr('src', imgurl);
								try{tb_remove();}catch(e){};
								$('#temp_image').remove();

								// restore the send_to_editor handler function
								window.send_to_editor = window.send_to_editor_default;
							}
						});
					})(jQuery);
					</script>
					<?php endif; ?>
			<?php endif; $output = false; ?>
		<?php endforeach; ?>

		</table>
	</div>
</div>
