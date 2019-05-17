<div class="wrap">



	<p><a href="http://www.leadoutcome.com" target="_blank" title="<?php echo __('LeadOutcome','lo'); ?>"><img alt="" src="http://768fb7af815f78d7559a-1cf765037453fe7e5aa46c8e17022e63.r47.cf2.rackcdn.com/staging/sites/all/themes/rubik/cube/logo_1336174074.png" alt="<?php echo __('LeadOutcome','lo'); ?>" title="<?php echo __('LeadOutcome','lo'); ?>" style="width: 265px; height: 60px;border:none;" align="middle"></a>&nbsp;&nbsp;<input type="submit" class="button-primary" value="<?php _e('Account Setup') ?>" onClick="location.href='admin.php?page=leadoutcome_lead_track_convert_options';" />&nbsp;&nbsp;&nbsp;<input type="submit" class="button-primary" value="<?php _e('View / Manage Opt-in Forms') ?>" onClick="location.href='admin.php?page=leadoutcome_optin_forms';" />

	</p>

	<p>&nbsp;</p>





	<h2><?php _e('Test API','lo'); ?></h2>



	<?php

	if(isset($_REQUEST['deleted']) && $_REQUEST['deleted'])

	{

		lo_messages(__('Selected Forms have been deleted','lo'),'message');

	}

	?>



	<?php if(current_user_can('administrator')) { ?><h3><a href="#add_optin_form"><?php _e('Add New Opt-In Form','lo'); ?></a></h3><?php } ?>

	<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->

	<form id="forms-filter" method="get">

		<!-- For plugins, we also need to ensure that the form posts back to our current page -->

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />

		<!-- Now we can render the completed list table -->

		<h4 style="color:green;font-style:italic;">Copy and paste the shortcode(s) you want on your posts and pages to display the respective form</h4>

		<?php $LeadOutcome_OptinForms_List_Table->display() ?>

		<h4 style="color:green;font-style:italic;">Copy and paste the shortcode(s) you want on your posts and pages to display the respective form</h4>

	</form>

</div>



<br />

<br />

<hr />

<br />

<br />

<?php if(current_user_can('administrator')) { ?>

	<a id="add_optin_form" />

	<?php $add_optin_form_included = true; include_once( LO_PLUGIN_DIR . '/views/admin/form_add_optin_form.php' ); ?>

<?php

}

