<?php

/**
 * Contains the majority of the logic for this plugin.
 */

/**
 * Used for debugging to log file
 */
if (!function_exists('write_log')) {
	function write_log ( $log )  {
		global $lo_plugin_name;
		
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log('['.$lo_plugin_name.'] '.print_r( $log, true ) );
			} else {
				error_log( '['.$lo_plugin_name.'] '.$log );
			}
		}
	}
}

/**
 * Called when plugin is activated.  Creates database tables
 */
function lo_plugin_activate()
{
	global $wpdb;
	global $lo_version;

	/**
	 * Used by v2.0 and earlier of this plugin
	 */
	$sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix . "lo_optin_forms` (
		id INTEGER(11) NOT NULL AUTO_INCREMENT,
		blog_id INTEGER(11) NOT NULL,
		form_name VARCHAR(255) NOT NULL,
		full_form_content TEXT,
		email_only_form_content TEXT,
		subscribe_only_form_content TEXT,
		uid TEXT,
		PRIMARY KEY  (id)
		) ENGINE=InnoDB;";

	/*
	 * Used by v3.0 of this plugin to map wordpress users to mce users (drupal/java) and store the
	 * api key
	 */
	$sqlMember = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix . "lo_members` (
		id INTEGER(11) NOT NULL AUTO_INCREMENT,
		wp_uid INTEGER(11) NOT NULL,
		drpl_uid INTEGER(11) NOT NULL,
		ir_id INTEGER(11) NOT NULL,
		lo_name VARCHAR(255) NOT NULL,
		api_key VARCHAR(255) NULL,
		api_url VARCHAR(255) NULL,
		status TINYINT,
		PRIMARY KEY  (id)
		) ENGINE=InnoDB;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	dbDelta( $sqlMember );


	add_site_option( "lo_version", $lo_version );
	add_site_option( "lo_plugin_name", $lo_plugin_name);
}

function lo_fetch_lead_field( $atts, $content = null ) {
	$a = shortcode_atts(array( 'name' => 'none'), $atts, 'lead_field');
	return fetch_field($a,'lead');
}

function lo_fetch_member_field( $atts, $content = null ) {
	$a = shortcode_atts(array( 'name' => 'none'), $atts, 'member_field');
	return  fetch_field($a,'member');
}


function lo_video_smart_pixel( $atts, $content = null ) {
	$a = shortcode_atts(array( 'name' => 'none'), $atts, 'member_field');
	
	$svp = '<!--START VIDEO SMART PIXEL - DO NOT EDIT-->';
	$svp .= '<script type="text/javascript">';
	$svp .= '  var leadOutcome=new Object();';
	$svp .= '  leadOutcome.videoTracking = {';
	$svp .= '      onConvert:{emailNotification:"false", incrementScore:"0"},';
	$svp .= '      onPlay: {aCat:"2", aEC:"16601", uEC:"16601", emailNotification:"true", a1click:"32216", incrementScore:"15"},';
	$svp .= '      onPause: {aCat:"2", aEC:"16601", uEC:"16601", emailNotification:"true", a1click:"32216", incrementScore:"15"},';
	$svp .= '      onComplete: {emailNotification:"false", incrementScore:"0"},';
	$svp .= '      	salesRepId: 27288, uid: 25815}';
	$svp .= '</script><!--END VIDEO SMART PIXEL -->';
	$svp .= '<script src="//fast.wistia.net/static/iframe-api-v1.js"></script>';
	$svp .= '<script type="text/javascript" src="https://www.leadoutcome.com/sites/all/modules/leadoutcome/leadoutcome_tracking/js/video/wistia/wistia-external.min.js"></script>';
	$svp .= '<div id="wistia-tracking-tags"></div>';
	
	return  $svp;
}

function fetch_field($a, $type) {
    write_log('attrib:'.print_r($a,true));
    
    $conn = getApiKey("leadoutcome");
    write_log('conn'.print_r($conn,true));
    $value = '';
    if (isset($conn['api_key'])) {
    	if (!isset($_COOKIE['wp_lead_session_id'])) {
    		write_log('no cookie set');
    		$lead_tracking_id = wp_tracking_set_cookie();
    	}
    	else {
    		write_log('fetching cookie');
    		$lead_tracking_id = $_COOKIE['wp_lead_session_id'];
    	}
    	write_log('cookie='.$lead_tracking_id);
    	
    	//Setup Default API
    	$api_data = array(
    			'lead_tracking_id' => $lead_tracking_id,
    			'apiKey' => $conn['api_key'],
    			'field_attr' => $a['name'],
    			'field_type' => $type,
    			'referrer' => 'na',
    			'url' => 'na',
    			'timestamp' => $_SERVER['REQUEST_TIME']
    	);
    
    	write_log('api_data='.print_r($api_data,true));
    	//Loop Through $_GET and Setup API Data
    	foreach($_GET as $key => $value){
    		$key = str_replace('_','.',$key);
    		if (($key == 'url') || ($key == 'referrer')) {
    			$value = urlencode($value);
    		}
    		$api_data[$key] = $value;
    	}
    
    	//Call MCE API
    	$json_result = lo_api_fetch_field('leadoutcome_tracking', 'getFieldValue', $api_data);
    	$value = $json_result->{'value'};
    	
    }
    else
    	write_log('no api key set.');
    
    return $value;
}

/**
 * Fetches the lead / member field.  For leads searches the lead attributes, custom fields.
 * For member it will search the member fields and the member variable fields
 * 
 * @param unknown $module
 * @param unknown $op
 * @param unknown $data
 * @param string $retry
 * @return mixed
 */
