<?php

/**
 * LeadOutcome excpetion
 */
class Thrive_Dash_Api_LeadOutcome_Exception extends Exception {

}

/**
 * Manages the api calls between thrive and leadoutcome
 */
class Thrive_Dash_Api_LeadOutcome { 
	/**
	 * @var string API URL - taken from the leadoutcome integration / developer API page
	 */
	protected $_apiUrl;

	/**
	 * @var string API KEY - taken from the leadoutcome integration / developer API page
	 */
	protected $_apiKey;

	/**
	 * @var string
	 */
	protected $_apiFormat = 'json';

	public function __construct( $apiUrl, $apiKey ) {
		if ( empty( $apiKey ) || empty( $apiUrl ) ) {
			throw new Thrive_Dash_Api_LeadOutcome_Exception( 'Both API Url and API Key are required' );
		}

		$this->_apiKey = $apiKey;
		$this->_apiUrl = rtrim( $apiUrl, '/' ) . '/';
	}

	/**
	 * Retrieve all the subscriber lists, including all information associated with each.
	 *
	 * @return array
	 *
	 * @throws Thrive_Dash_Api_LeadOutcome_Exception
	 */
	public function getLists() {
		$result = $this->call( 'getCampaignList', null,null, 'POST' );
/*
		$lists = array();
		foreach ( $result as $index => $data ) {
			if ( is_numeric( $index ) ) {
				$lists [] = $data;
			}
		}
*/
		$lists = $result['campaignList'];
		
		return $lists;
	}

	/**
	 * Retrieve all the subscriber forms, including all information associated with each.
	 *
	 * @return array
	 *
	 * @throws Thrive_Dash_Api_LeadOutcome_Exception
	 */
	public function getForms() {
		$result = $this->call( 'form_getforms' );

		$forms = array();
		foreach ( $result as $index => $data ) {
			if ( is_numeric( $index ) ) {
				$forms [] = $data;
			}
		}

		return $forms;
	}

	/**
	 *  subscribe contact to a list
	 *
	 * @param $list_id
	 * @param $email
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $phone
	 * @param int $form_id
	 * @param string $organizationName
	 * @param array $tags
	 * @param null $ip
	 *
	 * @throws Thrive_Dash_Api_LeadOutcome_Exception
	 *
	 * @return array
	 */
	public function addSubscriber( $list_id, $email, $firstName = '', $lastName = '', $phone = '', $form_id = 0, $organizationName = '', $tags = array(), $ip = null ) {
		global $post;
		
		$lead_session_id = $_COOKIE['wp_lead_session_id'];
		$body = array(
			'lead_session_id'                     => $lead_session_id,
			'source'							  => 'WordPress Lead Capture Form',
			'email'                               => $email,
			'phone'                               => $phone,
			'campaignId'                 => $list_id,
			'instantresponders[' . $list_id . ']' => 1,
			'status[' . $list_id . ']'            => 1
		);

		write_log('addSubscriber='.print_r($body));
		if ( ! empty( $firstName ) ) {
			$body['first_name'] = $firstName;
		}

		if ( ! empty( $lastName ) ) {
			$body['last_name'] = $lastName;
		}

		if ( ! empty( $form_id ) ) {
			$body['form'] = $form_id;
		}

		if ( ! empty( $organizationName ) ) {
			$body['orgname'] = $organizationName;
		}
		if ( ! empty( $tags ) ) {
			if ( is_array( $tags ) ) {
				$tags = implode( ',', $tags );
			}
			$body['tags'] = $tags;
		}

		if ( ! empty( $ip ) ) {
			$body['ip4'] = $ip;
		}

		return $this->call( 'addLead', array(), $body, 'POST' );
	}

	public function updateSubscriber( $contact, $list_id, $email, $firstName = '', $lastName = '', $phone = '', $form_id = 0, $organizationName = '', $tags = array(), $ip = null ) {

		$body = array(
			'id'                                  => $contact['subscriberid'],
			'email'                               => $email,
			'phone'                               => $phone,
			'instantresponders[' . $list_id . ']' => 1,
		);

		if ( ! empty( $contact['lists'] ) ) {
			foreach ( $contact['lists'] as $id => $list ) {
				$body[ 'p[' . $id . ']' ]               = $id;
				$body[ 'status[' . $id . ']' ]          = $list['status'];
				$body[ 'first_name_list[' . $id . ']' ] = $list['first_name'];
				$body[ 'last_name_list[' . $id . ']' ]  = $list['last_name'];
			}
		}

		if ( ! in_array( $list_id, $contact['lists'] ) ) {
			$body[ 'p[' . $list_id . ']' ]               = $list_id;
			$body[ 'status[' . $list_id . ']' ]          = 1;
			$body[ 'first_name_list[' . $list_id . ']' ] = $firstName;
			$body[ 'last_name_list[' . $list_id . ']' ]  = $lastName;
		}

		foreach ( $contact['fields'] as $id => $field ) {
			$body[ 'field[' . $id . ', ' . $field['dataid'] . ']' ] = $field['val'];
		}

		if ( ! empty( $firstName ) ) {
			$body[ 'first_name_list[' . $list_id . ']' ] = $firstName;
			$body['first_name'] = $firstName;
		}

		if ( ! empty( $lastName ) ) {
			$body[ 'last_name_list[' . $list_id . ']' ] = $lastName;
			$body['last_name'] = $lastName;
		}

		if ( ! empty( $contact['tags'] ) ) {
			$body['tags'] = implode( ',', $contact['tags'] );
		}
		if ( $body['tags'] !== $tags ) {
			$body['tags'] = $body['tags'] . ',' . $tags;
		}

		return $this->call( 'addLead', array(), $body, 'POST' );
	}

