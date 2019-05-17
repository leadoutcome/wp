<?php
require('../../../../wp-load.php');
$customer_name  = urldecode($_GET['name']);
$customer_email = urldecode($_GET['email']);
$overplay_id    = $_GET['id'];
if(wp_verify_nonce($_GET['_nounce'], 'vop_click_counter')) {
    global $wpdb;
    
    $vop_option = $videooverplay_class->get_admin_options();
    
    $table           = $wpdb->prefix . "videooverplay";
    $overplay_option = (array) json_decode($wpdb->get_var("SELECT options from $table WHERE id = $overplay_id "));
    //$videooverplay_class->vop_print($vop_option);
    //$videooverplay_class->vop_print($overplay_option);
	
    // Do any AR Stuff
	$firstname = urldecode($_GET['name']);
	$lastname = urldecode($_GET['name']);
	$email = urldecode($_GET['email']);
	
	
    if ($overplay_option['video_email_service'] == 'gr') { // Get Response
        require_once('../apis/getresponse-api/jsonRPCClient.php');
        $GR_client = new jsonRPCClient('http://api2.getresponse.com');
        try {
            $result = $GR_client->add_contact($vop_option['getresponse_api_key'], array(
                "campaign" => $overplay_option['getresponse_campaign'],
                "name" => $firstname . ' ' . $lastname,
                "email" => $email,
                "cycle_day" => '0',
                "ip" => $_SERVER['REMOTE_ADDR']
            ));
        }
        catch (Exception $e) {
            echo '<div class="message">GetResponse API Error: '.$e->getMessage().'</div>'; 
        }
        
    } else if ($overplay_option['video_email_service'] == 'aweber' && $vop_option['aweber_auth_code'] != '' && $vop_option['aweber_consumer_key'] != '') { // AWeber
        
        require_once('../apis/aweber_api/aweber_api.php');
        
        $aweber = new AWeberAPI($vop_option['aweber_consumer_key'], $vop_option['aweber_consumer_secret']);
        
        try {
            $account = $aweber->getAccount($vop_option['aweber_access_key'], $vop_option['aweber_access_secret']);
            $subs    = $account->loadFromUrl('/accounts/' . $account->id . '/lists/' . $overplay_option['aweber_list']. '/subscribers');
            
            # create a subscriber
            $params = array(
                'email' => $email,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'ad_tracking' => 'VideoOverplay',
                'name' => $firstname . ' ' . $lastname
            );
            
            $new_subscriber = $subs->create($params);
            
        }
        catch (AWeberAPIException $exc) {
            echo '<div class="message"><h3>AWeberAPIException:</h3><li> Type: ' . $exc->type . '<br><li> Msg : ' . $exc->message . '<br><li> Docs: ' . $exc->documentation_url . '<br><hr>';
        }
    } else if ($overplay_option['video_email_service'] == 'i' || $overplay_option['video_email_service'] == 'mc' || $overplay_option['video_email_service'] == 'other') {
        
        $ar_data = (array)$overplay_option['new_ar'];
        
        foreach ($ar_data['form_data'] as $key => $value) {
			$ar_data['form_data'] = (array)$ar_data['form_data'];
            if ($value == "%%EMAIL%%")
                $ar_data['form_data'][$key] = urldecode($email);
            if ($value == "%%NAME%%")
                $ar_data['form_data'][$key] = urldecode($firstname . ' ' . $lastname);
            if ($value == "%%FNAME%%")
                $ar_data['form_data'][$key] = urldecode($firstname);
            if ($value == "%%LNAME%%")
                $ar_data['form_data'][$key] = urldecode($lastname);
        }
        $args     = array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => $ar_data['form_data'],
            'cookies' => array()
        );
        $response = wp_remote_post($ar_data['action'], $args);
		//$videooverplay_class->vop_print($response);
    }
    
	$wpdb->query("UPDATE $table SET email_signup = email_signup + 1 WHERE id = $overplay_id");  
	
	if(isset($_GET['split_id']))
	{
		$split_id =  $_GET['split_id'];
		
		$table = $wpdb->prefix . "videooverload_split";
		$row = $wpdb->get_row("SELECT * FROM $table WHERE id = $split_id");
		if($row->vop_1_id == $overplay_id)
			$wpdb->query("UPDATE $table SET vop_1_email_signup = vop_1_email_signup + 1 WHERE id = $split_id");  	
		else if($row->vop_2_id == $overplay_id)
			$wpdb->query("UPDATE $table SET vop_2_email_signup = vop_2_email_signup + 1 WHERE id = $split_id");  	
	}
}
?> 