function lo_api_fetch_field($module, $op, $data = array(), $retry = false){
	global $lo_domain;
	global $lo_api_java;
	
	$auth_key = null;

	//Setup Production URL (Use Localhost to Prevent Double LB Routing)
	write_log('$api_url='.$lo_api_url);
	//Add Secret Auth Key for Validation
	$data['auth_key'] = $auth_key;

	//Build Full API URL Action
	$url = $lo_domain.$lo_api_java."/action/".$op;

	//Log All Calls to Watchdog
	$api_request = 'MCE API Request ('.$op.'): '.$url.'<br/><br/>Data Sent: <pre>'.print_r($data, true).'</pre>';
	write_log('data='.print_r($data,true));
	//Execute Request, Decode JSON
	$ch = curl_init($url);
	$request_headers = array("X-Forwarded-For: ".$_SERVER["REMOTE_ADDR"]);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	curl_close($ch);

	//Grab JSON Response From MCe
	$json_result = json_decode($output);

	write_log('json_result='.print_r($json_result,true));

	if(!$json_result || $json_result->success != true){
		// got an error
	}

	return $json_result;
}


/**
 * Makes the request to lo to track this event for this lead.
 */
 function lo_api_tracking_request($module, $op, $data = array(), $retry = false){
	global $lo_domain;
	global $lo_api_java;
	
	$auth_key = null;
	
	//Setup Production URL (Use Localhost to Prevent Double LB Routing)
	if (isset($data['apiUrl']))
		$api_url = $data['apiUrl'].'/';
	else
		$api_url = $lo_domain.$lo_api_java.'/';
	
	write_log('$apiUrl='.$api_url);
	//Add Secret Auth Key for Validation
	$data['auth_key'] = $auth_key;

	//Build Full API URL Action
	$api_url .= $op;
	$api_request = '';

	//Log All Calls to Watchdog
	$api_request = 'MCE API Request ('.$op.'): '.$api_url.'<br/><br/>Data Sent: <pre>'.print_r($data, true).'</pre>';

	//Execute Request, Decode JSON
	$ch = curl_init($api_url);
	$request_headers = array("X-Forwarded-For: ".$_SERVER["REMOTE_ADDR"]);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $api_url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	curl_close($ch);

	//Grab JSON Response From MCe
	$json_result = json_decode($output);

	write_log('json_result='.print_r($json_result,true));

	if(!$json_result || $json_result->success != true){
		// got an error
	}

	return $json_result;
}

function lo_after_template_copy( $template, $destination_blog_id ) {
	write_log('======== lo_after_template_copy started');
	/*
	global $wpdb;
	
	$current_user = wp_get_current_user();
	$current_user = get_user_by('id', $current_user->ID);
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$current_user->ID);
	// each column in your row will be accessible like this
	write_log("name=".$row->lo_name);
	write_log("name=".$row->lo_name.'-'.$row->ir_id);
	
	$fields = array(
			'name' => urlencode($row->lo_name),
			'pass' => urlencode($current_user->user_login.'-'.$current_user->ID),
	);
	write_log('login-info name:'.$fields['name']);
	write_log('login-info pass:'.$fields['pass']);
	echo urlencode($row->lo_name);
	
	//
	// Step 7. Last step Create Thrive Connection and set the API keys.
	//
	write_log('create thrive connection');
	$loConnection = new Thrive_Dash_List_Connection_LeadOutcome('leadoutcome');
	$connectionDetails = array('api_key' => $result->{'api_key'}, 'api_url' => $result->{'api_url'} );
	$loConnection->setCredentials($connectionDetails);
	write_log('save_lo_member completed successfully');
	write_log('before save');
	$loConnection->save();
	write_log('after save');
	*/
	write_log('======== lo_after_template_copy finised');
}
/**
 * Called by woocommerce on order completion.  The user already exists
 * 
 */
 function lo_order_complete($order_id) {
 	$order = new WC_Order( $order_id );
 	$order_item = $order->get_items();
 	
 	foreach( $order_item as $product ) {
 		//write_log('product='.print_r($product,true));
 		//writsubstr($POST['id'],0,3) == 'tf2')e_log('product name='.$product['name']);
 		//write_log('product name='.$product['product_id']);
 		$prod = wc_get_product( $product['product_id'] );
 		 
 		$mceSku = $prod->get_attribute( 'mce-sku' );
 		if (isset($mceSku)) {
 			if ((strcasecmp($mceSku,'Basic') == 0) ||
 				(strcasecmp($mceSku,'Pro') == 0) ||
 				(strcasecmp($mceSku,'Premier') == 0)) {
 				write_log('create member mce-sku='.$mceSku);
 				$lo_result = create_member($order_id);	
 			}
 			else {
 				//
 				// MCE Product order
 				// 
 				processPurchasedMCEProduct($order, $prod, $mceSku);
 			}		
 		} 	
 	} 	
}
 
function processPurchasedMCEProduct($order, $prod, $mceSku) {
	global $wpdb;
	global $lo_domain;
	global $lo_api_java;
	
	$user = get_user_by('email', $order->billing_email);
	
	$loMember = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$user->ID);
	
	write_log('product_id='.$loMember->id);
	$fields = array(
			'member_id' => $loMember->ir_id,
			'product_id' =>	$prod->id,
			'mce-sku' =>	$mceSku,
			'status' =>	'1',
			'subscription' => 'true'
	);
		
	write_log('fields='.print_r($fields,true));
	$fields_string = '';
	
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
		
	//Build Full API URL Action
	$url = $lo_domain.$lo_api_java.'/action/purchasedProduct';
	$api_request = '';
		
	//Log All Calls to Watchdog
	write_log('url='.$url);
	//Execute Request, Decode JSON
	$ch = curl_init($url);
	$request_headers = array("X-Forwarded-For: ".$_SERVER["REMOTE_ADDR"]);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	$output = curl_exec($ch);
	curl_close($ch);
		
	//Grab JSON Response From mce
	$json_result = json_decode($output);
	write_log('$json_result='.print_r($json_result,true));
		
	if(isset($json_result->{'status'})) {
		write_log('$result='.print_r($json_result,true));
		write_log('purchased product procecessed by mce successfully');
	}
	else {
		write_log('no result from api request');
	}
}
/**
 * Called each time this plugin is started.  
 * 
 */
function lo_initialize()
{
	if(!session_id()) {
        session_start();
    }
    wp_tracking_set_cookie();
   
}

function lo_save_post( $post_id ) {
	write_log(" lo_save_post called...");
	$data = get_fields($post_id);	
	update_lo_fields($post_id, $data);
} 

