<div class="wrap">

	<p><a href="http://www.leadoutcome.com" target="_blank" title="<?php echo __('LeadOutcome','lo'); ?>"><img alt="" src="http://768fb7af815f78d7559a-1cf765037453fe7e5aa46c8e17022e63.r47.cf2.rackcdn.com/staging/sites/all/themes/rubik/cube/logo_1336174074.png" alt="<?php echo __('LeadOutcome','lo'); ?>" title="<?php echo __('LeadOutcome','lo'); ?>" style="width: 265px; height: 60px;border:none;" align="middle"></a>&nbsp;&nbsp;
    
    	<input type="submit" class="button-primary" value="<?php _e('Account Setup') ?>" onClick="location.href='admin.php?page=leadoutcome_lead_track_convert_options';" />&nbsp;&nbsp;&nbsp;<input type="submit" class="button-primary" value="<?php _e('View / Manage Opt-in Forms') ?>" onClick="location.href='admin.php?page=leadoutcome_optin_forms';" /> <input type="submit" class="button-primary" value="<?php _e('Test API') ?>" onClick="location.href='admin.php?page=leadoutcome_api_test';" />

	</p>
	<p>&nbsp;</p>
    <?php 

		if($perform_update)
		{
			if($posts_update_success || $pages_update_success)
			{
				lo_messages(__('Tracking / Conversions code options have been updated successfully.','lo'),'message');

			}
			else
			{
				lo_messages(__('There was a problem updating the tracking / conversions code options.  Please try again.','lo'),'error');

			}
		}

		?>

	<p>In order for the plugin to properly track and score your Leads you must enter your Account UID (User Identifier).  You can find this number in your "My Account Profile" page.  Follow these steps in order to copy the uid number and paste it into the text box below.</p>
        
        <h2>STEP 1.   Login to your Account and go to your "My Profile" page</h2>
        <br />
        <img src="<?php  echo plugins_url('leadoutcome/frontend/img/select-account-info.png'); ?>"/>
        <br />
        <h2>STEP 2.   Select "Edit Account Info" page</h2>
        <br />
        <img src="<?php  echo plugins_url('leadoutcome/frontend/img/edit-account-info.png'); ?>"/>
        <h2>STEP 3.   Copy your UID </h2>
        <br />
        <img src="<?php  echo plugins_url('leadoutcome/frontend/img/copy-account-uid.png'); ?>"/>
        <h2>STEP 4.   Paste your uid into the text box below and press on the Update Button</h2>

	<div style="width:50%">
		

		<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->

		<form id="optin-forms-filter" method="post" action="admin.php?page=leadoutcome_lead_track_convert_options">

			<input type="hidden" name="action" value="update" />

			<?php wp_nonce_field('lo_lead_track_convert_options_update','lononce'); ?>

			<table class="form-table">
<tr>

			<td><strong>Account UID</strong>: <input type="text" name="lo_uid" size="7" maxlength="7" value="<?php echo isset($_POST['lo_uid']) ? stripslashes($_POST['lo_uid']) : $lo_uid; ?>" /></td>

			</tr>

<tr>
<td>
		<p>TEST 4 Use these options to set whether or not lead tracking code will automatically be inserted on pages or posts.  If the option is checked, for that respective page type we will insert the tracking code for at the bottom of each page</p>

</td>
</tr>
			<tr>

				<td><input type="checkbox" name="lead_track_convert_posts" value="1" <?php echo $lo_lead_track_convert_posts == 1 ? 'checked="checked"' : ''; ?> />&nbsp;<strong><?php _e('Tracking On Posts','lo'); ?></strong></td>

			</tr>

			<tr>

				<td><input type="checkbox" name="lead_track_convert_pages" value="1" <?php echo $lo_lead_track_convert_pages == 1 ? 'checked="checked"' : ''; ?> />&nbsp;<strong><?php _e('Tracking On Pages','lo'); ?></strong></td>

			</tr>

			</table>

			<p class="submit">

			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

			</p>

		</form>

	</div>

</div>

