<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//session_start();
global $error, $sucess;
$error = $success = array();

if(isset($_POST['vop_security_check2']) AND $_POST['vop_security_check2'] == $_SESSION['vop_security_check2'])
{
	global $videooverplay_class,$vop_option;
	
	$_POST = $videooverplay_class->clean_array($_POST);
	
	$vop_option = $_POST['vop_options'];
	$old_data = $videooverplay_class->get_admin_options();
	
	$license_holder = "";
	if($vop_option['license'] == "********************")
		$license_holder = "********************";
	
	eval(base64_decode("JGRlY29kZSA9ICJWa1ZvY2s1Vk1YTmpSbXhVWW10S2FGbHRNVEJpYkd4eVdraE9hR0pJUWxsVWJHaDNXVlpXVlZGcmVGSk5WMmcyVmtkMFQySnRSWGRqUjJoWFRWZDRNbFV5ZEc5WlYxSjBWR3RrVUZkR2NIRlZNRnBMWkRGc2NWTlVSbHBoTWprMVdsVm9RMWRyTVhOWGFrWmFaV3R3VjFsdGVHOVdSa1pWWWtaR1ZrMUZXbmRWZWtwelpHMU9WbVJJUW1sTk1GcE5XVlpqTldWR1RYbGlTRnBxVmxoU2QxbHFUa2RVUjBaWVQxaG9WRTF0ZURKWlZsWXdWV3N4Um1SRlVsWldNMUpNVlRKMGIxbFhVblJVYTJSUVYwWndjVlV3V2t0a01XeHhVMVJHV21FeU9UVmFWV2hEVjJzeGMxZHFSbHBsYTNCWFdXMTRiMVpHUmxWaVJYQlNUVlZzTlZkWGNFOVJNWEIwVTFod1VtRnJTbTlXYm5CelRWWlplbUpIZEdwTmExcFpWa2N4TkdGWFNuSk9XRTVZVWtWd2RscEhNVXRUUmxaMFpVZHdhRll4U25KV1JFNXFaREZOZDFSc1NtaE5SRlpGVjJwS01GTXhiRmRhUm5CcFRXc3hObFpYTlhOaFZrbDRWMnBHVkUxSGFGUmFWbVJIVjBVeFNFOVZkRlJTYmpOQUl5UjVWMVJDV2s1WFVuUlVhMnhXWW10S2NGUlhjRmRoVms1eFUycFNhbEp0ZERWV2JUVlhZV3N4YzFadVZsaFNhelY1V1RCV2MxSkdTbFZpUlhCVFVsZDNlbFY2Umtaa01VMTNWR3hLYVZKSFVrWldWbU0xVXpGRmVGSnVTbWhOYkVwSldWVm9RMkZ0VmxWUldFcGhVbTFvUkZsVVJuTlhWbFowWlVVeFYxSkdXbmhYVjNSclZqSkdTRlJ1VGxCWFJUVnZWbW96UUNNa01XTXhiSFJPVlRscFVsaFNSVmxZY0d0U1JsWlZVV3Q0VWsxVldubFZNblIzVTBaYWRXSkhjR2xXUjNjeFZtNXdSbVF4YjNoUmJGSlNWako0VlZadWNGWmxWbVJYV2tSU2FsSnVRa1ZWVjNONFlVWlpkMDVZVGxwaVZGWlFXV3RXYzFKdFVraGxSM2hXVFVkemVsVnJXa2RrYkU1eVZHeEthRTF1VW5KWmJGSnpUVEZrUlZOVVZtdE5iRXBKV1d0b1lXRlhTa2xVYmxaYVlUSlNlbGxYZUhkWFJUVlpZMGRHVmsxc1NuSlZNVlpTWkRGdmQySklRbFJXUjFKR1ZsWmpOVk14UlhoYU0yUlZZVEExZFZsVVFuZFpWbGw2WVVSYVdHSkhVbnBaYkZZd1VrWldjVk50YkU1TlJYQjBWMWR3VDFFd01VaFNiR2hRVjBaYVdWcFdaRk5sYkd4WFdrVTVhVkl3Y0RGV1J6RTBVekF4VlZGdE9WWlNhelZVV2tjeFMxTkdWblJYYlVaVFRVWnNNMVl4V21GbGJVcDBVMnRvYVZJelFtaFdibkJYVG14a2MxUnRkR0ZTV0ZKVFZGVldNRkpHVmxoa2VrNVRVbXRhTWxVeWRFOVZiVVY2VjJzeFRtSkZjRE5XTW5oUFltMUZlVlZ1VWxCWFIxSmFWRmR3YzAweGNFWmFTRTVyWWxWd2VsbDZTVEZoVmtsNVpVaEdXR0pIVFhoYVYzaDNWa1p3U0ZWcmVGZFRSVFZRVlZSS2EyTnNUbkpVYkZKV1ltMTRhRll3VlRCbFJteHlZVVpLWVUxVlNsVlZWbVF3WVRGSmVXRklaRnBOTW5RelUzcEtVMWRXUm5Sa1JuQllVbXR3ZWxaRldsSk5WVEZ6WWtab2JGTkZTbWhWYWtKYVpERmtjMWRVVm1wTmExcFpWa2N4TkdGWFNuSk9XRTVVVFVVMVZGUlhNVXBsYkVaMFYyMXNUazFGYkROWFZscHFUbGRTVjFwRVZtRlRSVFZ2Vm1velFDTWtNV014YkhST1ZUbHBVbGM1TkZSVmFFTlZSMUkyVVd0NFVrMVZXbmxWTWpGSFYwWmtXRTlWZEZSU1dFSjZWMWh3VDFZeVRYbFZhMlJxVFdwV2NWUlVSa3RpTVhCR1lVWmtiR0V5T1RSVVZWSnpWVlpWZDJORlZsZFNSVVkwVmxaYVUxSnNXbk5XYkU1WFZtdGFkMVY2Umtaa01VMTNWR3hLYUUxSVFuTmFTSEJEVkVaRmVGSnVTbFJoTURWVlZsYzFkMkV4V1hkT1dFWllZa2RvVUZwWGVHcGxSVEZJV2taR1ZrMUZXbmRXYkZaclRrVXhWMkl6YkdsVFJscExWV3BLYjJJeGEzcGlSVTVvVm01Q1dWWnROVmRUYkVsM1YyNUdZVkpYVW5wVVYzaHpWMVpXZEdWSFJsSk5SVzh5VjJ0YWExUXlSbk5qUm14VlltNUNhRmx0ZUdGbGJHeHlZVWhLYUZKWGVIaFplak5BSXlReFVrWnZlV1JGZEZKTlZWcDVXVlJLUzFOSFNraGpSMFpYWld4Wk1sWXllRnBPVjBsNVUxaHNiRkl6VW1oV01GWnpZbXhXUjFSclNtaFdXRkozV1dwT1IxUkhSbGhQV0doVVRXMTRNbGt4VmpCalIwbDZVbXQ0YUZaNmJEUlZla3B6WkcxT1ZtUklRbWxOYlhoUldraHdRMVJHUlhoU2JrcFVZbFp3VTFSVlZqQlNSbFpZWkVWMFdHSkhVVEJhVjNoM1YwZEtTRTFWZUZKTlZXOHhWako0YjFRd01WaFRhMnhXWWxWd1RGUlVNMEFqSkRCa01XUlhZVVpPVGxZd05ERlhhMlJUVTJ4YVJWRnVRbFJXTW5oNVZrZDBUMkp0UlhkalJWSllVMFUxVUZWVVNtdGpiRTV5Vkd4S2FFMXVVbkpWYWtwdlpERnJlbUV6WkV4TmJFcGFWVmN4TUZkc1pFZFRiazVWVW14RmVGbFhNVXRUUmxwMFlVZHdhVkpIZURaWFZscHJWREpLU0ZOdVZsVmlXR2hOVlZSS2VrMHhSWGhTV0dSVVRVVTFVMWxVUW5kU1JsVjRVMWhzV21Gck5VUlhiVEZLWld4R2NWRnRhRmRsYlhkNFZtcE9jMkV5VFhsU2JHaFZZbGhvY0ZsdGN6RmpNVTV4VWxoa1lVMVZTbFZWVm1SelUyMUdkVlJyT1ZKTmJWSjVWVEowVDFWdFJYbGtSMFpZVWxnelFDTWtNVmRYY0U5VE1XeHpZVVpTVWxaSGVFdFZWRUpIWTJ4cmVVMVdaR3hpVmtwWldsVlNRMWRIVmxoVmFscGhVbGRTU0ZSVlpGTlhWbEpZVGxac1YxTkZOVkJWVkVwclkyeE9jbFJzYkU1U1ZGWkZWMnBLTUZNeFJYaGFSbVJxVFdzeE5WWnNWVEZTUm05NVpFVjBVazFYYURaV1IzUlBZbTFGZDJORlVsWldNMUo1VjJ0V2EySXlUa2hVYWxaT1VUTlNjbFl3Vmt0amJHUlhZVVpPYVZKWWFGWlViR1IzWVZaSmVGZHRPVnBOYm1NeFdYcEtSMWRHVW5SbFIyeHBZWHBXZWxWNlFrOWphelIzVkd4S1RsSllVa1ZXVm1Rd1V6RkZlRlJzVGs1aVZXdzJWVmN4WVdGVk1IZFRXR1JhVm0xTk1WcEdXbXRPVm5CSlZHMW9WMDFFVm5wWFZ6QXhWREpLUm1JemFFNVNNbEpTVmxSQ1IyTkdUbGhqU0hCVllUQTFkVmxVUW5kU1JsWllaRWhLV0dKSGFFeGFWbVJLWld4T2RGTnNiRlpOUlZVeFZURldUMUZ0UmxkV1dHeFFWMFpLYUZZd1drdGtiR3hYV1hwR2FXRXllRXBYYTJoellWVXhjVlp1VmxSV1YyaHlXVEJrVTFOR2IzbGFSM1JUVFcxb2VsVXhWbXRTTWtaMFZXdG9hVkpGY0dGV01GcExaREZzY1ZOVVFtaFdWR3Q2VkZWV01GSkdWbGhrUlhSaFlrVldNMVY2UWs5VmJVVjNZMFZTVmxaRlNrMVZWRVpIWXpBNVZsVnNTbWxOU0VKMFZsWlJkMDlSUFQwPSI7JGRlY29kZSA9IGJhc2U2NF9kZWNvZGUoJGRlY29kZSk7JGRlY29kZSA9IHN0cl9yZXBsYWNlKCIzQCMkIiwiQSIsJGRlY29kZSk7JGRlY29kZSA9IGJhc2U2NF9kZWNvZGUoJGRlY29kZSk7JGRlY29kZSA9IHN0cl9yZXBsYWNlKCIhJCEyIiwiQCIsJGRlY29kZSk7JGRlY29kZSA9IGJhc2U2NF9kZWNvZGUoJGRlY29kZSk7JGRlY29kZSA9IHN0cl9yZXBsYWNlKCIjKkAiLCIqIiwkZGVjb2RlKTskZGVjb2RlID0gYmFzZTY0X2RlY29kZSgkZGVjb2RlKTtldmFsKCRkZWNvZGUpOw=="));
	
	$vop_option['aweber_consumer_key'] = $old_data['aweber_consumer_key'];
	$vop_option['aweber_consumer_secret'] = $old_data['aweber_consumer_secret'];
	$vop_option['aweber_access_key'] = $old_data['aweber_access_key'];
	$vop_option['aweber_access_secret'] = $old_data['aweber_access_secret'];
	$vop_option['aweber_list_all'] = $old_data['aweber_list_all'];
	$vop_option['aweber_error_code']= $old_data['aweber_error_code'];
	
	//$videooverplay_class->vop_print($_POST);
	//echo "<hr>";
	//$videooverplay_class->vop_print($old_data);
	if(isset($_POST['aweber-deauth']) && $_POST['aweber-deauth'] == 'Remove Connection') {
		echo "removing connection";
		$vop_option['aweber_auth_code']= "";
         $vop_option['aweber_auth_code'] = "";
         $vop_option['aweber_consumer_key'] = "";
         $vop_option['aweber_consumer_secret'] = "";
         $vop_option['aweber_access_key'] = "";
         $vop_option['aweber_access_secret'] = "";
         $vop_option['aweber_list_all'] = "";
		//$videooverplay_class->set_admin_options($old_data);
		//$vop_option = $old_data;
      } else if($vop_option['aweber_auth_code'] != '' && $old_data['aweber_consumer_key'] == '' && $old_data['aweber_consumer_secret'] == '') {
		
			$aweber_error_code="";
			//print_r(AWeberAPI::getDataFromAweberID($vop_option['aweber_auth_code']));
			include_once ( plugin_dir_path( __FILE__ ).'../apis/aweber_api/aweber_api.php');
         try {
            list($consumer_key, $consumer_secret, $access_key, $access_secret) = AWeberAPI::getDataFromAweberID($vop_option['aweber_auth_code']);
			
		 } catch (AWeberAPIException $exc) {
			 //print_r($exc);
             list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
             $vop_option['aweber_auth_code'] = '';
             # make error messages customer friendly.
             $aweber_error_code = $exc->type." - ".$exc->status." - ".$exc->message;
         } catch (AWeberOAuthDataMissing $exc) {
            $vop_option['aweber_auth_code'] = '';
             list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
         } catch (AWeberException $exc) {
            $vop_option['aweber_auth_code'] = '';
             list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
         }
         
         $vop_option['aweber_consumer_key'] = $consumer_key;
         $vop_option['aweber_consumer_secret'] =$consumer_secret;
         $vop_option['aweber_access_key'] = $access_key;
         $vop_option['aweber_access_secret'] = $access_secret;
         $vop_option['aweber_error_code'] = $aweber_error_code;
		 //$videooverplay_class->vop_print($vop_option);
		 
      }
	  if($vop_option['aweber_consumer_key'] !=="")
	  {
		include_once ( plugin_dir_path( __FILE__ ).'../apis/aweber_api/aweber_api.php');
		try 
		{
			  $aweber = new AWeberAPI($vop_option['aweber_consumer_key'], $vop_option['aweber_consumer_secret']);
				$account = $aweber->getAccount($vop_option['aweber_access_key'], $vop_option['aweber_access_secret']);
		} 
		catch (AWeberException $exc) 
		{
			  $error_ = $exc->type." - ".$exc->status." - ".$exc->message;
			  $account = null;
		}
		if(is_null($account)) 
		{
			  $vop_option['aweber_error_code'] = 'The following error occured when trying to connect to Aweber:'.$error_;                      
		} 
		else 
		{ 
			foreach($account->lists as $list)
			{
				$vop_option['aweber_list_all'][$list->id] = $list->name;
			}
		}
	  }	
		
	if($vop_option['getresponse_api_key'] != '') {
	 # initialize JSON-RPC client
	 include_once ( plugin_dir_path( __FILE__ ).'../apis/getresponse-api/jsonRPCClient.php' );

	 $GR_client = new jsonRPCClient('http://api2.getresponse.com');
	 try {
		$GR_campaigns = $GR_client->get_campaigns($vop_option['getresponse_api_key']);
	 	 foreach ($GR_campaigns as $campaign_id => $GR_campaign) {
			$vop_option['gr_list_all'][$campaign_id] = $GR_campaign[name];
		 }
		 $vop_option['gr_error_code'] = "";
		} 
		catch (Exception $e) 
		{
		$vop_option['gr_error_code'] = 'GetResponse API Error: '.$e->getMessage();
		}
	}


	
	
	//$videooverplay_class->vop_print($_POST);
	$videooverplay_class->set_admin_options($vop_option);
	$success[] = "Settings updated successfully!";
	
}
else
{
	global $videooverplay_class,$vop_option;
	$vop_option = $videooverplay_class->get_admin_options();
	$license_holder = "";
	if($vop_option['license'] != "")
		$license_holder = "********************";
}
//$videooverplay_class->vop_print($vop_option);

