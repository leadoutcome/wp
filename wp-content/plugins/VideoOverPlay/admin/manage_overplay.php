<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$vop_edit_id = 0;
$wizard_status = "Create New Overplay";

$error = $success = array();

//include_once ( plugin_dir_path( __FILE__ ).'../apis/getresponse-api/jsonRPCClient.php' );
//include_once ( plugin_dir_path( __FILE__ ).'../apis/aweber_api/aweber_api.php');
include_once ( plugin_dir_path( __FILE__ ).'../apis/HtmlFormParser.php');


if(isset($_POST['vop_security_check']) AND $_POST['vop_security_check'] == $_SESSION['vop_security_check'])
{
	global $error, $sucess,$videooverplay_class,$vop_option, $wpdb;
	
	$_POST = $videooverplay_class->clean_array($_POST);
	
	$error = $success = array();
	
	//$videooverplay_class->vop_print($_POST);
	
	if(isset($_POST['vop_id']) AND $_POST['action'] == 'Delete')
	{

		//delete overplay
		$table = $wpdb->prefix . "videooverplay";	
		$where = array("id"=>$_POST['vop_id']);
		
		if($wpdb->delete( $table, $where)) 
			$success[] = "Deleted!"; 
		else
			$error[] = "Can not delete: Kindly try again later!"; 
		
		$overplay_option = $this->load_defaults("overplay_option");
	}
	elseif(isset($_POST['vop_id']) AND $_POST['action'] == 'Edit')
	{
		//edit overplay
		$table = $wpdb->prefix . "videooverplay";	
		$where = array("id"=>$_POST['vop_id']);
		
		$vop_edit_id = $_POST['vop_id'];
		
		//$success[] = "You are editing..."; 
		
		$overplay_option = (array)json_decode($wpdb->get_var("SELECT options from $table WHERE id =  ".$_POST['vop_id']));
		
		$wizard_status = "Edit <b>\"".$overplay_option['name']."\"</b> Overplay";
		
		//$videooverplay_class->vop_print($overplay_option);
	}
	elseif(isset($_POST['vop_id']) AND $_POST['action'] == 'Copy')
	{
		//edit overplay
		$table = $wpdb->prefix . "videooverplay";	
		$where = array("id"=>$_POST['vop_id']);
		
		$vop_edit_id = "";
		
		$success[] = "You are editing..."; 
		
		$overplay_option = (array)json_decode($wpdb->get_var("SELECT options from $table WHERE id =  ".$_POST['vop_id']));
		
		$wizard_status = "Create new with settings copied from <b>\"".$overplay_option['name']."\"</b>";
		$overplay_option['name'] .=" - Copy";
		
		
		//$videooverplay_class->vop_print($overplay_option);
	}
	elseif(isset($_POST['vop_edit_id']) AND $_POST['action'] = 'Update')
	{
		//process data before saving into database.
		$_POST['vop_options']['ar_form'] = addslashes(stripslashes($_POST['vop_options']['ar_form']));
		$_POST['vop_options']['ar_form1'] = addslashes(stripslashes($_POST['vop_options']['ar_form1'])); 
		if($_POST['vop_options']['video_email_service']!='mc')
			$_POST['vop_options']['ar_form'] = $_POST['vop_options']['ar_form1'];
		
		
		
		if($_POST['vop_options']['video_email_service'] == 'i' OR $_POST['vop_options']['video_email_service'] == 'mc' || $_POST['vop_options']['video_email_service'] OR 'other') 
		{
			
			$new_ar = array();
			$new_ar['error'] = '';
         
			 if(($_POST['vop_options']['video_email_service'] == 'mc') && $_POST['vop_options']['ar_formurl'] != "") 
			 {
				$response = wp_remote_get(urldecode($_POST['vop_options']['ar_formurl']));
				if( is_wp_error( $response ) ) 
				   $new_ar['error'] = $response->get_error_message();
				
				$parser = new VOP_HtmlFormParser( urldecode($response['body']) );
			 }
			 else 
			 {
				$parser = new VOP_HtmlFormParser( urldecode(stripslashes($_POST['vop_options']['ar_form'])) );
				//$videooverplay_class->vop_print($_POST['vop_options']['ar_form']);
				//echo htmlentities(print_r($_POST['vop_options']['ar_form'],true));
				//$this->vop_print($parser);
				//$videooverplay_class->vop_print($result);
			 }
			$result = $parser->parseForms();
			//$this->vop_print($result);
			$result = $result[0];
			if($_POST['vop_options']['video_email_service'] == 'i') 
			{   	
				$new_ar['name'] = 'icontact';
				$new_ar['action'] = $result['form_data']['action'];
				foreach ($result['form_elemets'] as $key => $value) {
				   if($key == 'fields_fname') $new_ar['form_data'][$key] = '%%FNAME%%';
				   else if($key == 'fields_lname') $new_ar['form_data'][$key] = '%%LNAME%%';
				   else if($key == 'fields_email') $new_ar['form_data'][$key] = '%%EMAIL%%';
				   else $new_ar['form_data'][$key] = $value['value'];
				}
				foreach ($result['buttons'] as $key => $value) {
				   if($value['type'] == 'submit') $new_ar['form_data'][$value['type']] = $value['value'];
				}	
			}
			else if($_POST['vop_options']['video_email_service'] == 'mc') 
			{   	
				$new_ar['name'] = 'mailchimp';
				$new_ar['action'] = $result['form_data']['action'];
				foreach ($result['form_elemets'] as $key => $value) {
				   if($key == 'EMAIL')	$new_ar['form_data'][$key] = '%%EMAIL%%';
				   else if($key == 'MERGE0') $new_ar['form_data'][$key] = '%%EMAIL%%';
				   else if($key == 'MERGE1') $new_ar['form_data'][$key] = '%%FNAME%%';
				   else if($key == 'MERGE2') $new_ar['form_data'][$key] = '%%LNAME%%';
				   else $new_ar['form_data'][$key] = $value['value'];
				}
				foreach ($result['buttons'] as $key => $value) {
				   if($value['type'] == 'submit') $new_ar['form_data'][$value['type']] = $value['value'];
				}	
			}
			else if($_POST['vop_options']['video_email_service'] == 'other' AND is_array($result['form_elemets']) AND is_array($result['buttons'])) 
			{   	
				//die("other");
				$new_ar['name'] = 'otherar';
				$new_ar['action'] = $result['form_data']['action'];
				foreach ($result['form_elemets'] as $key => $value) {
				  if($key == $_POST['vop_options']['ar_formfldemail']) $new_ar['form_data'][$key] = '%%EMAIL%%';
				  else if($key == $_POST['vop_options']['ar_formfldname']) $new_ar['form_data'][$key] = '%%NAME%%';
				  else $new_ar['form_data'][$key] = $value['value'];
				}
				foreach ($result['buttons'] as $key => $value) {
				   if($value['type'] == 'submit') $new_ar['form_data'][$value['type']] = $value['value'];
				}	
			}
			
		}
		
		$_POST['vop_options']['new_ar'] = $new_ar;
		//$this->vop_print($new_ar);
		//die();
		
		$table = $wpdb->prefix . "videooverplay";	
		
		$data =  array(
					"name"=>$_POST['vop_options']['name'],
					"video"=> stripslashes($videooverplay_class->get_youtube_id($_POST['vop_options']['video'])),	
					"options"=>json_encode($_POST['vop_options'])
				);
				
		
		
		if($_POST['vop_edit_id']==0)
		{
			if($wpdb->insert( $table, $data))
				$success[] = "OverPlay saved successfully!"; 
			else
				$error[] = "Error updating overplay, kindly try again later!";
		}
		else
		{
			$where = array("id"=>$_POST['vop_edit_id']);		
			//$wpdb->show_errors();
			if($wpdb->update( $table, $data,$where) !== false)
				$success[] = "OverPlay saved successfully!"; 
			else
				$error[] = "Error updating overplay, kindly try again later!";
			
			//$wpdb->print_error();
			//die();
			//$vop_edit_id = $_POST['vop_edit_id'];
			//$overplay_option = (array)$_POST['vop_options'];
		}	
		
		$overplay_option = $this->load_defaults("overplay_option");
		//die('test');
	}
	
	
}
else
{
	global $videooverplay_class,$vop_option;
	//$vop_option = $videooverplay_class->get_admin_options();
	$overplay_option = $videooverplay_class->load_defaults("overplay_option");
}