function lo_edit_user_profile_update($user_id) {
	write_log("lo_edit_user_profile_update");
	write_log(print_r($_POST,true));
	update_lo_profile($user_id);
} 
 
/**
 * Called when user updates their profile
 * 
 */
function update_lo_profile($user_id) {
	global $lo_plugin_name;
	global $lo_domain;
	global $wpdb;
	global $lo_api_java;
	global $lo_api_drpl;
	global $lo_drpl_domain;
	global $lo_kit_id;
	/*
	$fieldsUpdate = array(
			'drpl_uid' => $result->{'drpl_uid'},
			'ir_id' =>	 $result->{'ir_id'},
			'kit_author_id' =>	$sponsorId,
			'kit_id' =>	$lo_kit_id,
			'mce-sku' => urlencode($mceSku),
			'company' => urlencode($billingList[2]->meta_value),
			'phone' => urlencode($billingList[4]->meta_value),
			'country' => urlencode($billingList[5]->meta_value),
			'address' => urlencode($billingList[6]->meta_value.' '.$billingList[7]->meta_value),
			'city' => urlencode($billingList[8]->meta_value),
			'state' => urlencode($billingList[9]->meta_value),
	); */
	
	write_log('fields='.print_r($_POST,true));
/*	$fields_string = '';
	foreach($_POST as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	*/
	
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$user_id);
	
	write_log("name=".$row->lo_name);
	write_log("name=".$row->lo_name.'-'.$row->ir_id);
	
	$_POST['ir_id'] = $row->ir_id;
	$_POST['drpl_uid'] = $row->drpl_uid;
	
	$avatar = get_avatar_url($user_id);
	write_log('avatar='.$avatar);
	$_POST['picture_url'] = $avatar;
	
	//Build Full API URL Action
	$url = $lo_domain.$lo_api_java.'/action/updateMemberProfile';
	$api_request = '';
	
	//Log All Calls to Watchdog
	write_log('url='.$url);
	//Execute Request, Decode JSON
	$ch = curl_init($url);
	$request_headers = array("X-Forwarded-For: ".$_SERVER["REMOTE_ADDR"]);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
	$output = curl_exec($ch);
	curl_close($ch);
	
	//Grab JSON Response From mce
	$json_result = json_decode($output);
	write_log('$json_result='.print_r($json_result,true));
	
	//
	// We want to save the API Key for thrive and LO calls
	//
	write_log('================ update_lo_profile finished');
		
}

/**
 * Called when user updates their profile
 *
 */
function update_lo_fields($post_id, $data) {
	global $lo_plugin_name;
	global $lo_domain;
	global $wpdb;
	global $lo_api_java;
	global $lo_api_drpl;
	global $lo_drpl_domain;
	global $lo_kit_id;
	
	$current_user = wp_get_current_user();
	
	if (count($data) == 0) {
		write_log('no post values...skipping update');
		return;
	}
	write_log('fields='.print_r($data,true));
	
	$fields_string = '';
	$isLoKey=false;
	if (is_array($data) || is_object($data)) {
		foreach($data as $key=>$value) {
			if (substr( $key, 0, 3 ) === "rmm") {
				$isLoKey=true;
				break;
			}
		}
	}
	
	if (!$isLoKey) {
		write_log('not a sales automator post...skipping update');	
		return;
	}	
	
	if (!isset($current_user)) {
		write_log('no current user...exiting');
		return;
	}	
	write_log('fetching lo mapping for user id:'.$current_user->ID);
		
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$current_user->ID);

	if (!isset($row)) {
		write_log('no lo mapping exists for user:'.$current_user->ID);
		return;
	}
	write_log("lo name=".$row->lo_name);
	write_log("name=".$row->lo_name.'-'.$row->ir_id);

	$data['ir_id'] = $row->ir_id;
	$data['drpl_uid'] = $row->drpl_uid;

	// 
	// Look for social settings and repackage it
	//
	
	if (isset($data['rmm-socials'])) {
		$socials = $data['rmm-socials'];
		$cnt=1;
		foreach($socials as $social) {
			write_log(" rmm-social-site=".$social['rmm-social-site']);
			write_log(" rmm-social-profile=".$social['rmm-social-profile']);
			$data['rmm-social-profile-'.$cnt] = $social['rmm-social-profile'];
			$cnt++;
		}
		unset($array['rmm-socials']);
	}
	//Build Full API URL Action
	$url = $lo_domain.$lo_api_java.'/action/updateMemberCustomFields';
	$api_request = '';

	//Log All Calls to Watchdog
	write_log('url='.$url);
	//Execute Request, Decode JSON
	$ch = curl_init($url);
	$request_headers = array("X-Forwarded-For: ".$_SERVER["REMOTE_ADDR"]);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	curl_close($ch);

	//Grab JSON Response From mce
	$json_result = json_decode($output);
	write_log('$json_result='.print_r($json_result,true));

	if(isset($json_result->{'apiKey'})){
		$result->{'api_key'} = $json_result->{'apiKey'};
		$result->{'api_url'} = $json_result->{'apiUrl'};
		write_log('$result='.print_r($result,true));

		//
		// Step 6. - Important save $result from /app/create-member in Step 4
		//           which contains the drupal/java user ids and the api keys
		//           generated from the Step 5 /action/updateNewMemberProfile call
		//           to the lo_members table
		save_lo_member($user_id, $result);
		write_log('save_lo_member completed successfully');
	}
	else {
		write_log('no api key provided');
	}

	//
	// We want to save the API Key for thrive and LO calls
	//
	write_log('================ create_member finished');

}
/**
 * This function is called after woocommerce completes its order.
 * 
 * @param unknown $order_id
 * @return boolean
 */
