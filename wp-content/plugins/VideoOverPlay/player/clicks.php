<?php 
	require('../../../../wp-load.php');
	global $wpdb;
	$table = $wpdb->prefix . "videooverplay";
	$ID = $_GET['id'];
	$data = $_GET['data'];
	//track clicks
	//$wpdb->show_errors();
	if ( wp_verify_nonce( $_GET['_nounce'], 'vop_click_counter' ) ) 
	{
		echo $wpdb->query("UPDATE $table SET $data = $data + 1 WHERE id = $ID");  
		//$wpdb->print_error();
		//update split test db if required..
		if(isset($_GET['split_id']))
		{
			$split_id =  $_GET['split_id'];
			
			$table = $wpdb->prefix . "videooverload_split";
			$row = $wpdb->get_row("SELECT * FROM $table WHERE id = $split_id");
			//print_r($row);
			if($row->vop_1_id == $ID)
				$wpdb->query("UPDATE $table SET vop_1_$data = vop_1_$data + 1 WHERE id = $split_id");  	
			else if($row->vop_2_id == $ID)
				$wpdb->query("UPDATE $table SET vop_2_$data = vop_2_$data + 1 WHERE id = $split_id");  	
		}
		
	}
	else
		echo "Nope";
	
	
?>