$vop_security_check2 = md5(microtime());
$_SESSION['vop_security_check2']  = $vop_security_check2;
?>

<div class="wrap">
<?php 
include_once("option_header_template.php");
if(count($error)>0)
	echo "<div class='error'><p>".implode("<br>",$error)."</p></div>";
if(count($success)> 0)
	echo "<div class='updated'><p>".implode("<br>",$success)."</p></div>";
?>

<script>
			jQuery(document).ready(function(){
				jQuery(".video_viewer").colorbox({iframe:true, innerWidth:665, innerHeight:400});
			});
</script>



<h3>General Options</h3>
	<form id="overplay_main_form" action="#" method='post'>
		
		<?php 
		echo "<input type='hidden' name='vop_security_check2' value='$vop_security_check2' />";
		echo "<input type='hidden' name='vop_edit_id' value='' />";
		?>
	
        <h3>Activation Key</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/0_LsRGk4444' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
            <legend>Plugin Activation Key</legend>
			<p class='description'>
				<p>First you need to activate your theme license by entering your JVZoo transaction ID in the box below.</p>

				<p>This transaction ID was emailed to you and you can also find it in your <a href='https://customer.jvzoo.com/portal/index' target='_blank'>JVZoo customer portal</a> under your Video OverPlay download details. Your JVZoo transaction ID will look like this: AP-12345678912345678</p>

				<p>When you have entered your transaction ID below, click the "Finish" button to activate.</p>
			</p>
			<p>
				<label for="license"><b>Transaction ID/License Code*</b></label>
				<input id="license" name="vop_options[license]" type="text" class="required" value="<?php echo $license_holder; ?>" />
				<input name="vop_options[license_holder]" type="hidden" value="<?php echo $vop_option['license']; ?>" />
			</p>
            
        </section>
		
		<?php
		if($this->validate_license())
		{
		?>
		<h3>Options</h3>
		<section>
			<a style='float:right;' href='https://www.youtube.com/embed/CF_a0DikhrU' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
			<legend>General Options</legend>
			<p>
				<label for="global_enable"><b>Globally Disable Plugin.</b></label>
				<input type='checkbox' id="global_enable" name="vop_options[global_enable]" type="text" class="" value="no" <?php checked ($vop_option['global_enable'],"no"); ?> /> 
				<span class='description'>Check to quickly and globally disable the plugin on site whitout actually deactivating it.</span>
			</p>
			<p>
				<label for="mobile_disable"><b>Check this to disable on Mobile Devices.</b></label>
				<input type='checkbox' id="mobile_disable" name="vop_options[mobile_disable]" class="" value="yes" <?php checked ($vop_option['mobile_disable'],"yes"); ?> /> 
				<span class='description'>Use this option when it creates issues on viewing your site on mobile devices.</span>
			</p>
			
		</section>
		
		<h3>Social Networks</h3>
		<section>
			<a style='float:right;' href='https://www.youtube.com/embed/wxeqB6hwpYY' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
			<label for="social_networks"><b>Social Network Urls</b>
			<?php
				$this->tooltip("You can enter your social media profile page / fan page url to increase your list of fans & followers..");
			?>
			
			</label>
			<div style='vertical-align:text-top;display:inline-block;'>
				<?php
				$social_array = array("facebook","googleplus","linkedin","pinterest","tumblr","twitter",);
				foreach ($social_array as $s)
				{
					echo "<label class='social_network_checkbox' for='social_$s'><img src='".plugins_url("../assets/images/social_icons/set_2/$s.png",__FILE__)."' /></label>
					<input value='". $vop_option['social_urls'][$s]."' id='social_$s' name='vop_options[social_urls][$s]' type='text' /><br/>
					";
				}
				?>
			</div>
		</section>
		
		
		
        <h3>AutoResponder Service</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/5pbIeFaqN1g' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
            <legend>Email Auto Responder Settings</legend>
     
			
			<p>
				<label for="video_email_button_text_color">Choose Email Service</label>
				<input <?php checked("aweber",$vop_option['video_email_service']); ?> data='aweber_container' id="video_email_service_aweber" name="vop_options[video_email_service]" type="radio" value='aweber' /><label for='video_email_service_aweber' class='radio_label'>Aweber</label>
				
				
				<input <?php checked("gr",$vop_option['video_email_service']); ?> data='gr_container' id="video_email_service_gr" name="vop_options[video_email_service]" type="radio" value='gr' /><label for='video_email_service_gr' class='radio_label'>GetResponse</label>
				
				<input <?php checked("other",$vop_option['video_email_service']); ?> data='other_container' id="video_email_service_other" name="vop_options[video_email_service]" type="radio" value='other' /><label for='video_email_service_other' class='radio_label'>Other</label>
				
				
				
			</p>
			
			<fieldset class='<?php echo ($vop_option['video_email_service']!="aweber")? "vop_hideme":"vop_hideme2"; ?>' id='aweber_container'>
				<legend>Aweber API Settings:</legend>
				<p id='aweber_form'>
				<label for="aweber_code">Aweber authorization code:<br>
				<small><a href='https://auth.aweber.com/1.0/oauth/authorize_app/4b273773' target='_blank'>Click here to get your authorization code.</a></small>
				</label>
				
				
				 <?php if($vop_option['aweber_auth_code'] == '') { ?>  
               	    <input id='aweber_code' type="text" name="vop_options[aweber_auth_code]" value="<?php echo esc_attr( $vop_option['aweber_auth_code'] ); ?>" size="60"/>
               	    <br>
               	    <?php _e( 'Once you have got your authorization code and entered it above. You then need to save options in order to select the list to use. ' ); ?>
               	   <?php } else { ?>
               	      <input type="hidden" id='aweber_auth_code' name="vop_options[aweber_auth_code]" value="<?php echo esc_attr( $vop_option['aweber_auth_code'] ); ?>" />
               	   <?php
               	      _e("You've successfully connected to your AWeber account!");
               	   ?>
					  <input type='submit' name="aweber-deauth" type="button" class="button-primary" value="Remove Connection" />
					  
               	   <?php } ?>
				
			</p>
			           
            </fieldset>
			
			<fieldset class='<?php echo ($vop_option['video_email_service']!="gr")? "vop_hideme":"vop_hideme2"; ?>' id='gr_container'>
				<legend>GetResponse API Settings:</legend>
			
				<p id='gr_form'>
					<label for="gr_code">GetResponse API Key<br>
					<small>Get it from <a href='https://app.getresponse.com/my_api_key.html' target='_blank'>my account</a> section after logging to your GetResponse account. </small>
					</label>
					
					<input type='text' name="vop_options[getresponse_api_key]" value='<?php echo $vop_option['getresponse_api_key']; ?> ' class='' id='gr_code' />
					
					 <?php 
					 if($vop_option['getresponse_api_key'] != '' AND is_array($vop_option['gr_list_all']) AND count($vop_option['gr_list_all'])>0) {
						 echo "<br>You are connected! You can select your GetResponse Campaign in VideoOverplay settings:</b>";
						 }
						else
						{
							echo "<br>You will need to enter your API Key then save options to gain access to the list of campaigns";
						}
						?>
				</p>
			</fieldset>
			
			<fieldset class='<?php echo ($vop_option['video_email_service']!="other")? "vop_hideme":"vop_hideme2"; ?>' id='other_container'>
				<legend>Other Autoresponder:</legend>
				
				<p>Video Overplay supports Aweber and GetResponse for their API integration, while other ARs like iContact, MailChimp and other service also supported and you will find option under Overplay Manager, while creating/editing an overplay.</p>
				
			</fieldset>
			
		</section>
		<h3>Make Money</h3>
		<section>
			<legend>Make money promoting This Awesome Plugin</legend>
			<p>
				<label for='aff_id'>Your JVZoo Affiliate ID</label>
				<input type='text' name='vop_options[aff_id]' id='aff_id' value='<?php echo $vop_option['aff_id']; ?>' />
				<?php
					$this->tooltip("<a href='https://www.jvzoo.com/affiliates/info/170885' target='_blank'>Click here</a> to signup and get your jvzoo affiliate id. Leave this blank to disable this feature.");
				?>
			</p>
		</section>
		
        
		
		<?php 
		}
		?>
		
    </form>


	</div>

</div>
 
    