function create_member($order_id) {
	global $lo_plugin_name;
	global $lo_domain;
	global $wpdb;
	global $lo_api_java;
	global $lo_api_drpl;
	global $lo_drpl_domain;
	global $lo_kit_id;
	 
	write_log('================ create_member start');
		
	//
	// step 1. Get WooCommerce Order
	//
	write_log('order id :'.$order_id);
	$order = new WC_Order( $order_id );
	
	$order->billing_email;
	write_log('billing email:'.$order->billing_email);
	
	$user = get_user_by('email', $order->billing_email);
	$user_id = $user->ID;
	$user_info = get_userdata($user->ID);
	//write_log('user fields='.print_r($user, true));
	//write_log('user info fields='.print_r($user_info, true));
	 
	//
	// Get the order id based on user email = billing email
	//
	//$sql = 'SELECT post_id FROM '.$wpdb->prefix.'postmeta WHERE meta_key = "_billing_email" AND meta_value = "'.$user->user_email.'"';
	//$orderList = $wpdb->get_results($wpdb->prepare($sql));
	
	//write_log('sql='.$sql);
	//write_log('$orderList='.print_r($orderList,true));
	
	//
	// Step 2. Get the billing info based on ordder id
	//
	$sql = 'SELECT meta_key,meta_value FROM '.$wpdb->prefix.'postmeta WHERE meta_key LIKE "_billing_%" AND post_id = '.$order_id;
	$billingList = $wpdb->get_results($sql);
	write_log('sql='.$sql);
	
	//write_log('billing info='.print_r($billingList,true));
	write_log('billing key='.$billingList[0]->meta_key.' value='.$billingList[0]->meta_value);
	$billing_first_name = $billingList[0]->meta_value;
	write_log('billing first='.$billing_first_name);
	$billing_last_name = $billingList[1]->meta_value;
	write_log('billing last='.$billing_last_name);
	
	//
	// Ste 3. Search through all the products in the order for mce-sku custom field
	//
	$product_list = '';
	$order_item = $order->get_items();
	
	$membership = false;
	$membershipPurchased = 'notset';
	foreach( $order_item as $product ) {
		//write_log('product='.print_r($product,true));
		//write_log('product name='.$product['name']);
		//write_log('product name='.$product['product_id']);
		$prod = wc_get_product( $product['product_id'] );
	 	
		$mceSku = $prod->get_attribute( 'mce-sku' );
		if (isset($mceSku)) {
			write_log('product mce-sku='.$mceSku);
			$lo_kit_id = $prod->get_attribute( 'mce-kit-id' );
			$sponsorId = $prod->get_attribute( 'mce-sponsor-id' );
			if (isset($sponsorId) == false)
				$sponsorId = '27270';  // remove in future
			break;
		}
	}
	
	//
	// No mce product found then exit
	//
	if (isset($mceSku) == false) {
		write_log('no product found');
		return false;
	}
	
	
	//
	// Step 4. Lets create the drupal account first.  Does not use the mce api.  
	//
	$fields = array(
			'email' => urlencode($user->user_email),
			'sponsorId' => urlencode($sponsorId),
			'pass' => urlencode($user->user_login.'-'.$user_id),
			'first' => urlencode($billingList[0]->meta_value),
			'last' => urlencode($billingList[1]->meta_value),
			'phone' => urlencode($billingList[4]->meta_value),		
	);
	write_log('create_member fields setups fields:'.print_r($fields, true));
	$fields_string = '';
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	
	$ch = curl_init();
	$url = $lo_drpl_domain.$lo_api_drpl.'/create-member';
	
	write_log('$url='.$url);
	write_log('$fields='.print_r($fields,true));
	
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$curlResult = curl_exec($ch);
	write_log('result'.$curlResult);
	$result = json_decode($curlResult);
	write_log('json - result'.print_r($result,true));
	curl_close($ch);
	
	
	//
	// Step 5. Update mce with purchased order, billing info, product purchased
	//         kit_id - Is the kit that will be copied into user account
	//         compmay, phone country, address,city,state - will be set in user profile and ir record
	//         Used for can-spam compliance
	//         mce-sku is the product purchased
	//
	$fieldsUpdate = array(
		'drpl_uid' => $result->{'drpl_uid'},	
		'ir_id' =>	 $result->{'ir_id'},
		'kit_author_id' =>	$sponsorId,
		'kit_id' =>	$lo_kit_id,
		'mce-sku' => urlencode($mceSku),
		'company' => urlencode($billingList[2]->meta_value),
		'phone' => urlencode($billingList[4]->meta_value),
		'country' => urlencode($billingList[5]->meta_value),
		'address' => urlencode($billingList[6]->meta_value.' '.$billingList[7]->meta_value),
		'city' => urlencode($billingList[8]->meta_value),
		'state' => urlencode($billingList[9]->meta_value),
		);	
	
	write_log('fields='.print_r($fieldsUpdate,true));
	$fields_string = '';
	foreach($fieldsUpdate as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	//Build Full API URL Action
	$url = $lo_domain.$lo_api_java.'/action/updateNewMemberProfile';
	$api_request = '';
	
	//Log All Calls to Watchdog
	write_log('url='.$url);
	//Execute Request, Decode JSON
	$ch = curl_init($url);
	$request_headers = array("X-Forwarded-For: ".$_SERVER["REMOTE_ADDR"]);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsUpdate);
	$output = curl_exec($ch);
	curl_close($ch);
	
	//Grab JSON Response From mce
	$json_result = json_decode($output);
	write_log('$json_result='.print_r($json_result,true));
	
	if(isset($json_result->{'apiKey'})){
		$result->{'api_key'} = $json_result->{'apiKey'};
		$result->{'api_url'} = $json_result->{'apiUrl'};
		write_log('$result='.print_r($result,true));
		
		//
		// Step 6. - Important save $result from /app/create-member in Step 4 
		//           which contains the drupal/java user ids and the api keys 
		//           generated from the Step 5 /action/updateNewMemberProfile call
		//           to the lo_members table
		save_lo_member($user_id, $result);
		write_log('save_lo_member completed successfully');
	}
	else {
		write_log('no api key provided');
	}
	
	//
	// We want to save the API Key for thrive and LO calls
	//
	write_log('================ create_member finished');
}

function lo_admin_test_api()
{
	write_log('lo_admin_test_api');
	if ($_REQUEST['newUser'] == 'true') {
		$user_id = 23;
		lo_registration_save($user_id);
	}
	else if ($_REQUEST['login'] == 'true') {
		$user_id = 23;
		test_login();
	}
		
	//test_login();
	include_once(LO_PLUGIN_DIR.'/views/admin/admin_test_api.php');
}