	/**
	 * Performs a webservice api call
	 *
	 * @param $apiAction
	 * @param array $queryStringParams
	 * @param array $bodyParams
	 * @param string $method
	 *
	 * @return array
	 * @throws Thrive_Dash_Api_LeadOutcome_Exception
	 */
	public function call( $apiAction, $queryStringParams = array(), $bodyParams = array(), $method = 'GET' ) {
		$queryStringParams['api_key']    = $this->_apiKey;
		$queryStringParams['api_action'] = $apiAction;
		$queryStringParams['api_output'] = $this->_apiFormat;

		if ($bodyParams === null) {
			$bodyParams = array(
					'apiKey' =>  $this->_apiKey
			);
		}
		else 
			$bodyParams['apiKey'] = $this->_apiKey;
		$url = $this->_apiUrl . 'action/'.$apiAction;
	/*	foreach ( $queryStringParams as $key => $value ) {
			$url .= $key . '=' . $value . '&';
		}
*/
		$url = rtrim( $url, '&' );

		$args = array();

		switch ( $method ) {
			case 'POST':
				$args['body'] = $bodyParams;
				$function     = 'tve_dash_api_remote_post';
				break;
			case 'GET':
			default:
				$function = 'tve_dash_api_remote_get';
				break;
		}

		$response = $function( $url, $args );
		if ( $response instanceof WP_Error ) {
			throw new Thrive_Dash_Api_LeadOutcome_Exception( 'Failed connecting: ' . $response->get_error_message() );
		}

		$body = wp_remote_retrieve_body( $response );

		$data = $this->_parseResponse( $body );

		if ( empty( $data ) ) {
			if ( strpos( $data, 'g-recaptcha' ) !== false ) {
				throw new Thrive_Dash_Api_LeadOutcome_Exception( 'Unknown problem with the API request. Please recheck your account.' );
			}

			throw new Thrive_Dash_Api_LeadOutcome_Exception( 'Unknown problem with the API request. Response was:' . $body );
		}

		if ( isset( $data['status'] ) && $data['status'] == 'failed') {
			throw new Thrive_Dash_Api_LeadOutcome_Exception( 'API Error: ' . $data['msg'] );
		}

		return $data;
	}

	/**
	 * Parse the response based on $this->_apiFormat field
	 * @throws Thrive_Dash_Api_LeadOutcome_Exception
	 *
	 * @param string $response
	 *
	 * @return array
	 */
	protected function _parseResponse( $response ) {
		$response = trim( $response );
		switch ( $this->_apiFormat ) {
			case 'json':
				$data = @json_decode( $response, true );
				break;
			case 'serialize':
				$data = @unserialize( $response );
				break;
			case 'xml':
			default:
				throw new Thrive_Dash_Api_LeadOutcome_Exception( 'api_format not implemented: ' . $this->_apiFormat );
		}

		return $data;
	}

	/**
	 * @return string
	 */
	public function getApiUrl() {
		return $this->_apiUrl;
	}

	/**
	 * @param string $apiUrl
	 *
	 * @return Thrive_Dash_Api_LeadOutcome
	 */
	public function setApiUrl( $apiUrl ) {
		$this->_apiUrl = $apiUrl;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getApiKey() {
		return $this->_apiKey;
	}

	/**
	 * @param string $apiKey
	 *
	 * @return Thrive_Dash_Api_LeadOutcome
	 */
	public function setApiKey( $apiKey ) {
		$this->_apiKey = $apiKey;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getApiFormat() {
		return $this->_apiFormat;
	}

	/**
	 * @param string $apiFormat
	 *
	 * @return Thrive_Dash_Api_LeadOutcome
	 */
	public function setApiFormat( $apiFormat ) {
		$this->_apiFormat = $apiFormat;

		return $this;
	}


}