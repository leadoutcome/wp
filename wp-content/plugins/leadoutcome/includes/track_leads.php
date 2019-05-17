<?php 

/*
function leadoutcome_api_outgoing_request($module, $op, $data = array(), $retry = false){	
		global $lo_domain;
		$auth_key = null;
	
		//Setup Production URL (Use Localhost to Prevent Double LB Routing)
		$api_url = "https://leads.'.$lo_domain.'/app/mce/API/";
	
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
	 	
		if(!$json_result || $json_result->success != true){
			// got an error
		}
	
		return $json_result;
	}

	function wp_tracking_set_cookie(){
		//Generate the ID
		$lead_id = uniqid('wp_lead_',true);
	
		$domain = $_SERVER['SERVER_NAME'];
	
		//Save the Cookie with our Current Domain
		setcookie('wp_lead_session_id', $lead_id, time() + 60 * 60 * 24 * 1820, '/', '.'.$domain);
	
		return $lead_id;
	}
	
	function getApiKey($key ) {
		$details = get_option( 'thrive_mail_list_api', array() );
		
		if ( empty( $key ) ) {
			return $details;
		}
		
		if ( ! isset( $details[ $key ] ) ) {
			return array();
		}
		
		return $details[ $key ];
	}
	
	function wp_tracking_page_visit($lo_lead_track_convert_activity, $lo_this_page_visited_title) {
		write_log('In wp_tracking_page_visit');
		$conn = getApiKey("leadoutcome");
		write_log('conn='.print_r($conn,true));
		if (isset($conn['api_key'])) {
			if (!isset($_COOKIE['wp_lead_session_id']) && !isset($_COOKIE['wp_lead_session_id'])) {
				$lead_id = wp_tracking_set_cookie();
			}
			else
				$lead_id = $_COOKIE['wp_lead_session_id'];
				
			//Setup Default API
			$api_data = array(
					'lead_session_id' => $lead_id,
					'uid' => filter_input(INPUT_GET, 'uid'), //Check if We Have a UID (For Member Scoping) on Tracking Pixels
					'apiKey' => $conn['api_key'],
					'activity' => $lo_lead_track_convert_activity,
					'eventDetail' => $lo_this_page_visited_title,
					'sendEmail' => $_GET['sendEmail'],
					'incrementScore' => '5',
					'referrer' => $referrer,
					'url' => $url,
					'timestamp' => $_SERVER['REQUEST_TIME'],
					'remoteHost' => $_SESSION['leadoutcome_tracking']['previous_ip']
			);
	
			//Loop Through $_GET and Setup API Data
			foreach($_GET as $key => $value){
				$key = str_replace('_','.',$key);
				if (($key == 'url') || ($key == 'referrer')) {
					$value = urlencode($value);
				}
				$api_data[$key] = $value;
			}
		
			//Call MCE API
			leadoutcome_api_outgoing_request('leadoutcome_tracking', 'addNote', $api_data);
		}
		else 
			write_log('no api key set.');
		//Transparent Pixel
	//	header('Content-Type: image/png');
	//	echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
		
	}
*/
?>