/**
 * Saves the lo member to the wordpress / lo mapping table
 * 
 * @param unknown $user_id
 * @param unknown $lo_result
 */
function save_lo_member($user_id, $lo_result) {
	$status = 1;
	write_log('save_lo_member called');
	global $wpdb;
	write_log("lo_result : ".print_r($lo_result,true));
	write_log(" drpl_uid : ". $lo_result->drpl_uid);
	write_log(" drpl_uid2 : ". $lo_result->{'drpl_uid'});
	
	$wpdb->insert(
			$wpdb->prefix . 'lo_members',
			array(
					'wp_uid' => $user_id,
					'drpl_uid' => $lo_result->{'drpl_uid'},
					'ir_id' => $lo_result->{'ir_id'},
					'lo_name' => $lo_result->{'lo_name'},
					'status' => $status,
					'api_key' => $lo_result->{'api_key'},
					'api_url'=> $lo_result->{'api_url'}
			),
			array(
					'%d',
					'%d',
					'%d',
					'%s',
					'%d',
					'%s',
					'%s'
			)
	);
	$insert_id = $wpdb->insert_id;
	
	if($insert_id || $insert_id > 0)
	{
		write_log('save_lo_member successful');
	}
	else 
		write_log('save_lo_member failed');
		
	write_log('save_lo_member done');
}

/**
 * from v2.0
 */
function lo_init_scripts()
{
	global $wp_scripts,$wp_styles;


	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-ui-widget');

	wp_enqueue_style('jquery-ui-theme',LO_PLUGIN_DIR_URL.'/jqueryui/themes/'.JQUERY_UI_THEME.'/jquery-ui-1.8.14.custom.css' );

	//wp_enqueue_script('ds-frontend-scripts',LO_PLUGIN_DIR_URL.'/frontend/js/scripts.js',array(),false,true );

	$data = array(

	);

	wp_localize_script( 'ds-frontend-scripts', 'lo_frontend_scripts_data', $data );
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
}


/**
 * from v2.0
 * 
 * @param unknown $atts
 * @return Ambigous <string, string>
 */
function lo_optin_form_shortcode($atts) {

	global $wpdb;

	extract(shortcode_atts(array(
		'id' => 0,
		'type' => ''
	), $atts));

	$form_data = $wpdb->get_row($wpdb->prepare("SELECT `".$wpdb->escape($type)."` FROM `".$wpdb->prefix . "lo_optin_forms` WHERE `id`=%d AND `blog_id`=".get_current_blog_id(),$id),ARRAY_A);
	ob_start();

	if(is_array($form_data) && array_key_exists($type,$form_data) && $form_data[$type] != '')
	{
		echo do_shortcode(stripslashes($form_data[$type]));
	}

	$output = ob_get_contents();
	ob_end_clean();
	return do_shortcode($output);
}

/**
 * used from v2.0
 */
function lo_post_edit_form_tag( ) {
    echo ' enctype="multipart/form-data"';
}


/**
 * used to register admin / dashboard menu 
 */
function lo_admin_menu()
{
	global $lo_plugin_name; 
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	
	wp_enqueue_script('lo-script',LO_PLUGIN_DIR_URL.'frontend/js/lo-script.js',array(),false,true );
	
	//add_menu_page($lo_plugin_name, $lo_plugin_name, 'administrator', 'mce_main', 'lo_admin_leads_dash',plugins_url('leadoutcome/frontend/img/lo_icon.png'));
	add_menu_page($lo_plugin_name, $lo_plugin_name, 'edit_posts', 'mce_main', 'lo_admin_leads_dash',plugins_url('leadoutcome/frontend/img/lo_icon.png'));
	
	//add_menu_page(__('LeadOutcome', 'lo'), __('LeadOutcome', 'lo'), 'administrator', 'leadoutcom_main', 'lo_admin_main',plugins_url('leadoutcome/frontend/img/lo_icon.png'));
	//add_menu_page($lo_plugin_name, $lo_plugin_name, 'administrator', 'leadoutcom_main', 'lo_admin_main',plugins_url('leadoutcome/frontend/img/lo_icon.png'));
	//add_submenu_page( 'leadoutcom_main' , __('Leads Dashboard', 'lo'), __('Leads Dashboard', 'lo'), 'administrator', 'lo_admin_leads_dash', 'lo_admin_leads_dash');
	/*
	$act_optin_form_page = add_submenu_page( 'leadoutcom_main' , __('Opt-In Forms', 'lo'), __('Opt-In Forms', 'lo'), 'administrator', 'leadoutcome_optin_forms', 'lo_admin_optin_forms');

	$act_lead_track_convert_options_page = add_submenu_page( 'leadoutcom_main' , __('Lead Tracking / Conversions', 'lo'), __('Account Setup', 'lo'), 'administrator', 'leadoutcome_lead_track_convert_options', 'lo_admin_lead_track_convert_options');
    */
	//$act_lead_track_convert_options_page = add_submenu_page( 'leadoutcom_main' , __('Test API', 'lo'), __('Test API', 'lo'), 'administrator', 'lo_admin_test_api', 'lo_admin_test_api');
	//$act_lead_track_convert_options_page = add_submenu_page( 'leadoutcom_main' , __('Test API', 'lo'), __('Test New User API', 'lo'), 'administrator', 'lo_admin_test_create_user_api', 'lo_admin_test_create_user_api');
	//include_once(LO_PLUGIN_DIR.'/views/admin/admin_main.php');
	
}

/**
 * v2.0 logic
 */
