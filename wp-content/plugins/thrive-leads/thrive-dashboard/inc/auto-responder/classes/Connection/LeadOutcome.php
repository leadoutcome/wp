<?php 
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
 * Manages the the thrive to leadoutcome api connection
 */
class Thrive_Dash_List_Connection_LeadOutcome extends Thrive_Dash_List_Connection_Abstract {
	/**
	 * Return the connection type
	 * @return String
	 */
	public static function getType() {
		return 'autoresponder';
	}

	/**
	 * @return string the API connection title
	 */
	public function getTitle() {
		return 'Sales Automator';
	}

	/**
	 * output the setup form html
	 *
	 * @return void
	 */
	public function outputSetupForm() {
		$this->_directFormHtml( 'leadoutcome' );
	}

	/**
	 * should handle: read data from post / get, test connection and save the details
	 *
	 * on error, it should register an error message (and redirect?)
	 *
	 * @return mixed
	 */
	public function readCredentials() {
		$url = ! empty( $_POST['connection']['api_url'] ) ? $_POST['connection']['api_url'] : '';
		$key = ! empty( $_POST['connection']['api_key'] ) ? $_POST['connection']['api_key'] : '';

		if ( empty( $key ) || empty( $url ) ) {
			return $this->error( __( 'Both API URL and API Key fields are required', TVE_DASH_TRANSLATE_DOMAIN ) );
		}

		$this->setCredentials( $_POST['connection'] );

		$result = $this->testConnection();

		if ( $result !== true ) {
			return $this->error( sprintf( __( 'Could not connect to the system using the provided details. Response was: <strong>%s</strong>', TVE_DASH_TRANSLATE_DOMAIN ), $result ) );
		}

		/**
		 * finally, save the connection details
		 */
		$this->save();

		return $this->success( __( 'LeadOutcome connected successfully', TVE_DASH_TRANSLATE_DOMAIN ) );
	}

	/**
	 * test if a connection can be made to the service using the stored credentials
	 *
	 * @return bool|string true for success or error message for failure
	 */
	public function testConnection() {
		/** @var Thrive_Dash_Api_LeadOutcome $api */
		$api = $this->getApi();

		try {  
			$data = $api->call( 'getMember', null, null, 'POST');
			if (isset( $data['id'])) 
				return true;
			else 
				return false;
		} catch ( Thrive_Dash_Api_LeadOutcome_Exception $e ) {
			return $e->getMessage();
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}

	/**
	 * instantiate the API code required for this connection
	 *
	 * @return mixed
	 */
	protected function _apiInstance() {
		$api_url = $this->param( 'api_url' );
		$api_key = $this->param( 'api_key' );

		return new Thrive_Dash_Api_LeadOutcome( $api_url, $api_key );
	}

	/**
	 * get all Subscriber Lists from this API service
	 *
	 * @return array|bool for error
	 */
	protected function _getLists() {
		try {
			$raw   = $this->getApi()->getLists();
			$lists = array();

			foreach ( $raw as $list ) {
				$lists [] = array(
					'id'   => $list['id'],
					'name' => $list['name']
				);
			}

			return $lists;

		} catch ( Thrive_Dash_Api_LeadOutcome_Exception $e ) {

			$this->_error = $e->getMessage();

			return false;

		} catch ( Exception $e ) {

			$this->_error = $e->getMessage();

			return false;
		}

	}

	/**
	 * get all Subscriber Forms from this API service
	 *
	 * @return array|bool for error
	 */
	protected function _getForms() {
		try {
			//$raw   = $this->getApi()->getForms();
			$forms = array();
/*
			$lists = $this->getLists();
			foreach ( $lists as $list ) {
				$forms[ $list['id'] ][0] = array(
					'id'   => 0,
					'name' => __( 'none', TVE_DASH_TRANSLATE_DOMAIN )
				);
			}

			foreach ( $raw as $form ) {
				foreach ( $form['lists'] as $list_id ) {
					if ( empty( $forms[ $list_id ] ) ) {
						$forms[ $list_id ] = array();
					}
					
					$forms[ $list_id ][ $form['id'] ] = array(
						'id'   => $form['id'],
						'name' => $form['name']
					);
				}
			}
*/
			return $forms;

		} catch ( Thrive_Dash_Api_LeadOutcome_Exception $e ) {

			$this->_error = $e->getMessage();

			return false;

		} catch ( Exception $e ) {

			$this->_error = $e->getMessage();

			return false;
		}

	}

	/**
	 * add a contact to a list
	 *
	 * @param mixed $list_identifier
	 * @param array $arguments
	 *
	 * @return mixed
	 */
	public function addSubscriber( $list_identifier, $arguments ) {
		/** @var Thrive_Dash_Api_LeadOutcome $api */
		$api = $this->getApi();

		list( $first_name, $last_name ) = $this->_getNameParts( $arguments['name'] );
		
		try {
			$api->addSubscriber(
				$list_identifier,
				$arguments['email'],
				$first_name,
				$last_name,
				empty( $arguments['phone'] ) ? '' : $arguments['phone'],
				empty( $arguments['leadoutcome_form'] ) ? 0 : $arguments['leadoutcome_form'],
				'',
				trim( $arguments['leadoutcome_tags'], ',' ) );

			return true;

		} catch ( Thrive_Dash_Api_LeadOutcome_Exception $e ) {
			return $e->getMessage();
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	} 	

	/**
	 * output any (possible) extra editor settings for this API
	 *
	 * @param array $params allow various different calls to this method
	 */
	public function renderExtraEditorSettings( $params = array() ) {
		$params['forms'] = $this->_getForms();
		if ( ! is_array( $params['forms'] ) ) {
			$params['forms'] = array();
		}

		$this->_directFormHtml( 'leadoutcome/forms-list', $params );
	}

	/**
	 * Return the connection email merge tag
	 * @return String
	 */
	public static function getEmailMergeTag() {
		return '%EMAIL%';
	}

}
