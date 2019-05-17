<div class="wrap">



	<?php if(!isset($add_optin_form_included) || !$add_optin_form_included) { ?>

	<p><a href="http://www.leadoutcome.com" target="_blank" title="<?php echo __('LeadOutcome','lo'); ?>"><img alt="" src="http://768fb7af815f78d7559a-1cf765037453fe7e5aa46c8e17022e63.r47.cf2.rackcdn.com/staging/sites/all/themes/rubik/cube/logo_1336174074.png" alt="<?php echo __('LeadOutcome','lo'); ?>" title="<?php echo __('LeadOutcome','lo'); ?>" style="width: 265px; height: 60px;border:none;" align="middle"></a>&nbsp;&nbsp;<input type="button" class="button-primary" value="<?php _e('View / Manage Opt-in Forms') ?>" onClick="location.href='admin.php?page=leadoutcome_optin_forms';" />&nbsp;&nbsp;&nbsp;<input type="button" class="button-primary" value="<?php _e('Account Setup') ?>" onClick="location.href='admin.php?page=leadoutcome_lead_track_convert_options';" />

	</p>

	<p>&nbsp;</p>

	<?php } ?>



	<h2><?php _e('LeadOutcome - Opt-In Form Add','lo'); ?></h2>



	<?php 

	if(isset($perform_create) && $perform_create)

	{

		if(isset($create_success) && (!$create_success || $create_success <=0))

		{

			lo_messages(__('There was a problem adding the form.  Please try again.','lo'),'error');

		}



		if(isset($create_success) && $create_success > 0)

		{

			lo_messages(__('Your new Opt-In form has been created.','lo'),'message');

		}

	}

	?>



	<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->

	<form id="lo-optinform-add-filter" method="post" action="admin.php?page=leadoutcome_optin_forms">

		<input type="hidden" name="action" value="add" />

		<?php wp_nonce_field('lo_optin_form_add','lononce'); ?>

		<table class="form-table">

		<tr>

			<th><strong><?php _e('Form Name','lo'); ?></strong></th>

			<td><input type="text" name="form_name" size="100" maxlength="255" value="<?php echo isset($_POST['form_name']) && !$create_success ? stripslashes($_POST['form_name']) : ''; ?>" /></td>

		</tr>



		<tr>

			<th><strong><?php _e('Full Opt-In Form','lo'); ?></strong></th>

			<td>

				<textarea name="full_form_content" style="width:75%;height:300px;"><?php echo isset($_POST['full_form_content']) && !$create_success ? stripslashes($_POST['full_form_content']) : ''; ?></textarea>

			</td>

		</tr>



		<tr>

			<th><strong><?php _e('Email Only Opt-In Form','lo'); ?></strong></th>

			<td>

				<textarea name="email_only_form_content" style="width:75%;height:300px;"><?php echo isset($_POST['email_only_form_content']) && !$create_success ? stripslashes($_POST['email_only_form_content']) : ''; ?></textarea>

			</td>

		</tr>



		<tr>

			<th><strong><?php _e('Subscribe Button Opt-In Form','lo'); ?></strong></th>

			<td>

				<textarea name="subscribe_only_form_content" style="width:75%;height:300px;"><?php echo isset($_POST['subscribe_only_form_content']) && !$create_success ? stripslashes($_POST['subscribe_only_form_content']) : ''; ?></textarea>

			</td>

		</tr>



		</table>



		<p class="submit">

		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

		</p>



	</form>

</div>