function lo_admin_lead_track_convert_options()
{
	global $wpdb;

	$posts_update_success = false;
	$posts_update_success = false;
	$perform_update = false;

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update')
	{
		if(!current_user_can('manage_options'))
		{
			wp_die( __('You do not have priviledges to access this page','lo'), 'Access Denied!', array('back_link' => true) );
		}

		if ( !empty($_REQUEST['lononce']) && wp_verify_nonce($_REQUEST['lononce'],'lo_lead_track_convert_options_update') && $_REQUEST['action'] == 'update' )
		{
			$perform_update = true;
			$posts_update_success = update_site_option( 'lo_lead_track_convert_posts', ($_POST['lead_track_convert_posts'] == '1' ? '1' : '0') );
			$pages_update_success = update_site_option( 'lo_lead_track_convert_pages', ($_POST['lead_track_convert_pages'] == '1' ? '1' : '0') );
			$pages_update_success = update_site_option( 'lo_uid', $_POST['lo_uid'] );

		}
	}
	$lo_uid = get_site_option('lo_uid',1);
	$lo_lead_track_convert_posts = get_site_option('lo_lead_track_convert_posts',1);
	$lo_lead_track_convert_pages = get_site_option('lo_lead_track_convert_pages',1);
	include_once( LO_PLUGIN_DIR . '/views/admin/form_edit_lead_track_convert_options.php' );
}

function get_lo_domain() {
	global $lo_domain;
	global $wpdb;
	
	$current_user = wp_get_current_user();
	$current_user = get_user_by('id', $current_user->ID);
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$current_user->ID);
	
	$pos = strpos($row->api_url,"/app/mce");
	if ($pos === false) {
		write_log("api url not set properly for ".$current_user->ID);
	}
	else {
		$cust_lo_domain = substr($row->api_url, 0, $pos);
		write_log("cust api domain ".$cust_lo_domain." for user:".$current_user->ID);
	}
	echo $cust_lo_domain;
}

/**
 * Neeed to rework this logic.  Used in the iframe to autologin user into lo
 */
function get_lo_user() {
	global $wpdb;
	
	$current_user = wp_get_current_user();
	$current_user = get_user_by('id', $current_user->ID);
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$current_user->ID);
	// each column in your row will be accessible like this
	write_log("name=".$row->lo_name);
	write_log("name=".$row->lo_name.'-'.$row->ir_id);
	
	$fields = array(
			'name' => urlencode($row->lo_name),
			'pass' => urlencode($current_user->user_login.'-'.$current_user->ID),
	);
	write_log('login-info name:'.$fields['name']);
	write_log('login-info pass:'.$fields['pass']);
	echo urlencode($row->lo_name);
}

/**
 * Neeed to rework this logic.  Used in the iframe to autologin user into lo
 */
function get_lo_pass() {
	global $wpdb;

	$current_user = wp_get_current_user();
	$current_user = get_user_by('id', $current_user->ID);
	$row = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$current_user->ID);
	// each column in your row will be accessible like this
	write_log("name=".$row->lo_name);
	write_log("name=".$row->lo_name.'-'.$row->ir_id);

	$fields = array(
			'name' => urlencode($row->lo_name),
			'pass' => urlencode($current_user->user_login.'-'.$current_user->ID),
	);
	write_log('login-info name:'.$fields['name']);
	write_log('login-info pass:'.$fields['pass']);
	echo urlencode($current_user->user_login.'-'.$current_user->ID);
}

function lo_get_uid()
{
	if (!isset($lo_uid))
		$lo_uid = get_site_option('lo_uid');
	return $lo_uid;
}

/**
 * Not in use
 * @param unknown $current_user
 */
function login_leadoutcome($current_user) {
	global $wpdb;
	global $lo_domain;
	global $lo_api_url;
	/*
	if (isset($lo_api_url) && isset($wpdb) && isset($lo_domain)) {
		$url = $lo_api_url.'/user/login';
		write_log("api url=".$url);
		
		//$current_user = wp_get_current_user();
		$current_user = get_user_by('id', $current_user->ID);
		
		write_log("name=".$current_user->user_login.'-'.$current_user->ID);
		
		$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."lo_members WHERE wp_uid=".$current_user->ID);
		if (isset($row)) {
			// each column in your row will be accessible like this
			write_log("name=".$row->lo_name);
			write_log("name=".$row->lo_name.'-'.$row->ir_id);
			
			$fields = array(
					'name' => urlencode($row->lo_name),
					'pass' => urlencode($current_user->user_login.'-'.$current_user->ID),
			);
			write_log('login-info name:'.$fields['name']);
			write_log('login-info pass:'.$fields['pass']);
			
			//url-ify the data for the POST
			$fields_string="";
			foreach($fields as $key=>$value) { 
				$fields_string .= $key.'='.$value.'&';
			 }
			rtrim($fields_string, '&');
			
			//open connection
			$ch = curl_init();
			
			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			
			//execute post
			$result = curl_exec($ch);
			
			//close connection
			curl_close($ch);
		}
		else {
			write_log("no lo_member row exists");
		}
	}
	else 
		write_log("can not login");
	*/	
}


/**
 * Used to test lo api
 */
function lo_admin_test_create_user_api()
{
	write_log('lo_admin_test_create_user_api');
	include_once(LO_PLUGIN_DIR.'/views/admin/admin_test_api.php');
}

function lo_admin_leads_dash()
{
	include_once(LO_PLUGIN_DIR.'/views/admin/admin_leads_dash.php');
}

/**
 * 2.0 logic
 */
