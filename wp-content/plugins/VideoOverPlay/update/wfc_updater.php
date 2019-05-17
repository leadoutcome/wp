<?php 
if(!class_exists("wfc_updater")):
class wfc_updater
{
    public $current_version;
	public $update_path = "http://ipn.wfcguard.com/update_checker2.php";
	//public $update_path = "http://ipn.wfcguard.com/update_checker_internal.php";
	public $plugin_slug;
	public $slug;
	protected $optionName = '';
	protected $item_name = '';
	public $license = '';
	protected $status = '';
	protected $api_key = 'JiYgJF9HRVRbJ3BhZ2UnX';
	protected $error_msg = "";
    
	function __construct($license,$current_version, $plugin_slug,$item_name)
    {
		$this->current_version = $current_version;
        $this->plugin_slug = $plugin_slug;
		
        list ($t1, $t2) = explode('/', $plugin_slug);
        $this->slug = str_replace('.php', '', $t2);
		
		$this->optionName = $this->slug;
		//die($this->slug);
        // define the alternative API for updating checking
        
		
		$this->item_name = $item_name;
		//$this->api_key = $api_key;

		$this->license = $license;
		//die($this->optionName.'st'.'a'.'tu'.'s');
		$this->status = get_option( $this->optionName.'st'.'a'.'tu'.'s', '' );
		
		//update notification will work only if plugis is activated with correct license key.
		if($this->status=="COMPLETED")
		{
			add_filter('pre_set_site_transient_update_plugins', array(&$this, 'check_update'));
			add_filter('plugins_api', array(&$this, 'check_info'), 10, 3);
			
			//prints wildfire concept's product information for wildfire concept's server query, data generated on init hook, repeated in each wfc's plugin, so this is why it must be printed after finishing all init, so the next action hook wp_loaded.
			add_action('wp_loaded', array(&$this, 'wp_loaded_action'));
			add_action('admin_notices', array(&$this, 'wfc_admin_notices'));
			add_action('wp_ajax_delete_wfc_acmin_notice', array(&$this, 'wfc_ajax_action'));
			
			
		}
		
		if(isset($_POST['wfc_api_key']) AND $_POST['wfc_api_key'] == $this->api_key )
		{
			switch($_POST['action'])
			{
				case "query_info":
					global $wfc_return_data,$wp_version;
					if(!isset($wfc_return_data))
						$wfc_return_data = array();
					$wfc_return_data["action"] = $_POST['action'];
					$wfc_return_data["status"] = "COMPLETED";
					$wfc_return_data["wp_version"] = $wp_version;
					$wfc_return_data[$this->slug]["product"] = $this->item_name;
					$wfc_return_data[$this->slug]["license"] = $this->license;
					$wfc_return_data[$this->slug]["version"] = $this->current_version;	
					break;
					
				case "admin_notice":
					$notice = "<div id='wfc_admin_notice' class='".$_POST['class']."'><span class='hideme' title='Hide this & Never show again'>Hide Me</span><p>".urldecode($_POST['admin_notice'])."</p></div>";
					set_transient("wfc_admin_notice",$notice,(int)$_POST['time']);
					global $wfc_return_data,$wp_version;
					if(!isset($wfc_return_data))
						$wfc_return_data = array();
					$wfc_return_data["action"] = $_POST['action'];
					$wfc_return_data["status"] = "COMPLETED";
					break;
			}
			
			
		}
		
	}
	
