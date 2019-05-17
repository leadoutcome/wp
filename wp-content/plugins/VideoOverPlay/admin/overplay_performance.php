<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$error = $success = array();
//include_once ( plugin_dir_path( __FILE__ ).'../apis/getresponse-api/jsonRPCClient.php' );
//include_once ( plugin_dir_path( __FILE__ ).'../apis/aweber_api/aweber_api.php');
if(isset($_POST['vop_security_check5']) AND $_POST['vop_security_check5'] == $_SESSION['vop_security_check5'])
{
	global $error, $sucess,$videooverplay_class,$vop_option, $wpdb;
	
	$_POST = $videooverplay_class->clean_array($_POST);
	
	$error = $success = array();
	
	//$videooverplay_class->vop_print($_POST);
	
}
else
{
	global $videooverplay_class,$vop_option;
}

$vop_security_check5 = md5(microtime());
$_SESSION['vop_security_check5']  = $vop_security_check5;



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
	echo "<h3>OverPlays Analysis <a href='https://www.youtube.com/embed/0PLG6Kdu9eY' class='video_viewer' title='Watch Video Tutorial'>&nbsp;</a></h3>";
	echo "";	
	//video tutorial link
	
	
	echo "<table class='widefat vop_table'>
			<thead>
				<tr>
				<th>No.</th>
				<th>Name</th>
				<th>Views</th>
				<th>Played</th>
				<th>OptIn <br>(Views/Click/CTR)</th>
				<th>Social <br>(Views/Click/CTR)</th>
				<th>Funnel <br>(Views/Click/CTR)</th>
				<th>CTA <br>(Views/Click/CTR)</th>
				<th>Ad Banner <br>(Views/Click/CTR)</th>
				<th>End Banner <br>(Views/Click/CTR)</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
				<th>No.</th>
				<th>Name</th>
				<th>Views</th>
				<th>Played</th>
				<th>OptIn <br>(Views/Click/CTR)</th>
				<th>Social <br>(Views/Click/CTR)</th>
				<th>Funnel <br>(Views/Click/CTR)</th>
				<th>CTA <br>(Views/Click/CTR)</th>
				<th>Ad Banner <br>(Views/Click/CTR)</th>
				<th>End Banner <br>(Views/Click/CTR)</th>
				</tr>
			</tfoot>
			<tbody>
			";
			
	
	if(!is_array($manage_overplay) OR count($manage_overplay)==0)
		echo "<tr><td colspan='10' style='text-align:center;color:red;font-weight:bold;'>No Overplays added yet!</td></tr>";
	else
	{
		//$videooverplay_class->vop_print($manage_overplay);
		
		foreach ($manage_overplay as $v)
		{
			$analysis = "<span class='analysis'>
						<label>Video Views: </label> $v->view<br>
						<label>Video Played: </label> $v->play_button_click <br>
						<label>Funnel Views: </label> $v->funnel_view<br>
						<label>Funnel Clicks: </label> ".($v->funnel_ans1_click + $v->funnel_ans2_click)."<br>
						<label>CTA Views: </label> $v->cta_view<br>
						<label>CTA Clicks: </label> $v->cta_click<br>
						<label>Social View: </label> $v->social_view<br>
						<label>Social Click: </label> $v->social_click<br>
						<label>OptIn View: </label> $v->email_view<br>
						<label>OptIn filled: </label> $v->email_signup<br>
						<label>End Banner View: </label> $v->end_url_view<br>
						<label>End Banner Click: </label> $v->end_url_click<br>
						</span>";
						
			$startpoint++;	
			echo "<tr>
					<td>$startpoint</td>
					<td>".$v->name."</td>
					<td>".$v->view."</td>
					<td>".$v->play_button_click."</td>
					<td>".$v->email_view." / ".$v->email_signup." / ".$this->ctr($v->email_view,$v->email_signup)."</td>
					<td>".$v->social_view." / ".$v->social_click." / ".$this->ctr($v->social_view,$v->social_click)."</td>
					<td>".$v->funnel_view." / ".($v->funnel_ans1_click + $v->funnel_ans2_click)." / ".$this->ctr($v->funnel_view,($v->funnel_ans1_click + $v->funnel_ans2_click))."</td>
					<td>".$v->cta_view." / ".$v->cta_click." / ".$this->ctr($v->cta_view,$v->cta_click)."</td>
					<td>".$v->ad_banner_view." / ".$v->ad_banner_click." / ".$this->ctr($v->ad_banner_view,$v->ad_banner_click)."</td>
					<td>".$v->end_url_view." / ".$v->end_url_click." / ".$this->ctr($v->end_url_view,$v->end_url_click)."</td>
					
			</tr>";
			
			
		
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
?>
</div>
 
    