function lo_admin_optin_forms()
{
	global $wpdb;

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add')
	{
		$perform_create = false;
		$create_success = false;

		if ( !empty($_REQUEST['lononce']) && wp_verify_nonce($_REQUEST['lononce'],'lo_optin_form_add') && $_REQUEST['action'] == 'add' )
		{
			$perform_create = true;
			$wpdb->insert( 
				$wpdb->prefix . 'lo_optin_forms', 
				array( 
					'blog_id' => get_current_blog_id()
					,'form_name' => $_REQUEST['form_name'] 
					,'full_form_content' => $_REQUEST['full_form_content']
					,'email_only_form_content' => $_REQUEST['email_only_form_content']
					,'subscribe_only_form_content' => $_REQUEST['subscribe_only_form_content']
				), 
				array( 
					'%d',
					'%s',
					'%s',
					'%s',
					'%s'
				) 
			);

			$insert_id = $wpdb->insert_id;

			if($insert_id || $insert_id > 0)
			{
				$_REQUEST['form_id'] = $insert_id;
				$create_success = true;
			}
		}

		$form_data = $wpdb->get_row('SELECT * FROM `'.$wpdb->prefix . 'lo_optin_forms` WHERE `id`='.$wpdb->escape($_REQUEST['form_id']).' AND `blog_id`='.get_current_blog_id(),ARRAY_A);

		if($create_success || $create_success > 0)
		{
			include_once( LO_PLUGIN_DIR . '/views/admin/form_edit_optin_form.php' );
		}
		else
		{
			include_once( LO_PLUGIN_DIR . '/views/admin/form_add_optin_form.php' );
		}

	}
	elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['form_id']) && $_REQUEST['form_id'] > 0)
	{
		if(!current_user_can('manage_options'))
		{
			wp_die( __('You do not have priviledges to access this page','lo'), 'Access Denied!', array('back_link' => true) );
		}

		$perform_update = false;
		$update_success = false;
		if ( !empty($_REQUEST['lononce']) && wp_verify_nonce($_REQUEST['lononce'],'lo_optin_form_edit') && $_REQUEST['action'] == 'edit' )
		{
			$perform_update = true;
			$update_success = $wpdb->update( $wpdb->prefix . 'lo_optin_forms'
					, array(
						'form_name' => $_POST['form_name']
						,'full_form_content' => $_POST['full_form_content']
						,'email_only_form_content' => $_POST['email_only_form_content']
						,'subscribe_only_form_content' => $_POST['subscribe_only_form_content']
					)
					, array( 'id' => $wpdb->escape($_POST['form_id']),'blog_id'=>get_current_blog_id() ) );
		}
		$form_data = $wpdb->get_row('SELECT * FROM `'.$wpdb->prefix . 'lo_optin_forms` WHERE `id`='.$wpdb->escape($_REQUEST['form_id']).' AND `blog_id`='.get_current_blog_id(),ARRAY_A);
		include_once( LO_PLUGIN_DIR . '/views/admin/form_edit_optin_form.php' );
	}
	else
	{
		if(current_user_can('manage_options'))
		{
			if(!class_exists('WP_List_Table')){
				require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
			}
			if(!class_exists('LeadOutcome_OptinForms_List_Table')){
				require_once( LO_PLUGIN_DIR . '/includes/optin_forms_list_table.php' );
			}

			$LeadOutcome_OptinForms_List_Table = new LeadOutcome_OptinForms_List_Table($restrict_to_my_clubs);
			$LeadOutcome_OptinForms_List_Table->prepare_items();

			include_once(LO_PLUGIN_DIR.'/views/admin/admin_optin_forms.php');
		}
		else
		{
			wp_die( __('You do not have priviledges to access this page','lo'), 'Access Denied!', array('back_link' => true) );
		}
	}
}

/**
 * 2.0 logic
 */
function leadoutcome_optin_forms_edit()
{

}
/**
 * 2.0 logic
 */
function lo_delete_optin_form($ids)
{
	global $wpdb;
	if(!current_user_can('manage_options'))
	{
		wp_die( __('You do not have priviledges to access this page','lo'), 'Access Denied!', array('back_link' => true) );
	}

	for($a=0;$a<count($ids);$a++)
	{
		$wpdb->query($wpdb->prepare("DELETE FROM `".$wpdb->prefix . "lo_optin_forms` WHERE `id` = %d AND `blog_id` = %d",$ids[$a],get_current_blog_id()));
	}
	?>
	<script>location.replace('<?php echo $_REQUEST['_wp_http_referer'].'&deleted=1' ?>');</script>
	<?php
	exit;
}


/**
 * Hook gets called on public pages with footer
 *
 */
function lo_video_track() {
	global $lo_plugin_name;
	global $wpdb;
	global $post;

	write_log('================ lo_video_track start');

	$show_lead_track_convert_code = false;
	$lo_uid = get_site_option('lo_uid',1);
		
	$lo_lead_track_convert_activity = 'Video Event';
		
	if (!isset($incScore))
		$incScore = '10';
	write_log('about to call wp_tracking_page_visit');
	wp_tracking_page_visit($lo_lead_track_convert_activity, "Webinar Replay", $incScore);

	write_log('================ lo_video_track finished');

}
/**
 * Hook gets called on public pages with footer
 * 
 */
function lo_wp_footer() {
    global $lo_plugin_name;
	global $wpdb;
	global $post;
	
	write_log('================ lo_wp_footer start');
		
	$show_lead_track_convert_code = false;
	$lo_uid = get_site_option('lo_uid',1);
	
	if ( !is_admin() && !is_feed() && !is_robots() && !is_trackback() && isset($post->ID) ) {
		$lo_lead_track_convert_posts = get_site_option('lo_lead_track_convert_posts',1);
		$lo_lead_track_convert_pages = get_site_option('lo_lead_track_convert_pages',1);
		$current_post_type = get_post_type( $post->ID );

		$lo_this_page_visited_title = get_the_title( $post->ID );
		$lo_lead_track_convert_activity = 'Visited Page';
		if($current_post_type == 'post' && $lo_lead_track_convert_posts == 1)
		{
			$show_lead_track_convert_code = true;

			$lo_lead_track_convert_activity = 'Visited Post';
		}

		if($current_post_type == 'page' && $lo_lead_track_convert_pages == 1)
		{
			$show_lead_track_convert_code = true;

			$lo_lead_track_convert_activity = 'Visited Page';
		}

		if (!isset($incScore))
			$incScore = '5';
		write_log('about to call wp_tracking_page_visit');
		wp_tracking_page_visit($lo_lead_track_convert_activity, $lo_this_page_visited_title, $incScore);
		
	}
	else {
		write_log('skip tracking...');
    }
   /*
	if($show_lead_track_convert_code)
	{
		include_once(LO_PLUGIN_DIR.'/views/frontend/lead_track_convert_code.php');
	}
	*/
	write_log('================ lo_wp_footer finished');
       
}

function lo_messages($text,$type='message')
{
	if($type=='error')
	{
		echo '<div class="error"><p>'.$text.'</p></div>';
	}
	elseif($type=='message')
	{
		echo '<div id="message" class="updated below-h2"><p>'.$text.'</p></div>';
	}
}