$vop_option = $this->options;

$vop_security_check = md5(microtime());
$_SESSION['vop_security_check']  = $vop_security_check;



?>
<script>
			jQuery(document).ready(function(){
				jQuery(".video_viewer").colorbox({iframe:true, innerWidth:665, innerHeight:400});
			});
</script>
<div class="wrap">
<?php 

include_once("option_header_template.php");

if(count($error)>0)
	echo "<div class='error'><p>".implode("<br>",$error)."</p></div>";
if(count($success)> 0)
	echo "<div class='updated'><p>".implode("<br>",$success)."</p></div>";
?>
<h3>Overplay Manager</h3>
	<form id="overplay_main_form" action="#" method='post'>
		
		<?php 
		echo "<input type='hidden' name='vop_security_check' value='$vop_security_check' />";
		echo "<input type='hidden' name='vop_edit_id' value='$vop_edit_id' />";
		echo "<input type='hidden' name='action' value='Update' />";
		?>
	
        <h3>Start</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/zVnEbpnmEv0' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
            <legend><?php echo $wizard_status; ?></legend>
			<p>
				<label for="name">Name your OverPlay *</label>
				
				<input id="name" class='required' name="vop_options[name]" type="text" value="<?php echo $overplay_option['name']; ?>"  />
			</p>
		</section>
     
        <h3>Video</h3>
        <section>
			<legend>Video Configuration</legend>
			<p>
				<label for="vop_video">Video ID/URL *</label>
				<?php
				if(isset($overplay_option['video']) AND $overplay_option['video']!="")
				{
					$ytid = $this->get_youtube_id($overplay_option['video']);
					if(strlen($ytid)==11)
						echo "<img style='float:right;' src='http://img.youtube.com/vi/".$ytid."/default.jpg'>";
				}
				
				?>
				<input value="<?php echo $overplay_option['video']; ?>"  id="vop_video" name="vop_options[video]" type="text" class='required' />
				<?php $this->tooltip("YouTube video URL, OR Video ID Only."); ?>
			</p>
			
			<p>
				<label for="vop_video_width">Video Size</label>
				<input  style='width:70px;' value="<?php echo $overplay_option['vop_video_width']; ?>"  id="vop_video_width" name="vop_options[vop_video_width]" type="number" />px (Width) &nbsp;  &nbsp;  &nbsp;  &nbsp; X &nbsp;  &nbsp;  &nbsp;  &nbsp; 
				<input  style='width:70px;' value="<?php echo $overplay_option['vop_video_height']; ?>"  id="vop_video_height" name="vop_options[vop_video_height]" type="number" />px (Height)
			</p>
			
			
			
			<p>
				<label for="vop_autoplay">AutoPlay Video</label>
				<input <?php checked($overplay_option['vop_autoplay'],"yes"); ?> id="vop_autoplay" name="vop_options[vop_autoplay]" type="checkbox" value="yes" />
				<?php $this->tooltip("Check this to autoplay video on load."); ?>
				
			</p>
			
			<p>
				<label for="vop_autoplay_time">Autoplay Seconds</label>
				<input value="<?php echo $overplay_option['vop_autoplay_time']; ?>"  id="vop_autoplay_time" name="vop_options[vop_autoplay_time]" type="number" />
				<?php $this->tooltip("Number of seconds to start autoplay"); ?>
			</p>
			
			
			<p>
				<label for="video_play_img">Video Play Image</label>
				<input  value="<?php echo $overplay_option['video_play_img']; ?>"  id="video_play_img" name="vop_options[video_play_img]" class='image_upload' type="text" />
				<button type='button' class="vop_media_buttons button">Upload/Select</button>
				
			</p>
			<p>
				<label for="video_end_img">Video End Image</label>
				<input value="<?php echo $overplay_option['video_end_img']; ?>" id="video_end_img" name="vop_options[video_end_img]" type="text" class='image_upload' />
				<button type='button' class="vop_media_buttons button">Upload/Select</button>
				
			</p>
			<p>
				<label for="video_end_url">Video End URL</label>
				<input value="<?php echo $overplay_option['video_end_url']; ?>" id="video_end_url" name="vop_options[video_end_url]" type="text"  />
			</p>
			<!--
			<p>
				<label for="video_color_scheme">Color Scheme</label>
				<select id="video_color_scheme" name="vop_options[video_color_scheme]">
					<option <?php selected($overplay_option['video_color_scheme'],"0");  ?> value='0'>None</option>
					<option <?php selected($overplay_option['video_color_scheme'],"black");  ?> value='black'>Black</option>
					<option <?php selected($overplay_option['video_color_scheme'],"blue");  ?> value='blue'>Blue</option>
					<option <?php selected($overplay_option['video_color_scheme'],"red");  ?> value='red'>Red</option>
					<option <?php selected($overplay_option['video_color_scheme'],"green");  ?> value='green'>Green</option>
				</select>
			</p>-->
			<p>
				<label for="video_color_scheme">Color Scheme</label>
				<input type='text' class='color-input' id="video_color_scheme" name="vop_options[video_color_scheme]" value="<?php echo $overplay_option['video_color_scheme']; ?>">
				<input type='button' class='pickcolor button-secondary' value='Select Color' />
				<span style='z-index: 100; background:#eee; border:1px solid #ccc;display:inline;'></span>
			</p>
			
			<legend>Overplay Settings</legend>
			
			<p>
				<label for='enable_email_optin'>Enable Email OptIn</label>
				<input step_index='step_email' class='step_selector' type='checkbox' name='vop_options[enable_email_optin]' value='yes' <?php checked($overplay_option['enable_email_optin'],'yes'); ?> id='enable_email_optin'>
			</p>
			<p>
				<label for='enable_social'>Enable Social Sharing</label>
				<input step_index='step_social' class='step_selector' type='checkbox' name='vop_options[enable_social]' value='yes' <?php checked($overplay_option['enable_social'],'yes'); ?> id='enable_social'>
			</p>
			<p>
				<label for='enable_funnel'>Enable Funnel</label>
				<input step_index='step_funnel' class='step_selector' type='checkbox' name='vop_options[enable_funnel]' value='yes' <?php checked($overplay_option['enable_funnel'],'yes'); ?> id='enable_funnel'>
			</p>
			<p>
				<label for='enable_cta'>Enable Call to Action</label>
				<input step_index='step_cta' class='step_selector' type='checkbox' name='vop_options[enable_cta]' value='yes' <?php checked($overplay_option['enable_cta'],'yes'); ?> id='enable_cta'>
			</p>
			<p>
				<label for='enable_ad_banner'>Enable Ad Banner</label>
				<input step_index='step_ad' class='step_selector' type='checkbox' name='vop_options[enable_ad_banner]' value='yes' <?php checked($overplay_option['enable_ad_banner'],'yes'); ?> id='enable_ad_banner'>
			</p>
			<p>
				<label for='enable_html_banner'>Enable HTML Ad</label>
				<input step_index='step_html' class='step_selector' type='checkbox' name='vop_options[enable_html_banner]' value='yes' <?php checked($overplay_option['enable_html_banner'],'yes'); ?> id='enable_html_banner'>
			</p>
			<p>
				<label for='enable_advanced_code'>Enable Advanced Code Insertion</label>
				<input step_index='step_advanced' class='step_selector' type='checkbox' name='vop_options[enable_advanced_code]' value='yes' <?php checked($overplay_option['enable_advanced_code'],'yes'); ?> id='enable_advanced_code'>
			</p>
			
			
			
        </section>
		
        <h3>SEO</h3>
        <section>
            <legend>Video SEO Settings</legend>
			<p>
				<label for="vop_seo_title">SEO Title</label>
				<input value="<?php echo $overplay_option['vop_seo_title']; ?>"  id="vop_seo_title" name="vop_options[vop_seo_title]" type="text" />
			</p>
			<p>
				<label for="vop_seo_desc">SEO Description</label>
				<input  value="<?php echo $overplay_option['vop_seo_desc']; ?>"  id="vop_seo_desc" name="vop_options[vop_seo_desc]" type="text" />
			</p>
			
        </section>
     
		<div id='step_email' style='display:none'>
        <h3>Email - OptIn</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/-n6pHzelErE' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
            <legend>Email Auto Responder Settings</legend>
     
			<p>
				<label for="video_email_time">Entry Time (Seconds)</label>
				<input value="<?php echo $overplay_option['video_email_time']; ?>" id="video_email_time" name="vop_options[video_email_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to display OptIn after Video Plays."); ?>
			</p>
			
			<p>
				<label for="email_exit_time">Exit Time (Seconds)</label>
				<input value="<?php echo $overplay_option['email_exit_time']; ?>"  id="email_exit_time" name="vop_options[email_exit_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to exit email OptIn form. Only works when Video keeps playing after entry of optin form."); ?>
			</p>
			
			<p>
				<label for="email_keep_playing">Keep Playing Video</label>
				<input value="yes" <?php checked("yes",$overplay_option['email_keep_playing']); ?> id="email_keep_playing" name="vop_options[email_keep_playing]" type="checkbox"  />
				<?php $this->tooltip("Check this to keep playing video while Email Opt in is visible, Uncheck to pause the video on entry of OptIn Form"); ?>
			</p>
			
			
			
			<p>
				<label for="video_email_title">Optin Headline</label>
				<input  value="<?php echo $overplay_option['video_email_title']; ?>"  id="video_email_title" name="vop_options[video_email_title]" type="text"  />
			</p>
			
			<p>
				<label for="video_email_skip_text">Skip Text</label>
				<input  value="<?php echo $overplay_option['video_email_skip_text']; ?>"  id="video_email_skip_text" name="vop_options[video_email_skip_text]" type="text"  />
			</p>
			<p>
				<label for="video_email_wait_text">Wait Message</label>
				<input  value="<?php echo $overplay_option['video_email_wait_text']; ?>"  id="video_email_wait_text" name="vop_options[video_email_wait_text]" type="text"  />
				<?php $this->tooltip("Text to display while submitting form"); ?>
			</p>
			<p>
				<label for="video_email_thanks_text">Thanks Message</label>
				<input  value="<?php echo $overplay_option['video_email_thanks_text']; ?>"  id="video_email_thanks_text" name="vop_options[video_email_thanks_text]" type="text"  />
				<?php $this->tooltip("Text to display on successfully submission of form."); ?>
			</p>
			
			<p>
				<label for="video_email_name_label">Name Placeholder (Label)</label>
				<input value="<?php echo $overplay_option['video_email_name_label']; ?>"  id="video_email_name_label" name="vop_options[video_email_name_label]" type="text"  />
			</p>
			
			<p>
				<label for="video_email_email_label">Email Placeholder (Label)</label>
				<input  value="<?php echo $overplay_option['video_email_email_label']; ?>"  id="video_email_email_label" name="vop_options[video_email_email_label]" type="text"  />
			</p>
			
			<p>
				<label for="video_email_button_text">Button Text</label>
				<input  value="<?php echo $overplay_option['video_email_button_text']; ?>"  id="video_email_button_text" name="vop_options[video_email_button_text]" type="text"  />
			</p>
			
			<p>
				<label for="email_button_style">Button Style (click button)</label>
				<?php $videooverplay_class->print_button_style("vop_options[email_button_style]",$overplay_option['email_button_style'],'email'); ?>	
			</p>
			<p>
				<label for="video_email_service">Choose Email Service</label>
				<input class='ar_radio' data='aweber_container' <?php checked($overplay_option['video_email_service'],"aweber");  ?> id="video_email_service_aweber" name="vop_options[video_email_service]" type="radio" value='aweber' /><label for='video_email_service_aweber' class='radio_label'>Aweber</label>
				
				<input class='ar_radio' data='gr_container' <?php checked($overplay_option['video_email_service'],"gr");  ?> id="video_email_service_gr" name="vop_options[video_email_service]" type="radio" value='gr' /><label for='video_email_service_gr' class='radio_label'>GetResponse</label>
				
				<input class='ar_radio' data='mc_container' <?php checked($overplay_option['video_email_service'],"mc");  ?> id="video_email_service_mc" name="vop_options[video_email_service]" type="radio" value='mc' /><label for='video_email_service_mc' class='radio_label'>MailChimp</label>
				
				<input class='ar_radio' data='o_container' <?php checked($overplay_option['video_email_service'],"i");  ?> id="video_email_service_i" name="vop_options[video_email_service]" type="radio" value='i' /><label for='video_email_service_i' class='radio_label'>iContact</label>
				
				<input class='ar_radio' data='o_container' <?php checked($overplay_option['video_email_service'],"other");  ?> id="video_email_service_o" name="vop_options[video_email_service]" type="radio" value='other' /><label for='video_email_service_o' class='radio_label'>Other</label>
				
			</p>
			
			<fieldset class='<?php echo ($overplay_option['video_email_service']!="aweber")? "vop_hideme":"vop_hideme2"; ?>' id='aweber_container'>
				<legend>Aweber Settings:</legend>
				<p id='aweber_details'>
					<?php 
					if(is_array($vop_option['aweber_list_all']) AND count($vop_option['aweber_list_all'])>0 AND $vop_option['aweber_error_code'] == "" AND $vop_option['aweber_auth_code'] != "")
					{	
							$lists = $vop_option['aweber_list_all']; 
						  ?>
						  <label for='aweber_list'>Aweber Campaign</label>
						   <select name="vop_options[aweber_list]" id="aweber_list">                 
						   <option <?php selected($overplay_option['aweber_list'],'none'); ?> value='none'>--None--</option>
							   <?php foreach ($lists as $k=>$v) { ?>
								  <option value="<?php echo $k; ?>"<?php echo ($k == $overplay_option['aweber_list']) ? ' selected="selected"' : ""; ?>><?php echo $v; ?></option>
							   <?php }  ?>
						   </select>
					<?php 
					}
					elseif($vop_option['aweber_auth_code'] == ""  )
					{ 	echo "You will need to <a href='".admin_url("admin.php?page=videooverplay&tab=3")."' target='_blank'>enter your API Key</a> then save options to gain access to the list of campaigns"; 
					}						
					elseif($vop_option['aweber_error_code'] != ""  )
					{
						echo "<p>Following error occured while connecting to aweber. Please <a href='".admin_url("admin.php?page=videooverplay&tab=3")."'  target='_blank'>click here</a> and correct aweber api settings.</p>";
						echo "<p><b>error:</b>".$vop_option['aweber_error_code']."</p>";
						
					}
					?>
				</p>
			
			</fieldset>
			
			<fieldset class='<?php echo ($overplay_option['video_email_service']!="gr")? "vop_hideme":"vop_hideme2"; ?>' id='gr_container'>
				<legend>GetResponse Settings:</legend>
			
				<p id='gr_form'>
					<?php 
					 if($vop_option['getresponse_api_key'] != '' AND is_array($vop_option['gr_list_all']) AND count($vop_option['gr_list_all'])>0) {
						 # initialize JSON-RPC client
						 ?>
							<label for='gr_list'>Select GetResponse Campaign: </label>
							<select id="getresponse_campaign" class="regular-text" type="text" name="vop_options[getresponse_campaign]" />
							<option <?php selected($overplay_option['getresponse_campaign'],'none'); ?> value='none'>--None--</option>
							<?php
							 foreach ($vop_option['gr_list_all'] as $k => $v) {
								$selected = ($overplay_option['getresponse_campaign'] == $k) ? " selected" : "";
								echo "<option value='{$k}' {$selected}>".$v."</option>";
							 }
							?>
							</select>
						 	<?php 
							} 
							else if(trim($vop_option['getresponse_api_key']) == '') 
							{ echo "You will need to <a href='".admin_url("admin.php?page=videooverplay&tab=3")."'  target='_blank'>enter your API Key</a> then save options to gain access to the list of campaigns"; 
							}
							else if($vop_option['getresponse_api_key'] != '' AND $vop_option['gr_error_code']!="")
							{
								echo $vop_option['gr_error_code'];
							}

							?>
					
					
				</p>
			</fieldset>
			
			<fieldset class='<?php echo ($overplay_option['video_email_service']!="mc")? "vop_hideme":"vop_hideme2"; ?>' id='mc_container'>
				<legend>MailChimp Settings:</legend>
				<p id='gr_form'>
					<label for='ar_formurl'>HTML/Subscribe Form URL</label>
					<input type='text' id='ar_formurl' name="vop_options[ar_formurl]" value="<?php echo $overplay_option['ar_formurl']; ?>" />
					<b>OR</b><br>
					<label for='ar_form'>HTML Signup Form:</label>
					<textarea name="vop_options[ar_form]" id='ar_form'><?php echo stripslashes($overplay_option['ar_form']); ?></textarea>
				</p>
			</fieldset>
			
			
			<fieldset class='<?php echo ($overplay_option['video_email_service']!="other" AND $overplay_option['video_email_service']!="i")? "vop_hideme":"vop_hideme2"; ?>' id='o_container'>
				<legend>Signup Form Settings:</legend>
				<p>
					<label for='ar_formfldname'>Enter input field name for the name input</label>
					<input data-autoresponder-field="name" value="<?php echo $overplay_option['ar_formfldname']; ?>"  type='text' name="vop_options[ar_formfldname]" id='ar_formfldname' />
				</p>
				<p>
					<label for='ar_formfldemail'>Enter input field name for the email input</label>
					<input data-autoresponder-field="email" value="<?php echo $overplay_option['ar_formfldemail']; ?>"  type='text' name="vop_options[ar_formfldemail]" id='ar_formfldemail' />
				</p>
				<p>
					<label for="ar_form1">HTML Sign-up form</label>
					<textarea data-autoresponder-field="form" name="vop_options[ar_form1]" class='' id='ar_form1'><?php echo stripslashes($overplay_option['ar_form']); ?></textarea>
				</p>
			</fieldset>
			
			<?php $videooverplay_class->animation_style("email",$overplay_option); ?>
			
        </section>
		</div>
		<div id='step_social' style='display:none'>
        <h3>Social Settings</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/ZhoYBUH1GyY' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
            <legend>Edit the Twitter, Facebook and Google+ Buttons</legend>
     
            <p>
				<label for="social_entry_time">Entry Time (Seconds)</label>
				<input value="<?php echo $overplay_option['social_entry_time']; ?>"  id="social_entry_time" name="vop_options[social_entry_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to display Social Icons."); ?>
			</p>
			<p>
				<label for="social_exit_time">Exit Time (Seconds)</label>
				<input value="<?php echo $overplay_option['social_exit_time']; ?>"  id="social_exit_time" name="vop_options[social_exit_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to exit Social Icons."); ?>
			</p>
			
			<p>
				<label for="social_force">Force to Click</label>
				<input <?php checked("yes",$overplay_option['social_force']); ?>  id="social_force" name="vop_options[social_force]" type="checkbox" value="yes"  />
				<?php $this->tooltip("If checked, video will pause on entry of social icons and will not play until user click any of the social icons. This way you can force visitor to click on social icons to keep watching the video."); ?>
			</p>
			
			
			
			<p>
				<label for="social_networks">Enable Social Networks</label>
				<?php
				$social_array = array("facebook","googleplus","linkedin","pinterest","tumblr","twitter",);
				foreach ($social_array as $s)
				{
					echo "<input value='$s' ";
					if(in_array("$s",(array)$overplay_option['social_networks']))
						echo 'checked="checked"';
					echo " id='social_$s' name='vop_options[social_networks][]' type='checkbox'  /><label class='social_network_checkbox' for='social_$s'><img src='".plugins_url("../assets/images/social_icons/set_2/$s.png",__FILE__)."' /></label>";
				}
				?>
				
			</p>
			
			<p>
				<label for="social_display">Arrange Icons:</label>
				<select name="vop_options[social_display]" >
					<option value='h' <?php selected('h',$overplay_option['social_display']); ?> >Horizontally</option>
					<option value='v' <?php selected('v',$overplay_option['social_display']); ?>>Vertically</option>
				</select>
			</p>
			
			
				<span style='min-width:200px;max-width:200px;display:inline-block'>Social Icon Set</span>
				<input type="button" class='animation_show button-primary' value='Show/Hide'>
				<div style="display:none;margin:20px;vertical-align: text-top;" >
				
				<?php 
				$social_array = array("facebook","googleplus","linkedin","pinterest","tumblr","twitter",);
				$social_sets = array(1,5,6,3,2,7,4,8,9,10,11,12,13,14,15);
				foreach($social_sets as $i)
				{
					echo "<input type='radio' name='vop_options[social_set]' ".checked($i,$overplay_option['social_set'],false)." value='$i' id='social_set_$i' class='social_set_input'>";
					echo "<div id='set_$i' class='social_icons_set'>";
					foreach($social_array as $s)
					{
						echo "<div style='background-image:url(".plugins_url("../assets/images/social_icons/set_$i/$s.png",__FILE__)."); background-repeat:no-repeat; background-position:center; ' class='social_icon_in_set'></div>";
					
					}
					echo "<label class='social_labels' for='social_set_$i'>&nbsp;</label></div><br>";
					
				}
				
				?>
				</div>
			
			<p>
				<label for="social_headline">Social Headline</label>
				<input value="<?php echo $overplay_option['social_headline']; ?>"  id="social_headline" name="vop_options[social_headline]" type="text"  />
			</p>
			
			<p>
				<label for="social_headline_style">Font Size:</label>
				
				<input style='width:50px;' value="<?php echo $overplay_option['social_headline_font_size']; ?>"   name="vop_options[social_headline_font_size]" type="number"  />px
			</p>
			<p>
				<label for="">Font Color: </label>
				<input value="<?php echo $overplay_option['social_headline_font_color']; ?>" name="vop_options[social_headline_font_color]" type="text" class='color-input' />
				<input type='button' class='pickcolor button-secondary' value='Select Color' />
				<span style='z-index: 100; background:#eee; border:1px solid #ccc;display:inline;'></span>
			</p>
			<p>
				<label>Font Style:</label>
				<select  name="vop_options[social_headline_font_style]">
					<option <?php selected("normal",$overplay_option['social_headline_font_style']); ?> value="normal">Normal</option>
					<option <?php selected("italic",$overplay_option['social_headline_font_style']); ?> value="italic">Italic</option>
					<option <?php selected("bold",$overplay_option['social_headline_font_style']); ?> value="bold">Bold</option>
					<option <?php selected("underline",$overplay_option['social_headline_font_style']); ?> value="underline">Underline</option>
				</select>
			</p>	
				
			
			
			<p>
				<label for="">Use social icons as</label>
				<input class='ar_radio' data='what_to_share_post_container' value="post" <?php checked($overplay_option['what_to_share'],"post"); ?>  id="what_to_share_post" name="vop_options[what_to_share]" type="radio"  />
				<label for="what_to_share_post">Post Share</label>
				<input class='ar_radio' data='what_to_share_custom_container' value="custom" <?php checked($overplay_option['what_to_share'],"custom"); ?>  id="what_to_share_custom" name="vop_options[what_to_share]" type="radio"  />
				<label for="what_to_share_custom">Custom Share</label>
				<input class='ar_radio' data='what_to_share_follow_container' value="follow" <?php checked($overplay_option['what_to_share'],"follow"); ?>  id="what_to_share_follow" name="vop_options[what_to_share]" type="radio"  />
				<label for="what_to_share_follow">Follow Buttons</label>
				
			</p>
				<fieldset class='vop_hideme' id='what_to_share_custom_container'>
					<legend>Custom sharing settings</legend>
						<p>
							<label for="social_text">Share Title</label>
							<input value="<?php echo $overplay_option['social_text']; ?>"  id="social_text" name="vop_options[social_text]" type="text"  />
						</p>
						
						<p>
							<label for="social_desc">Share Description</label>
							<input value="<?php echo $overplay_option['social_desc']; ?>"  id="social_desc" name="vop_options[social_desc]" type="text"  />
						</p>
						
						
						<p>
							<label for="social_url">URL to Share</label>
							<input value="<?php echo $overplay_option['social_url']; ?>"  id="social_url" name="vop_options[social_url]" type="text"  />
						</p>
					
				</fieldset>
				<fieldset class='vop_hideme' id='what_to_share_post_container'>
					<legend>Post Sharing</legend>
						<p>
							This will share the default post / page title/url where video has been embedded.
						</p>
				</fieldset>
				<fieldset class='vop_hideme' id='what_to_share_follow_container'>
					<legend>Follow Buttons</legend>
						<p>
							Convert sharing buttons into follow buttons that links to <a href='<?php echo admin_url("admin.php?page=videooverplay&tab=2"); ?>'  target='_blank'>these</a> should be social media URLs. <a href="<?php echo admin_url("admin.php?page=videooverplay&tab=2"); ?>"  target='_blank'>Click here</a> to configure your social media urls.
						</p>
				</fieldset>
				
			<?php $videooverplay_class->animation_style("social",$overplay_option); ?>
			
        </section>
		</div>
		<div id='step_funnel' style='display:none'>
		<h3>Funnel</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/4ogDfEZclQY' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
            <legend>Add a question and show targeted video.</legend>
     
            <p>
				<label for="quest_time">Entry Time (Seconds)</label>
				<input  value="<?php echo $overplay_option['quest_time']; ?>"  id="quest_time" name="vop_options[quest_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to display."); ?>
			</p>
			
			<p>
				<label for="quest_exit_time">Exit Time (Seconds)</label>
				<input value="<?php echo $overplay_option['quest_exit_time']; ?>"  id="quest_exit_time" name="vop_options[quest_exit_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to exit Funnel. Only works if video keeps playing after entry of funnel"); ?>
			</p>
			
			<p>
				<label for="quest_keep_playing">Keep Playing Video</label>
				<input value="yes" <?php checked("yes",$overplay_option['quest_keep_playing']); ?> id="quest_keep_playing" name="vop_options[quest_keep_playing]" type="checkbox"  />
				<?php $this->tooltip("Check this to keep playing video while Funnel is visible, Uncheck to pause the video on entry of Funnel"); ?>
			</p>
			
			
			<p>
				<label for="quest_question">Question</label>
				<input value="<?php echo $overplay_option['quest_question']; ?>"  id="quest_question" name="vop_options[quest_question]" type="text"  />
			</p>
			
			<p>
				<label for="quest_ans1">Answer #1</label>
				<input value="<?php echo $overplay_option['quest_ans1']; ?>"  id="quest_ans1" name="vop_options[quest_ans1]" type="text"  />
			</p>
			
			<p>
				<label for="quest_button_style1">Button 1 Style (click button)</label>
				<?php $videooverplay_class->print_button_style("vop_options[quest_button_style1]",$overplay_option['quest_button_style1'],'funnel1'); ?>	
			</p>
			
			<p>
				<label for="quest_video1">Video ID/URL - 1</label>
				<input  value="<?php echo $overplay_option['quest_video1']; ?>"  id="quest_video1" name="vop_options[quest_video1]" type="text" />
				<?php $this->tooltip("YouTube video URL, OR Video ID Only."); ?>
			</p>
			
			<p>
				<label for="quest_ans2">Answer #2</label>
				<input value="<?php echo $overplay_option['quest_ans2']; ?>"  id="quest_ans2" name="vop_options[quest_ans2]" type="text"  />
			</p>
			
			<p>
				<label for="quest_button_style2">Button 2 Style (click button)</label>
				<?php $videooverplay_class->print_button_style("vop_options[quest_button_style2]",$overplay_option['quest_button_style2'],'funnel2'); ?>	
				
			</p>
			
			<p>
				<label for="quest_video2">Video ID/URL - 2</label>
				<input value="<?php echo $overplay_option['quest_video2']; ?>"  id="quest_video2" name="vop_options[quest_video2]" type="text" />
				<?php $this->tooltip("YouTube video URL, OR Video ID Only."); ?>
			</p>
			
			<p>
				<label for="quest_skip_text">Skip Text</label>
				<input value="<?php echo $overplay_option['quest_skip_text']; ?>"  id="quest_skip_text" name="vop_options[quest_skip_text]" type="text" />
			</p>
			
			<?php $videooverplay_class->animation_style("funnel",$overplay_option); ?>
			
		</section>
		</div>
		<div id='step_cta' style='display:none'>
		<h3>Call to Action</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/wG_QVUB4xDw' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
			
            <legend>Add a Order / Link Button to Your Video</legend>
     
            <p>
				<label for="cta_time">Entry Time (Seconds)</label>
				<input  value="<?php echo $overplay_option['cta_time']; ?>"  id="cta_time" name="vop_options[cta_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to display."); ?>
			</p>
			
			<p>
				<label for="cta_exit_time">Exit Time (Seconds)</label>
				<input value="<?php echo $overplay_option['cta_exit_time']; ?>"  id="cta_exit_time" name="vop_options[cta_exit_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to exit CTA."); ?>
			</p>
			
			<p>
				<label for="cta_headline">CTA Headline</label>
				<input value="<?php echo $overplay_option['cta_headline']; ?>"  id="cta_headline" name="vop_options[cta_headline]" type="text"  />
			</p>
			
			<p>
				<label for="cta_button_text">CTA Button Text</label>
				<input value="<?php echo $overplay_option['cta_button_text']; ?>"  id="cta_button_text" name="vop_options[cta_button_text]" type="text"  />
			</p>
			
			<p>
				<label for="cta_url">CTA Link</label>
				<input  value="<?php echo $overplay_option['cta_url']; ?>"  id="cta_url" name="vop_options[cta_url]" type="text"  />
				<input type='checkbox' name='vop_options[cta_link_target]' id='cta_link_target' <?php checked($overplay_option['cta_link_target'],'yes'); ?> value='yes' />
				<label for='cta_link_target'>Open in new window</label>
			</p>
			
			<p>
				<label for="cta_button_style">Button Style (click button)</label>
				<?php $videooverplay_class->print_button_style("vop_options[cta_button_style]",$overplay_option['cta_button_style'],'cta'); ?>	
				
			</p>
			 
			<?php $videooverplay_class->animation_style("cta",$overplay_option); ?>
			
		</section>
		</div>
		<div id='step_ad' style='display:none'>
		<h3>Ad Banner</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/puixXsEFXp8' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>
            <legend>Custom Ad Banner</legend>
     
            <p>
				<label for="ad_time">Entry Time (Seconds)</label>
				<input  value="<?php echo $overplay_option['ad_time']; ?>"  id="ad_time" name="vop_options[ad_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to display."); ?>
			</p>
			
			<p>
				<label for="ad_exit_time">Exit Time (Seconds)</label>
				<input value="<?php echo $overplay_option['ad_exit_time']; ?>"  id="ad_exit_time" name="vop_options[ad_exit_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to exit Ad banner."); ?>
			</p>
			
			<p>
				<label for="banner_online">Always on mouse hover</label>
				<input <?php checked("yes",$overplay_option['banner_online']); ?>  id="banner_online" name="vop_options[banner_online]" type="checkbox" value="yes"  />
				<?php $this->tooltip("If checked, banner will enter the video everytime mouse pointer enters the video and will exit when mouse moves out the video area."); ?>
			</p>
			
			
			<p>
				<label for="ad_img">Ad Banner Image</label>
				<input  value="<?php echo $overplay_option['ad_img']; ?>"  id="ad_img" name="vop_options[ad_img]" class='image_upload' type="text" />
				<button type='button' class="vop_media_buttons button">Upload/Select</button>
			</p>
			<p>
				<label for="ad_width">Banner Size</label>
				<input style='width:70px;' value="<?php echo $overplay_option['ad_width']; ?>"  id="ad_width" name="vop_options[ad_width]" type="number" />px (Width) &nbsp;  &nbsp;  &nbsp;  &nbsp; X &nbsp;  &nbsp;  &nbsp;  &nbsp; 
				<input style='width:70px;' value="<?php echo $overplay_option['ad_height']; ?>"  id="ad_height" name="vop_options[ad_height]" type="number" />px (Height)
			</p>
			<p>
				<label for="ad_url">Ad Link</label>
				<input  value="<?php echo $overplay_option['ad_url']; ?>"  id="ad_url" name="vop_options[ad_url]" type="text"  />
				<input type='checkbox' name='vop_options[ad_url_target]' id='ad_url_target' <?php checked($overplay_option['ad_url_target'],'yes'); ?> value='yes' />
				<label for='ad_url_target'>Open in new window</label>
			</p>
			
			<?php $videooverplay_class->animation_style("ad",$overplay_option); ?>
			
		</section>
		
		</div>
		
		<div id='step_html' style='display:none'>
		<h3>Html Ad</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/onIotNaEZ1A' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>	
            <legend>Custom HTML Ad </legend>
     
            <p>
				<label for="html_time">Entry Time (Seconds)</label>
				<input  value="<?php echo $overplay_option['html_time']; ?>"  id="html_time" name="vop_options[html_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to display."); ?>
			</p>
			
			<p>
				<label for="html_exit_time">Exit Time (Seconds)</label>
				<input value="<?php echo $overplay_option['html_exit_time']; ?>"  id="html_exit_time" name="vop_options[html_exit_time]" type="number"  />
				<?php $this->tooltip("No. of seconds to exit Ad banner."); ?>
			</p>
			
			<p>
				<label for="html_online">Always on mouse hover</label>
				<input <?php checked("yes",$overplay_option['html_online']); ?>  id="html_online" name="vop_options[html_online]" type="checkbox" value="yes"  />
				<?php $this->tooltip("If checked, banner will enter the video every time mouse pointer enters the video and will exit when mouse moves out the video area."); ?>
			</p>
			
			
			<p>
				<label for="html_code">Your HTML Code</label>
				<textarea id="html_code" name="vop_options[html_code]"><?php echo stripslashes($overplay_option['html_code']); ?></textarea>
				
			</p>
			<?php $videooverplay_class->animation_style("html",$overplay_option); ?>
			
		</section>
		</div>
		
		<div id='step_advanced' style='display:none'>
		<h3>Advanced</h3>
        <section>
			<a style='float:right;' href='https://www.youtube.com/embed/6z8k0nJ1SOs' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a>	
			<legend>Custom code insertion for advanced user only</legend>
     
            <p>
				<label for="advanced_code">Custom CSS/JS Code <?php $this->tooltip("Only for advanced users.. The code you enter here will be inserted as it is on player, so dont forget to enclose your code with &lt;style&gt; and &lt;script&gt; tags.."); ?></label>
				<textarea rows=15 style='width:100%;background:#eee;' id="advanced_code" name="vop_options[advanced_code]"><?php echo stripslashes($overplay_option['advanced_code']); ?></textarea>
				
			</p>
			
		</section>
		
		
		</div>
		
    </form>
	</div>
	
	<?php
		if(!(isset($_POST['vop_id']) AND $_POST['action'] != 'Delete'))
		{
			global $videooverplay_class, $wpdb;
			$table = $wpdb->prefix . "videooverplay";
			
			
			
			$per_page = (int) (!isset($_POST["per_page"]) ? 10 : $_POST["per_page"]);	
			$vop_page = (int) (!isset($_GET["vop_page"]) ? 1 : $_GET["vop_page"]);	
			$startpoint = ($vop_page * $per_page) - $per_page;
			$url = "?";
			$total = $wpdb->get_var("SELECT count(id) FROM $table WHERE 1");
			
			$starting = $per_page * $vop_page;
			$ending = $starting + $per_page;
			
			$manage_overplay = $wpdb->get_results("SELECT * FROM $table WHERE 1 ORDER BY id DESC LIMIT $startpoint,$per_page");
			
			
			//$videooverplay_class->vop_print($manage_overplay);
			echo $videooverplay_class->vop_pagination($per_page,$vop_page,$url,$total);
			echo "<h3>OverPlays</h3>";
			
			echo "<table class='widefat vop_table'>
					<thead>
						<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Video</th>
						<th>Embed Shortcode</th>
						<th>Action</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Video</th>
						<th>Embed Shortcode</th>
						<th>Action</th>
						</tr>
					</tfoot>
					<tbody>
					";
					
			
			if(!is_array($manage_overplay) OR count($manage_overplay)==0)
				echo "<tr><td colspan='7' style='text-align:center;color:red;font-weight:bold;'>No Overplays added yet!</td></tr>";
			else
			{
				//$videooverplay_class->vop_print($manage_overplay);
				
				foreach ($manage_overplay as $v)
				{
					//calculate CTR
					/*
					$ctr = 0;
					if($v->view>0 AND $v->click>0)
						$ctr = round(($v->click / $v->view),2);
					
					$analysis = "<span class='analysis'>
								<label>Video Views: </label> $v->view<br>
								<label>Video Played: </label> $v->play_button_click <br>
								<label>Funnel Views: </label> $v->funnel_view<br>
								<label>Funnel Clicks: </label> ".($v->funnel_ans1_click + $v->funnel_ans2_click)."<br>
								<label>CTA Views: </label> $v->cta_view<br>
								<label>CTA Clicks: </label> $v->cta_click<br>
								<label>Social View: </label> $v->social_click<br>
								<label>Social Click: </label> $v->social_click<br>
								<label>OptIn View: </label> $v->email_view<br>
								<label>OptIn filled: </label> $v->email_signup<br>
								<label>End Banner View: </label> $v->end_url_view<br>
								<label>End Banner Click: </label> $v->end_url_click<br>
								</span>";
								*/
					$startpoint++;	
					echo "<tr><td>$startpoint</td><td class='name'>".$v->name."</td><td><img src='http://img.youtube.com/vi/".$v->video."/default.jpg'>
					</td>
						<td class='code' title='Copy this shortcode to any post/page content.'><span class='copycode'>[vop id='$v->id']</span></td>
						
					<td>
						<form action='' method='post'>
							<input type='hidden' name='vop_id' value='$v->id'>
							<input type='hidden' name='vop_security_check' value='$vop_security_check'>
							<a href='".plugins_url("../player/player.php?id=$v->id",__FILE__)."' title='Preview this overplay' target='_blank' ><span class='play_button vop_link_button'>Preview</span></a><br>
							<input type='submit' title='Edit this Overplay' class='edit_button vop_link_button' name='action' value='Edit' /><br>
							<input type='submit' title='Copy this Overplay' class='copy_button vop_link_button' name='action' value='Copy' /><br>
							<input type='submit' onclick='return confirm(\"Are you sure to delete this item?\");' title='Delete this Overplay' class='delete_button vop_link_button' name='action' value='Delete' />
							</form> 
					</td></tr>";
					
					
				
				}
			}
			echo "</tbody></table>";
			echo $videooverplay_class->vop_pagination($per_page,$vop_page,$url,$total);
			/*
			$vop_page = (int) (!isset($_GET["vop_page"]) ? 1 : $_GET["vop_page"]);
			$limit = 20;
			$startpoint = ($vop_page * $limit) - $limit;
			$statement = $table_name;

			echo rdl_pagination($statement,$limit,$vop_page);
			*/
		}
	?>
	
</div>
 
    