	/**
     * Add our self-hosted autoupdate plugin to the filter transient
     *
     * @param $transient
     * @return object $ transient
     */
    public function check_update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }
 
        // Get the remote version
        $remote_version = $this->getRemote_information();
		// If a newer version is available, add the update
		if (version_compare($this->current_version, $remote_version->new_version, '<')) {
            $obj = new stdClass();
            $obj->slug = $this->slug;
            $obj->new_version = $remote_version->new_version;
            $obj->url = $remote_version->url;
            $obj->package = $remote_version->download_link;
            $transient->response[$this->plugin_slug] = $obj;
        }
        //var_dump($transient);
        return $transient;
    }
 
    /**
     * Add our self-hosted description to the filter
     *
     * @param boolean $false
     * @param array $action
     * @param object $arg
     * @return bool|object
     */
    public function check_info($false, $action, $arg)
    {
		if ($arg->slug === $this->slug) {
            $information = $this->getRemote_information();
            return $information;
        }
        return $false;
    }
 
    public function getRemote_information()
    {
		global $wp_version;
        $request = wp_remote_post($this->update_path, array('body' => array('action' => 'info',
																			'license'=>$this->license,
																			'api_key'=>$this->api_key,
																			'slug'=>$this->slug,
																			'item'=>$this->item_name,
																			'item_version'=>$this->current_version,
																			'site'=>urlencode(home_url()),
																			'wp_version'=>$wp_version
																			)));
		//echo "<pre>";
		//print_r(unserialize($request['body']));
		//echo "</pre>";
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return unserialize($request['body']);
        }
        return false;
    }
	
	public function validate_license($key = '') {
		global $wp_version;
		//die('validate_lic');
		if($key != "")
			$this->license = $key;
		$response = wp_remote_post($this->update_path, array('body' => array(
																			'action' => 'license_check',
																			'license'=>$this->license,
																			'api_key'=>$this->api_key,
																			'slug'=>$this->slug,
																			'item'=>$this->item_name,
																			'item_version'=>$this->current_version,
																			'site'=>urlencode(home_url()),
																			'wp_version'=>$wp_version
																			)));
        //print_r($response['body']);
		if (is_wp_error($response)) {
            return array("status" => $response->get_error_message());
        }
        
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		if( $license_data->valid ) {
   		update_option( $this->optionName.'ke'.'y', $key );
	   	update_option( $this->optionName.'s'.'ta'.'t'.'us', $license_data->status );
		
		//recheck for license every 7 Days.
	   	$temp = set_transient( $this->optionName.'lastcheck', $key, 60*60*24*7 );
		$this->license = $key;
	   	$this->status = $license_data->status;

			return array("status"=> $this->status);
			// this license is still valid
		} else {

         delete_option( $this->optionName.'k'.'ey', '' );
         delete_option( $this->optionName.'st'.'a'.'tu'.'s', '' );
         delete_transient($this->optionName.'las'.'t'.'c'.'he'.'ck');
         $this->license = '';
         $this->status = '';
         return array("status" => "Invalid API Key");
			// this license is no longer valid
		}
	}

	public function is_license_valid() {
		return array("status" => $this->status);
   }

   public function clear_license() {
      delete_option( $this->optionName.'k'.'ey', '' );
      delete_option( $this->optionName.'st'.'a'.'tu'.'s', '' );
      delete_transient($this->optionName.'las'.'t'.'c'.'he'.'ck');
      $this->license = '';
      $this->status = '';

      return true;
   }

   public function re_check_license() {
	    if(false === get_transient($this->optionName.'las'.'t'.'c'.'he'.'ck') && !empty($this->license)) {
	     return $this->validate_license($this->license);
      }
	  return array("status" => $this->status);
   }
 
	//prints wildfire concept's product information for wildfire concept's server query
	public function wp_loaded_action()
	{
		if(isset($_POST['wfc_api_key']) AND $_POST['wfc_api_key'] == $this->api_key )
		{
			global $wfc_return_data;
			echo json_encode($wfc_return_data);
			die();
		}
	}
	
	public function wfc_admin_notices()
	{
		global $wfc_notice_status;
		if(!isset($wfc_notice_status))
		{
			$notice = get_transient("wfc_admin_notice");		
			//$notice = "<div class='updated'><p>Test notice</p></div>";		
			if($notice !== false)
				echo "
						<script>
						jQuery('document').ready(function(){
							jQuery('#wfc_admin_notice .hideme').click(function (){
								jQuery('#wfc_admin_notice').slideUp();
								
								var data = {
									'action': 'delete_wfc_acmin_notice',
									'key': 125693258
								};

								// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
								jQuery.post(ajaxurl, data);
								
								
							})
						});
						</script>
						<style>
							#wfc_admin_notice .hideme:hover
							{
								opacity:0.7;
							}
							#wfc_admin_notice .hideme
							{
								float:right;
								display:inline-block;
								cursor:pointer;
								margin:10px;
								text-decoration:underline;
							}
						</style>
					";
				echo $notice;
			$wfc_notice_status = true;
		}
		
	}
	
	public function wfc_ajax_action()
	{
		global $wfc_transition_deleted;
		if(!isset($wfc_transition_deleted))
		{
			delete_transient("wfc_admin_notice");
			$wfc_transition_deleted = "yes";
			die();
		}
	}
}
endif;
?>