/**
 * Sets the lead tracking cookie
 */
function wp_tracking_set_cookie() {
    $lead = NULL;
	if ((!isset($_COOKIE)) || (!isset($_COOKIE['wp_lead_session_id']))) {
		//Generate the ID
		$lead_id = uniqid('wp_lead_',true);
	
		$domain = $_SERVER['SERVER_NAME'];
	
		//Save the Cookie with our Current Domain
		$result = setcookie('wp_lead_session_id', $lead_id, time() + 60 * 60 * 24 * 1820, '/', '.'.$domain);
		write_log('setting cookie for domain='.$domain.' result='.$result);	
		if ($result == true)
			$_COOKIE['wp_lead_session_id'] = $lead_id;
				
	}
	return $lead;
}

/**
 * Gets the leadoutcome api key
 */
function getApiKey($key ) {
	$blog_id = get_current_blog_id();
	write_log('Current blog id:'.$blog_id);
	
	$details = get_option( 'thrive_mail_list_api', array() );
	//$details = get_blog_option($blog_id, 'thrive_mail_list_api');
	if ( empty( $key ) ) {
		return $details;
	}

	if ( ! isset( $details[ $key ] ) ) {
		return array();
	}

	return $details[ $key ];
}

/**
 * Functions as the tracking pixel.
 * 
 * 1. Sets the wp_lead_session_id session tracking cookie if not present
 * 2. Get referrrer, url, page, blog post and make mce api call so info can be stored in lead history
 * 
 * @param unknown $lo_lead_track_convert_activity
 * @param unknown $lo_this_page_visited_title
 */
function wp_tracking_page_visit($lo_lead_track_convert_activity, $lo_this_page_visited_title, $inc_score) {
	global $wpdb;
	
	write_log('In wp_tracking_page_visit');
	$conn = getApiKey("leadoutcome");
	write_log('conn'.print_r($conn,true));
	
	$current_user = wp_get_current_user();
	$loMember = $wpdb->get_row("SELECT * FROM ".$wpdb->base_prefix."lo_members WHERE wp_uid=".$current_user->ID);
	

	if (isset($conn['api_key'])) {
		write_log('before cookie for wp_lead_session_id='.$_COOKIE['wp_lead_session_id']);

		if ((!isset($_COOKIE)) || (!isset($_COOKIE['wp_lead_session_id']))) {
			write_log('no cookie set');
			$lead_id = wp_tracking_set_cookie();
		}
		else {
			write_log('fetching cookie');
			$lead_id = $_COOKIE['wp_lead_session_id'];
		}
		write_log('cookie='.$lead_id);
		
		$referrer = wp_get_referer();
		if ($referrer == false);
		   $referrer = 'referrer not provided';
		$url = get_permalink();
		if ($url == false)
			$url = 'wordpress page or post with no permalink';
		
		if (!isset($inc_score))
		   $inc_score = '5';
		//Setup Default API
		$api_data = array(
				'lead_session_id' => $lead_id,
				'uid' => filter_input(INPUT_GET, 'uid'), //Check if We Have a UID (For Member Scoping) on Tracking Pixels
				'apiKey' => $conn['api_key'],
				'apiUrl' => $conn['api_url'],
				'activity' => $lo_lead_track_convert_activity,
				'eventDetail' => $lo_this_page_visited_title,
				'incrementScore' => $inc_score,
				'referrer' => $referrer,
				'url' => $url,
				'timestamp' => $_SERVER['REQUEST_TIME']
		);

		write_log('api_data='.print_r($api_data,true));
		//Loop Through $_GET and Setup API Data
		foreach($_GET as $key => $value){
			$key = str_replace('_','.',$key);
			if (($key == 'url') || ($key == 'referrer')) {
				$value = urlencode($value);
			}
			$api_data[$key] = $value;
		}

		//Call MCE API
		lo_api_tracking_request('leadoutcome_tracking', 'addNote', $api_data);
	}
	else
		write_log('no api key set.');
	//Transparent Pixel
	//	header('Content-Type: image/png');
	//	echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
}

/*
 * Not used.
*/
function lo_login( $user_login, $user ) {
	write_log('lo_login called - login lo being called');
	login_leadoutcome($user);
}

/*
 * Not used.
*/
function lo_registration_save( $user_id ) {
	write_log('lo_registration_save ignoring hook');
}

/**
 * Used to register and ensure the javascript file that contains the functions
 *  for tracking lead events using ajax is included in every page load.
 *  
 *  This makes the javscript trackLeadEvent(eventName, eventActivity, eventDetails)
 *  available to all wordpress html pages.
 */
add_action( 'wp_enqueue_scripts', 'lead_ajax_tracking_enqueue_scripts' );
function lead_ajax_tracking_enqueue_scripts() {
	$result = wp_register_script( 'ajaxHandle', '/wp-content/plugins/leadoutcome/frontend/js/track-lead-events-ajax.js', array(), false, true );
	write_log('registered='.$result);
	wp_enqueue_script( 'ajaxHandle' );
	wp_localize_script( 'ajaxHandle', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'wp_ajax_nopriv_leadajaxtracking', 'lead_ajax_tracking' );
/**
 * Called by trackLeadEvent(eventName, eventActivity, eventDetails)
 * via an ajax call system.
 * 
 * The function simply calls wp_tracking_page_visit() to determine which lead 
 * gets this event and makes the curl call to leadoutcome to append the vent to lead's history
 */
function lead_ajax_tracking() {
	global $lo_plugin_name;
	global $wpdb;
	global $post;

	write_log('================ lead_ajax_tracking start');

	write_log('fields='.print_r($_POST,true));
	$data = $_POST['data'];
	$show_lead_track_convert_code = false;
	$lo_uid = get_site_option('lo_uid',1);

	$activity = $_POST['activity'];
	$detail = $_POST['details'];
	$incScore = $_POST['incScore'];
	if (!isset($incScore))
		$incScore = '10';
	write_log('about to call wp_tracking_page_visit');
	wp_tracking_page_visit($activity, $detail, $incScore);

	write_log('================ lead_ajax_tracking finished');
	wp_die();
}
