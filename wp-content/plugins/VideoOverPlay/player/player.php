<?php
	// Full Featured Example -- Replace with Default.php for a Fresh Start
	require('../../../../wp-load.php');
	global $wpdb;
	$table = $wpdb->prefix . "videooverplay";
	$ID = $_GET['id'];
	
	$split_param = "";
	if(isset($_GET['split_id']))
		$split_param = "&split_id=".$_GET['split_id'];
	
	$results = json_decode($wpdb->get_var("SELECT options FROM $table WHERE id = $ID"));	
	
	if($results->email_exit_time!="" AND $results->email_exit_time <= $results->video_email_time)
		$results->email_exit_time  = $results->video_email_time + 10;
	if($results->quest_exit_time!="" AND $results->quest_exit_time <= $results->quest_time)
		$results->quest_exit_time  = $results->quest_time + 10;
	if($results->cta_exit_time!="" AND $results->cta_exit_time <= $results->cta_time)
		$results->cta_exit_time  = $results->cta_time + 10;
	if($results->ad_exit_time!="" AND $results->ad_exit_time <= $results->ad_time)
		$results->ad_exit_time  = $results->ad_time + 10;
	if($results->html_exit_time!="" AND $results->html_exit_time <= $results->html_time)
		$results->html_exit_time  = $results->html_time + 10;
	
	
	$vop = new videooverplay();
	
	//$vop->vop_print($results);
	
	$ytid = "";
	if(isset($_GET['video_id']) AND strlen($_GET['video_id'])==11)
	{
		$ytid = $_GET['video_id'];
	}
	else
	{
		$ytid = stripslashes($vop->get_youtube_id($results->video));	
	}
//die($results->video);
	
	//set default video size if not set by user_error
	if((int)$results->vop_video_width == 0) 
		$results->vop_video_width = 640;
	if((int)$results->vop_video_height == 0) 
		$results->vop_video_height = 360;
	
	//if video thumbnail image not set, load youtube thumbnail itself.
	if($results->video_play_img == "") 
		$results->video_play_img = "http://img.youtube.com/vi/".$ytid."/maxresdefault.jpg";
	
	//echo "<pre>".print_r($results,true)."</pre>";die();
	//full path to assets
	$assets = plugins_url('',__FILE__);
	
	// Track Views
	$wpdb->query("UPDATE $table SET view = view + 1 WHERE id = $ID");  
	if(isset($_GET['split_id']))
		{
			$split_id =  $_GET['split_id'];
			
			$table = $wpdb->prefix . "videooverload_split";
			$row = $wpdb->get_row("SELECT * FROM $table WHERE id = $split_id");
			//print_r($row);
			if($row->vop_1_id == $ID)
				$wpdb->query("UPDATE $table SET vop_1_view = vop_1_view + 1 WHERE id = $split_id");  	
			else if($row->vop_2_id == $ID)
				$wpdb->query("UPDATE $table SET vop_2_view = vop_2_view + 1 WHERE id = $split_id");  	
		}
	
	
	if($vop->options['global_enable'] == 'no')
		die("Plugin is disabled, Please go to plugin settings page to enable it.");
	
	//video color scheme settings
	$color_class = "custom_color";
	if(in_array(trim($results->video_color_scheme),array("black","blue","red","green")))
	{
		$color_class = $results->video_color_scheme;
	}
	
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-Equiv="Cache-Control" Content="no-cache" />
        <meta http-Equiv="Pragma" Content="no-cache" />
        <meta http-Equiv="Expires" Content="0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- SEO SETTINGS -->
        <title>
            <?php echo stripslashes($results->vop_seo_title); ?>
        </title>
        <meta name="description" content="<?php echo stripslashes($results->vop_seo_desc); ?>">

        <?php echo stripslashes($results->tracking); ?>
            <!-- Upgrade Browser Warning -->
            <script type="text/javascript">
                var $buoop = {};
                $buoop.ol = window.onload;
                window.onload = function() {
                    try {
                        if ($buoop.ol) $buoop.ol();
                    } catch (e) {}
                    var e = document.createElement("script");
                    e.setAttribute("type", "text/javascript");
                    e.setAttribute("src", "//browser-update.org/update.js");
                    document.body.appendChild(e);
                }
            </script>
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="<?php echo $assets; ?>/js/jquery.js?ver=<?php echo VOP_INTERNAL_VERSION; ?>"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="<?php echo $assets; ?>/js/bootstrap.min.js?ver=<?php echo VOP_INTERNAL_VERSION; ?>"></script>
            <script src="<?php echo $assets; ?>/js/velocity.js?ver=<?php echo VOP_INTERNAL_VERSION; ?>"></script>
            <!-- Bootstrap -->
            <link rel="stylesheet" href="<?php echo $assets; ?>/css/bootstrap.min.css?ver=<?php echo VOP_INTERNAL_VERSION; ?>">
            <link rel="stylesheet" href="<?php echo $assets; ?>/css/bootstrap-theme.min.css?ver=<?php echo VOP_INTERNAL_VERSION; ?>">
            <!-- Google Font Open Sans -->
            <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
            <!-- Your CSS Styles in css/style.css -->
            <link rel="stylesheet" href="<?php echo $assets; ?>/css/style.css?ver=<?php echo VOP_INTERNAL_VERSION; ?>">
            <!-- Font Awesome Icons check http://fontawesome.io/icons/ -->
            <link rel="stylesheet" href="<?php echo $assets; ?>/css/font-awesome.css?ver=<?php echo VOP_INTERNAL_VERSION; ?>">
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
            <script>
                function vop_animate_in(obj, transition, duration, easing) {
                    console.info("moving In:" + obj);
                    duration = typeof duration !== 'undefined' ? duration : 1000;
                    easing = typeof easing !== 'undefined' ? easing : "swing";

                    leftposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("left"));
                    topposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("top"));
                    rightposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("right"));
                    bottomposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("bottom"));

                    temp = transition.split("_");
                    if (temp[0] == 'short')
                        far = 100;
                    else
                        far = 1000;
                    if (temp.length == 1)
                        transition = temp[0];
                    else if (temp.length == 2)
                        transition = temp[1];
                    else if (temp.length == 3)
                        transition = temp[1] + "_" + temp[2];

                    oldPosition = {
                        top: topposition,
                        left: leftposition,
                        bottom: bottomposition,
                        right: rightposition,
                        opacity: 1
                    };
                    switch (transition) {
                        case "fade":
                            newPosition = oldPosition;
                            break;
                        case "right":
                            newPosition = {
                                left: 1 * far,
                                right: -1 * far
                            };
                            break;
                        case "left":
                            newPosition = {
                                left: -1 * far,
                                right: 1 * far
                            };
                            break;
                        case "top":
                            newPosition = {
                                bottom: 1 * far,
                                top: -1 * far
                            };
                            break;
                        case "bottom":
                            newPosition = {
                                top: 1 * far,
                                bottom: -1 * far
                            };
                            break;
                        case "left_top":
                            newPosition = {
                                top: -1 * far,
                                left: -1 * far,
                                bottom: 1 * far,
                                right: 1 * far
                            };
                            break;
                        case "top_right":
                            newPosition = {
                                top: -1 * far,
                                left: 1 * far,
                                bottom: 1 * far,
                                right: -1 * far
                            };
                            break;
                        case "right_bottom":
                            newPosition = {
                                top: 1 * far,
                                left: 1 * far,
                                bottom: -1 * far,
                                right: -1 * far
                            };
                            break;
                        case "bottom_left":
                            newPosition = {
                                top: 1 * far,
                                left: -1 * far,
                                bottom: -1 * far,
                                right: 1 * far
                            };
                            break;
                        default:
                            newPosition = {
                                bottom: 1 * far,
                                top: -1 * far
                            };
                            break;
                    }

                    if (isNaN(topposition))
                        delete newPosition.top;
                    if (isNaN(leftposition))
                        delete newPosition.left;
                    if (isNaN(rightposition))
                        delete newPosition.right;
                    if (isNaN(bottomposition))
                        delete newPosition.bottom;

                    if (isNaN(topposition))
                        delete oldPosition.top;
                    if (isNaN(leftposition))
                        delete oldPosition.left;
                    if (isNaN(rightposition))
                        delete oldPosition.right;
                    if (isNaN(bottomposition))
                        delete oldPosition.bottom;

                    console.info(newPosition);
                    $(obj).css(newPosition);
                    $(obj).show();
                    $(obj).css({
                        opacity: 0
                    });
                    $(obj).velocity("stop");
                    $(obj).velocity(oldPosition, duration, easing);

                }

                function vop_animate_out(obj, transition, duration, easing) {
                    console.info("moving out:" + obj);
                    duration = typeof duration !== 'undefined' ? duration : 1000;
                    easing = typeof easing !== 'undefined' ? easing : "swing";

                    leftposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("left"));
                    topposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("top"));
                    rightposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("right"));
                    bottomposition = parseInt(window.getComputedStyle(document.getElementById($(obj).attr("id")), null).getPropertyValue("bottom"));

                    temp = transition.split("_");
                    if (temp[0] == 'short')
                        far = 100;
                    else
                        far = 1000;
                    if (temp.length == 1)
                        transition = temp[0];
                    else if (temp.length == 2)
                        transition = temp[1];
                    else if (temp.length == 3)
                        transition = temp[1] + "_" + temp[2];
                    oldPosition = {
                        top: topposition,
                        left: leftposition,
                        bottom: bottomposition,
                        right: rightposition,
                        opacity: 1
                    };
                    switch (transition) {
                        case "fade":
                            newPosition = oldPosition;
                            break;
                        case "right":
                            newPosition = {
                                left: 1 * far,
                                right: -1 * far
                            };
                            break;
                        case "left":
                            newPosition = {
                                left: -1 * far,
                                right: 1 * far
                            };
                            break;
                        case "top":
                            newPosition = {
                                bottom: 1 * far,
                                top: -1 * far
                            };
                            break;
                        case "bottom":
                            newPosition = {
                                top: 1 * far,
                                bottom: -1 * far
                            };
                            break;
                        case "left_top":
                            newPosition = {
                                top: -1 * far,
                                left: -1 * far,
                                bottom: 1 * far,
                                right: 1 * far
                            };
                            break;
                        case "top_right":
                            newPosition = {
                                top: -1 * far,
                                left: 1 * far,
                                bottom: 1 * far,
                                right: -1 * far
                            };
                            break;
                        case "right_bottom":
                            newPosition = {
                                top: 1 * far,
                                left: 1 * far,
                                bottom: -1 * far,
                                right: -1 * far
                            };
                            break;
                        case "bottom_left":
                            newPosition = {
                                top: 1 * far,
                                left: -1 * far,
                                bottom: -1 * far,
                                right: 1 * far
                            };
                            break;
                        default:
                            newPosition = {
                                bottom: 1 * far,
                                top: -1 * far
                            };
                            break;
                    }

                    if (isNaN(topposition))
                        delete newPosition.top;
                    if (isNaN(leftposition))
                        delete newPosition.left;
                    if (isNaN(rightposition))
                        delete newPosition.right;
                    if (isNaN(bottomposition))
                        delete newPosition.bottom;

                    newPosition.opacity = 0;

                    if (isNaN(topposition))
                        delete oldPosition.top;
                    if (isNaN(leftposition))
                        delete oldPosition.left;
                    if (isNaN(rightposition))
                        delete oldPosition.right;
                    if (isNaN(bottomposition))
                        delete oldPosition.bottom;

                    console.info(newPosition);
                    //$(obj).css(newPosition);
                    //$( obj ).show();
                    //$(obj).css({opacity: 0});
                    $(obj).velocity("stop");
                    $(obj).velocity(newPosition, duration, easing);
                    setTimeout(function() {
                        $(obj).hide();
                    }, duration);

                }
            </script>
            <script>
                var player;

                function onYouTubePlayerAPIReady() {
                    player = new YT.Player('video', {
                        events: {
                            // call this function when player is ready to use
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });


                }
                var changedvideo = 0;
				var banner_online = false;
				var html_online = false;
                var checkOptin = 0;
                var checkOptinOut = 0;
                var checkCTA = 0;

                var ad_banner_exiting = 0;
                var html_banner_exiting = 0;
                var cta_exiting = 0;
                var ad_banner_view = 0;
                var html_banner_view = 0;
                var funnel_view = 0;
                var funnel_view_exit = 0;
                var cta_view = 0;
                var social_view = 0;
                var social_exiting = 0;
                var end_url_view = 0;
                var email_view = 0;

		function seekToYouTubeVideo(sec) {
     			console.log("seekToYouTubeVideo");
     			player.seekTo(sec,true);
     			player.playVideo();
		}

                function onPlayerStateChange(event) {
                    if (event.data === 0) {
                        $('#iframe').hide();
                        $('.theend_area').show();
                        send_view_click("end_url_view");
                        end_url_view = 1;
                    }


                    setInterval(function() {
                        <?php if ($results->video_email_time !== "" AND $results->enable_email_optin == 'yes') { ?>

                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->video_email_time); ?> && checkOptin == 0) {
                            checkOptin = 1;
                            //$( ".optinpop" ).velocity({ top: 0 }, 1000, "swing");
                            vop_animate_in(".optinpop", "<?php echo $results->email_start_animation; ?>", <?php echo (int)$results->email_in_animation_time; ?>, "<?php echo $results->email_easing_in; ?>");
                            send_view_click("email_view");
                            email_view = 1;
                            <?php
			if($results->email_keep_playing != 'yes')
			{
				?>
                            player.pauseVideo();
                            <?php
			}
			?>
                        }
                        <?php 
        } ?>

                        <?php if ($results->email_exit_time !== "" AND $results->enable_email_optin == 'yes') { ?>

                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->email_exit_time); ?> && checkOptinOut == 0) {
                            vop_animate_out(".optinpop", "<?php echo $results->email_end_animation; ?>", <?php echo (int)$results->email_out_animation_time; ?>, "<?php echo $results->email_easing_out; ?>");
                            player.playVideo();
                            checkOptinOut = 1;
                        }
                        <?php 
        } ?>

                        <?php if ($results->social_entry_time !== "" AND $results->enable_social == 'yes') { ?>
                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->social_entry_time); ?> && social_view == 0) {
                            //$( ".popup_social" ).show();
                            vop_animate_in(".popup_social", "<?php echo $results->social_start_animation; ?>", <?php echo (int)$results->social_in_animation_time; ?>, "<?php echo $results->social_easing_in; ?>");
							
							<?php if($results->social_force == 'yes') { ?>
								$(".popup_social_layer").show();
								player.pauseVideo();
							<?php } ?>
                            send_view_click("social_view");
                            social_view = 1;
                            //$( ".popup_social" ).velocity({left:14},1000,"easeOutBounce");
                            //$( ".popup_social" ).show( "drop", {direction: "down"}, 1000 );
                        }
                        <?php } ?>

                        <?php if ($results->social_exit_time != '' AND $results->social_exit_time > $results->social_entry_time ) { ?>
                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->social_exit_time); ?> && social_exiting == 0) {
                            <?php if($results->social_force == 'yes') { ?>
								$(".popup_social_layer").hide();
								player.playVideo();
							<?php }
							?>
                            //$( ".popup_social" ).show( "drop", {direction: "down"}, 1000 );
                            vop_animate_out(".popup_social", "<?php echo $results->social_end_animation; ?>", <?php echo (int)$results->social_out_animation_time; ?>, "<?php echo $results->social_easing_out; ?>");
                            social_exiting = 1;
                        }
                        <?php } ?>


                        <?php if ($results->ad_time != '' AND $results->enable_ad_banner == 'yes') { ?>
                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->ad_time); ?> && ad_banner_view == 0) {
                            vop_animate_in(".ad_banner_box", "<?php echo $results->ad_start_animation; ?>", <?php echo (int)$results->ad_in_animation_time; ?>, "<?php echo $results->ad_easing_in; ?>");
                            send_view_click("ad_banner_view");
                            ad_banner_view = 1;
                        }
                        <?php } ?>

                        <?php if ($results->ad_exit_time != ''  AND $results->enable_ad_banner == 'yes') { ?>
                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->ad_exit_time); ?> && ad_banner_exiting == 0) {
                            vop_animate_out(".ad_banner_box", "<?php echo $results->ad_end_animation; ?>", <?php echo (int)$results->ad_out_animation_time; ?>, "<?php echo $results->ad_easing_out; ?>");
                            ad_banner_exiting = 1;
							banner_online = true;
                        }
                        <?php } ?>

                        <?php if ($results->html_time != '' AND $results->enable_html_banner == 'yes') { ?>
                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->html_time); ?> && html_banner_view == 0) {
                            vop_animate_in(".html_banner_box", "<?php echo $results->html_start_animation; ?>", <?php echo (int)$results->html_in_animation_time; ?>, "<?php echo $results->html_easing_in; ?>");
                            //send_view_click("html_banner_view");
                            html_banner_view = 1;
                        }
                        <?php } ?>

                        <?php if ($results->html_exit_time != ''  AND $results->enable_html_banner == 'yes') { ?>
                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->html_exit_time); ?> && html_banner_exiting == 0) {
                            vop_animate_out(".html_banner_box", "<?php echo $results->html_end_animation; ?>", <?php echo (int)$results->html_out_animation_time; ?>, "<?php echo $results->html_easing_out; ?>");
                            html_banner_exiting = 1;
							html_online = true;
                        }
                        <?php } ?>

                        <?php if ($results->cta_time != "" AND $results->enable_cta =='yes') { ?>

                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->cta_time); ?> && checkCTA == 0) {
                            //$('.popup_top').velocity({top: 10});
                            vop_animate_in(".popup_cta", "<?php echo $results->cta_start_animation; ?>", <?php echo (int)$results->cta_in_animation_time; ?>, "<?php echo $results->cta_easing_in; ?>");
                            send_view_click("cta_view");
                            cta_view = 1;
                            checkCTA = 1;
                        }
                        <?php } if ($results->cta_exit_time != "" AND $results->enable_cta =='yes') { ?>
                        if (Math.ceil(player.getCurrentTime()) === <?php echo (stripslashes($results->cta_exit_time)); ?> && cta_exiting == 0) {
                            vop_animate_out(".popup_cta", "<?php echo $results->cta_end_animation; ?>", <?php echo (int)$results->cta_out_animation_time; ?>, "<?php echo $results->cta_easing_out; ?>");
                            cta_exiting = 1;
                            checkCTA = 1;
                        }
                        <?php } ?>

                        <?php if ($results->quest_time != '' AND $results->enable_funnel == 'yes') { ?>

                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->quest_time); ?> && changedvideo == 0 && funnel_view == 0) {


                            //$('.questionbox').velocity({top: 10});
                            vop_animate_in(".questionbox", "<?php echo $results->funnel_start_animation; ?>", <?php echo (int)$results->funnel_in_animation_time; ?>, "<?php echo $results->funnel_easing_in; ?>");

                            send_view_click("funnel_view");
                            funnel_view = 1;
                            <?php 
			if($results->quest_keep_playing != 'yes')
			{
			?>
                            player.pauseVideo();
                            <?php } ?>
                        }

                        <?php } ?>

                        <?php if ($results->quest_exit_time != '' AND $results->enable_funnel == 'yes') { ?>

                        if (Math.ceil(player.getCurrentTime()) === <?php echo stripslashes($results->quest_exit_time); ?> && changedvideo == 0 && funnel_view_exit == 0) {
                            //$('.questionbox').velocity({top: 10});
                            vop_animate_out(".questionbox", "<?php echo $results->funnel_end_animation; ?>", <?php echo (int)$results->funnel_out_animation_time; ?>, "<?php echo $results->funnel_easing_out; ?>");
                            funnel_view_exit = 1;
                            player.playVideo();
                        }

                        <?php } ?>

                    }, 1000);
                }

                function onPlayerReady(event) {
					
					<?php if ($results->banner_online == 'yes' AND $results->enable_ad_banner == 'yes') { ?>
                    var banner = document.getElementById("thevideo");
                    
					banner.addEventListener("mouseover", function() {
						if(banner_online == true)
						{
							$(".ad_banner_box").attr("style","");
							$(".ad_banner_box").show();
						}
                    });
					
					banner.addEventListener("mouseout", function() {
						if(banner_online == true)
						{
							$(".ad_banner_box").hide();
						}
                    });
					
                    <?php } ?>
					
					<?php if ($results->html_online == 'yes' AND $results->enable_html_banner == 'yes') { ?>
                    var banner = document.getElementById("thevideo");
                    
					banner.addEventListener("mouseover", function() {
						if(html_online == true)
						{
							$(".html_banner_box").attr("style","");
							$(".html_banner_box").show();
						}
                    });
					
					banner.addEventListener("mouseout", function() {
						if(html_online == true)
						{
							$(".html_banner_box").hide();
						}
                    });
					
                    <?php } ?>
					
					
					<?php if ($results->social_force == 'yes') { ?>
                    var social_icons = document.getElementById("popup_social");
                    social_icons.addEventListener("click", function() {

                        $(".popup_social_layer").hide();
						player.playVideo();
						vop_animate_out(".popup_social", "<?php echo $results->social_end_animation; ?>", <?php echo (int)$results->social_out_animation_time; ?>, "<?php echo $results->social_easing_out; ?>");
						social_exiting = 1;


                    });
                    <?php } ?>
					
					
					
                    <?php if ($results->enable_email_optin == 'yes') { ?>
                    var playviedeo2 = document.getElementById("playvideo2");
                    playviedeo2.addEventListener("click", function() {

                        vop_animate_out(".optinpop", "<?php echo $results->email_end_animation; ?>", <?php echo (int)$results->email_out_animation_time; ?>, "<?php echo $results->email_easing_out; ?>");
                        player.playVideo();


                    });
                    <?php } ?>

                    <?php if ($results->vop_autoplay == 'yes') { ?>

                    setTimeout(function() {
                        $('.thevideo_area').hide();
                        $('#iframe').show();
                        $("#playvideo").trigger("click");
                        player.playVideo();
                    }, <?php echo ((int)$results->vop_autoplay_time * 1000); ?>);

                    <?php } ?>

                    <?php if ($results->cta_time != "" AND $results->enable_cta == 'yes') { ?>
                    var ctalink = document.getElementById("ctalink_pause");
                    ctalink.addEventListener("click", function() {

                        vop_animate_out(".popup_cta", "<?php echo $results->cta_end_animation; ?>", <?php echo (int)$results->cta_out_animation_time; ?>, "<?php echo $results->cta_easing_out; ?>");
                        checkCTA = 1;
                        player.pauseVideo();


                    });
                    <?php } ?>

                    <?php if ($results->ad_time != ""  AND $results->enable_ad_banner == 'yes') { ?>
                    var adlink = document.getElementById("ad_banner_url");
                    adlink.addEventListener("click", function() {

                        $('.ad_banner_box').velocity("stop");
                        $('.ad_banner_box').velocity({
                            top: 1510
                        });
                        ad_banner_view = 1;
                        player.pauseVideo();


                    });
                    <?php } ?>



                    <?php if ($results->quest_time != ''  AND $results->enable_funnel == 'yes') { ?>


                    var playviedeo3 = document.getElementById("quest_skip");
                    playviedeo3.addEventListener("click", function() {
                        changedvideo = 1;


                        //$( ".questionbox" ).velocity("stop");
                        //$( ".questionbox" ).velocity({ top: -500 }, { queue: false });
                        vop_animate_out(".questionbox", "<?php echo $results->funnel_end_animation; ?>", <?php echo (int)$results->funnel_out_animation_time; ?>, "<?php echo $results->funnel_easing_out; ?>");

                        player.playVideo();


                    });



                    var question1 = document.getElementById("question1");
                    question1.addEventListener("click", function() {

                        $("#question1").html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        setTimeout(function() {
                            vop_animate_out(".questionbox", "<?php echo $results->funnel_end_animation; ?>", <?php echo (int)$results->funnel_out_animation_time; ?>, "<?php echo $results->funnel_easing_out; ?>");
                        }, 500);

                        changedvideo = 1;
                        var videoId = "<?php echo stripslashes($vop->get_youtube_id($results->quest_video1)); ?>";
                        setTimeout(function() {
                            player.loadVideoById(videoId);
                        }, 1500);


                    });

                    var question2 = document.getElementById("question2");
                    question2.addEventListener("click", function() {

                        $("#question2").html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        setTimeout(function() {
                            vop_animate_out(".questionbox", "<?php echo $results->funnel_end_animation; ?>", <?php echo (int)$results->funnel_out_animation_time; ?>, "<?php echo $results->funnel_easing_out; ?>");
                        }, 500);
                        changedvideo = 1;
                        var videoId = "<?php echo stripslashes($vop->get_youtube_id($results->quest_video2)); ?>";
                        setTimeout(function() {
                            player.loadVideoById(videoId);
                        }, 1500);


                    });
                    <?php } ?>


                    var playButton = document.getElementById("playvideo");
                    playButton.addEventListener("click", function() {
                        player.playVideo();
                    });


                }
                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/player_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            </script>
            <script>
                $(function() {
                    /*
			
	    $('#play-button').on('click', function() {
	      $('.thevideo_area').hide();
	      $('#iframe').show();
	      $( "#playvideo" ).trigger( "click" );
	    });
			*/
                    $('.play_icon_hover').on('click', function() {
                        $('.thevideo_area').hide();
                        $('#iframe').show();
                        $("#playvideo").trigger("click");
                    });

                });
            </script>
            <!-- Custom CSS -->
            <link rel="stylesheet" href="<?php echo $assets; ?>/videoplayer/videoplayer.css?ver=<?php echo VOP_INTERNAL_VERSION; ?>" />

            <style>
                #thevideo {
                    /* width:<?php echo ($results->vop_video_width + 12) ; ?>px; */
                    width: 100 %;
                }
                
                .container,
                .header,
                .footer {
                    max-width: <?php echo $results->vop_video_width;
                    ?>px;
                }
                
                #thevideo.custom_color {
                    background: <?php echo $results->video_color_scheme;
                    ?>;
                    box-shadow: inset 0 1px 1px <?php echo $vop->adjustColorBrightness($results->video_color_scheme, 50);
                    ?>,
                    0 2px 5px <?php echo $vop->adjustColorBrightness($results->video_color_scheme, -50);
                    ?>;
                    border: 1px solid <?php echo $vop->adjustColorBrightness($results->video_color_scheme, -100);
                    ?>;
                    border-bottom: 2px solid <?php echo $vop->adjustColorBrightness($results->video_color_scheme, -100);
                    ?>;
                }
                
                .popup_social h4 {
                    <?php //unset($results->social_headline_font_size);
                    //unset($results->social_headline_font_color);
                    //unset($results->social_headline_font_style);
                    if(isset($results->social_headline_font_size) AND $results->social_headline_font_size !="") echo "font-size:".$results->social_headline_font_size."px !important;";
                    if(isset($results->social_headline_font_style) AND $results->social_headline_font_style=="bold") echo "font-weight:bold !important;";
                    if(isset($results->social_headline_font_style) AND $results->social_headline_font_style=="underline") echo "text-decoration:underline !important;";
                    if(isset($results->social_headline_font_style) AND $results->social_headline_font_style=="italic") echo "font-style:italic !important;";
                    if(isset($results->social_headline_font_color) AND $results->social_headline_font_color !="") echo "color: ".$results->social_headline_font_color." !important;";
                    ?>
                }
				
				
				.popup_social_layer {
					background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
					height: 100% !important;
					position: absolute;
					top: 10px;
					width: 100% !important;
					display:none;
				}
            </style>
            <?php do_action("vop_vh_script"); 
		if(isset($results->advanced_code) AND $results->advanced_code!="" AND $results->enable_advanced_code == "yes")
			echo stripslashes($results->advanced_code); 
	  ?>
    </head>

    <body>
        <div class="row">

            <div class="container mainContainer">


                <div id="thevideo" class="<?php echo $color_class; ?>">


                    <div class="thevideo_area">
                        <span id="playvideo"></span>
                        <span id="play-button" data='play_button_click' style="background:url('<?php echo stripslashes($results->video_play_img); ?>') no-repeat;background-size:contain;display: block;height: <?php echo $results->vop_video_height; ?>px;background-size:contain;background-position:center center;" ga='Thumbnail Image' class="trackClick imagethumbnail"></span>
                        <span class='play_icon_hover'></span>
                    </div>

                    <div class="theend_area" style="display: none !important">
                        <a target="_blank" href="<?php echo stripslashes($results->video_end_url); ?>" class="trackClick" ga='Video End Banner Click' data='end_url_click'>
	
	<span id="end-button" style="background:url('<?php echo stripslashes($results->video_end_img); ?>') no-repeat;display: block;height: <?php echo $results->vop_video_height; ?>px;background-size:contain;background-position:center center;" class="imagethumbnail" ></span>
	</a>
                    </div>


                    <div id="iframe" style="display: none !important">
                        <div class="h_iframe">
                            <span class="ratio" style="background:url('<?php echo stripslashes($results->video_play_img); ?>') no-repeat;display: block;height: <?php echo $results->vop_video_height; ?>px;background-size:contain;background-position:center center;"></span>
                            <iframe id="video" src="https://www.youtube.com/embed/<?php echo $ytid; ?>?enablejsapi=1&html5=1&controls=0&rel=0&title=0&showinfo=0&iv_load_policy=3&hd=1&vq=hd720" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>

                    <?php if($vop->options['aff_id'] != "") { ?>
                        <div id="makemoney">
                            <a href="http://jvz7.com/c/<?php echo $vop->options['aff_id']; ?>/170885" target="_blank">
                                <img src="../assets/images/aff-logo.png" style='height:60px;' />
                            </a>
                        </div>
                        <?php } ?>
                            <?php if ($results->quest_time != '' AND $results->enable_funnel == 'yes') { ?>
                                <div id='questionbox' class="questionbox position_animation pos_<?php echo $results->funnel_position ; ?>">
                                    <br>
                                    <h3><strong><?php echo stripslashes($results->quest_question); ?></strong></h3>
                                    <a id='quest_skip' href="#" style="color: #fff; margin: 2px 0;"><?php echo stripslashes($results->quest_skip_text); ?></a>
                                    <br>
                                    <div class="col-xs-6">
                                        <button id="question1" data='funnel_ans1_click' ga='Funnel Answer 1' class="trackClick btn  btn-block btn-<?php echo stripslashes($results->quest_button_style1); ?> btn-lg">
                                            <?php echo stripslashes($results->quest_ans1); ?>
                                        </button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button id="question2" data='funnel_ans2_click' ga='Funnel Answer 2' class="trackClick btn btn-block btn-<?php echo stripslashes($results->quest_button_style2); ?> btn-lg">
                                            <?php echo stripslashes($results->quest_ans2); ?>
                                        </button>
                                    </div>
                                </div>
                                <?php } ?>

                                    <?php if ($results->cta_time != "" AND $results->enable_cta =='yes') { ?>
                                        <div class="popup_cta position_animation pos_<?php echo $results->cta_position ; ?> popup_top" id="popup_cta">
                                            <h4><?php echo stripslashes($results->cta_headline); ?></h4>
                                            <a href="<?php echo stripslashes($results->cta_url); ?>" target="<?php echo ($results->cta_link_target=='yes')?" _blank ":"_self "; ?>" data='cta_click' id='ctalink_pause' ga='Click To Action Button' class="btn trackClick btn-<?php echo stripslashes($results->cta_button_style); ?>" style="margin: 10px 0"><?php echo stripslashes($results->cta_button_text); ?></a>
                                        </div>
                                        <?php } ?>

                                            <?php if($results->ad_time !== '' AND $results->enable_ad_banner == 'yes') { 
  ?>
                                                <div id='ad_banner_box' class="ad_banner_box position_animation pos_<?php echo $results->ad_position ; ?>">
                                                    <a id='ad_banner_url' data='ad_banner_click' ga='Ad Banner' class='trackClick' href="<?php echo $results->ad_url; ?>" target="<?php echo ($results->ad_url_target=='yes')?" _blank ":"_self "; ?>" />

                                                    <img src="<?php echo $results->ad_img; ?>" style="<?php echo ($results->ad_width!='')?" width: ".$results->ad_width."px; ":" "; ?><?php echo ($results->ad_height!='')?"height: ".$results->ad_height."px; ":" "; ?>" />
                                                    </a>
                                                </div>
                                                <?php } ?>

                                                    <?php if($results->html_time !== '' AND $results->enable_html_banner == 'yes') { 
  ?>
                                                        <div id='html_banner_box' class="html_banner_box position_animation pos_<?php echo $results->html_position ; ?>">
                                                            <?php echo stripslashes($results->html_code); ?>
                                                        </div>
                                                        <?php } ?>


                                                            <?php if($results->video_email_time != ''  AND $results->enable_email_optin == 'yes') { ?>

                                                                <div class="optinpop position_animation pos_<?php echo $results->email_position ; ?>" id="optinpop">

                                                                    <h3><strong><?php echo stripslashes($results->video_email_title); ?></strong></h3>
                                                                    <a href="#" id="playvideo2" style="display: block; color: #fff; padding: 10px 0;"><?php echo stripslashes($results->video_email_skip_text); ?></a>


                                                                    <!-- Autoresponder -->
                                                                    <form action="" method="post" class="ARform" target="_blank">
                                                                        <input type="text" placeholder="<?php echo stripslashes($results->video_email_name_label); ?>" class="form-control" id="optinName" />
                                                                        <input type="email" <?php if($results->video_email_service == "mailchimp") { echo 'name="EMAIL" '; } else { echo 'name="email" '; } ?> placeholder="<?php echo stripslashes($results->video_email_email_label); ?>" class="form-control" id="optinEmail" />
                                                                            <input type="submit" class="btn btn-<?php echo stripslashes($results->email_button_style); ?> btn-lg btn-block" value="<?php echo stripslashes($results->video_email_button_text); ?>" />
                                                                            <div class='ARhidden'></div>
                                                                    </form>
                                                                    <div id="autoresponder" style="display: none">
                                                                        <textarea id="autoresponderCode" name="autoresponderCode">
                                                                            <?php echo stripslashes($results->ar_form); ?>
                                                                        </textarea>
                                                                        <input type="text" name="arname" id="arname" value="" />
                                                                        <input type="text" name="aremail" id="aremail" value="" />
                                                                        <input type="text" name="arform" id="arform" value="" />
                                                                        <textarea id="arhidden" name="arhidden"></textarea>
                                                                        <div id="arcode_debug">
                                                                            <div id="arcode_hdn_div"></div>
                                                                            <div id="arcode_hdn_div2"></div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <?php } ?>

                                                                    <?php if ($results->social_entry_time != '' AND $results->enable_social == 'yes') { ?>
																		<div class='popup_social_layer'>&nbsp;</div>
                                                                        <div class="popup_social social_<?php echo $results->social_display; ?> position_animation pos_<?php echo $results->social_position ; ?>" id="popup_social">
                                                                            <?php
	if($results->social_headline !="")
		echo "<h4>".$results->social_headline."</h4>";
	if(is_array($results->social_networks) AND count($results->social_networks)>0)
	{
		
		?>
                                                                                <style>
                                                                                    .social_icon_fb {
                                                                                        background-image: url("../assets/images/social_icons/set_<?php echo (int)$results->social_set; ?>/facebook.png");
                                                                                    }
                                                                                    
                                                                                    .social_icon_gp {
                                                                                        background-image: url("../assets/images/social_icons/set_<?php echo (int)$results->social_set; ?>/googleplus.png");
                                                                                    }
                                                                                    
                                                                                    .social_icon_ln {
                                                                                        background-image: url("../assets/images/social_icons/set_<?php echo (int)$results->social_set; ?>/linkedin.png");
                                                                                    }
                                                                                    
                                                                                    .social_icon_pr {
                                                                                        background-image: url("../assets/images/social_icons/set_<?php echo (int)$results->social_set; ?>/pinterest.png");
                                                                                    }
                                                                                    
                                                                                    .social_icon_tu {
                                                                                        background-image: url("../assets/images/social_icons/set_<?php echo (int)$results->social_set; ?>/tumblr.png");
                                                                                    }
                                                                                    
                                                                                    .social_icon_tw {
                                                                                        background-image: url("../assets/images/social_icons/set_<?php echo (int)$results->social_set; ?>/twitter.png");
                                                                                    }
                                                                                    
                                                                                    .social_v .social_icon {
                                                                                        display: block !important;
                                                                                    }
                                                                                    
                                                                                    .social_h.pos_left,
                                                                                    .social_h.pos_right,
                                                                                    .social_h.pos_center {
                                                                                        height: 42px !important;
                                                                                        width: auto !important;
                                                                                    }
                                                                                    
                                                                                    .social_h.pos_bottom,
                                                                                    .social_h.pos_top,
                                                                                    .social_h.pos_center {
                                                                                        height: auto !important;
                                                                                        width: 500px !important;
                                                                                    }
                                                                                    
                                                                                    .social_v.pos_left,
                                                                                    .social_v.pos_right,
                                                                                    .social_v.pos_center {
                                                                                        width: 42px !important;
                                                                                    }
                                                                                    
                                                                                    .social_icon {
                                                                                        background-repeat: no-repeat;
                                                                                        background-size: contain;
                                                                                        display: inline-block;
                                                                                        height: 42px;
                                                                                        margin: 2px;
                                                                                        width: 42px;
                                                                                    }
                                                                                    
                                                                                    .social_icon a {
                                                                                        display: block;
                                                                                        height: 42px;
                                                                                        width: 42px;
                                                                                        text-decoration: none;
                                                                                    }
                                                                                    
                                                                                    .social_icon:hover {
                                                                                        opacity: 0.7;
                                                                                    }
                                                                                    
                                                                                    .social_icon a:hover {
                                                                                        text-decoration: none;
                                                                                    }
                                                                                </style>
                                                                                <?php
		
		//url to share
		if(!isset($_GET['post_id']) AND $results->what_to_share == "post")
			$results->what_to_share = "follow";
		if($results->what_to_share == "post")
		{
			$post_id = $_GET['post_id'];
			$temp = get_post( $post_id );
			
			$temp->post_content = strip_shortcodes($temp->post_content);
			$temp->post_excerpt = strip_shortcodes($temp->post_excerpt);
			
			$title =  urlencode($temp->post_title);
			$desc = urlencode((strlen(trim($temp->post_excerpt))>0)?$temp->post_excerpt:$temp->post_content);
			$url = get_permalink($post_id);
			$source = get_bloginfo("url");
			$media = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id));
			$media = $media[0];
			
		}
		if($results->what_to_share == "custom")
		{
			$title = $results->social_text;
			$desc = $results->social_desc;
			$url = $results->social_url;
			$source = "";
			$media = $results->video_play_img;
		}
		if($results->what_to_share == "follow")
		{
			
			$temp = $vop->get_admin_options();
			$social_list = $temp['social_urls'];
			
			foreach ($results->social_networks as $s)
			{
				switch($s)
				{
					case "facebook":
						echo "<div class='social_icon social_icon_fb'>
							<a data='social_click' class='trackClick'  ga='Facebook Follow' href='".$social_list[$s]."' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "googleplus":
						echo "<div class='social_icon social_icon_gp'>
							<a data='social_click' class='trackClick'  ga='Google Plus Follow' href='".$social_list[$s]."' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "linkedin":
						echo "<div class='social_icon social_icon_ln'>
							<a data='social_click' class='trackClick'  ga='LinkedIn Follow'  href='".$social_list[$s]."' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "pinterest":
						echo "<div class='social_icon social_icon_pr'>
							<a data='social_click' class='trackClick' ga='Pinterest Follow' href='".$social_list[$s]."' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "tumblr":
						echo "<div class='social_icon social_icon_tu'>
							<a data='social_click' class='trackClick'  ga='Tumblr Follow'  href='".$social_list[$s]."' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "twitter":
						echo "<div class='social_icon social_icon_tw'>
							<a data='social_click' class='trackClick' ga='Twitter Follow' href='".$social_list[$s]."' target='_blank'>&nbsp;</a>
							</div>";
						break;
					
				}	
			}
		}
		else
		{
		
			foreach ($results->social_networks as $s)
			{
				switch($s)
				{
					case "facebook":
						echo "<div class='social_icon social_icon_fb'>
							<a data='social_click' class='trackClick' ga='Facebook Share' href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "googleplus":
						echo "<div class='social_icon social_icon_gp'>
							<a data='social_click' class='trackClick' ga='Google Plus Share' href='https://plus.google.com/share?url=$url' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "linkedin":
						echo "<div class='social_icon social_icon_ln'>
							<a data='social_click' class='trackClick' ga='LinkedIn Share'  href='https://www.linkedin.com/shareArticle?mini=true&url=$url&title=$title&summary=$desc&source=$source' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "pinterest":
						echo "<div class='social_icon social_icon_pr'>
							<a data='social_click' class='trackClick' ga='Pinterest Share'  href='https://pinterest.com/pin/create/button/?url=$url&media=$media&description=$desc' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "tumblr":
						echo "<div class='social_icon social_icon_tu'>
							<a data='social_click' class='trackClick' ga='Tumblr Share'  href='http://www.tumblr.com/share/link?url=$url&name=$title&description=$desc' target='_blank'>&nbsp;</a>
							</div>";
						break;
					case "twitter":
						echo "<div class='social_icon social_icon_tw'>
							<a data='social_click' class='trackClick' ga='Twitter Share'  href='https://twitter.com/home?status=$url' target='_blank'>&nbsp;</a>
							</div>";
						break;
					
				}	
			}
		}		
	}
	?>
                                                                        </div>
                                                                        <?php } ?>
                </div>

            </div>
        </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                
                <?php if ($results->video_email_time !== "" AND $results->enable_email_optin == 'yes') { ?>
                // Autoresponder
                break_apart_ar();
                // TAKE APART AR CODE
                function break_apart_ar() {
                    var tags = ['a', 'iframe', 'frame', 'frameset', 'script'],
                        reg, val = $('#autoresponderCode').val(),
                        hdn = $('#arcode_hdn_div2'),
                        formurl = $('#arform'),
                        hiddenfields = $('#arhidden');
                    formurl.val('');
                    if (jQuery.trim(val) == '')
                        return false;
                    $('#arcode_hdn_div').html('');
                    $('#arcode_hdn_div2').html('');
                    for (var i = 0; i < 5; i++) {
                        reg = new RegExp('<' + tags[i] + '([^<>+]*[^\/])>.*?</' + tags[i] + '>', "gi");
                        val = val.replace(reg, '');
                        reg = new RegExp('<' + tags[i] + '([^<>+]*)>', "gi");
                        val = val.replace(reg, '');
                    }
                    var tmpval;
                    try {
                        tmpval = decodeURIComponent(val);
                    } catch (err) {
                        tmpval = val;
                    }
                    hdn.append(tmpval);
                    var num = 0;
                    var name_selected = '';
                    var email_selected = '';
                    $(':text', hdn).each(function() {
                        var name = $(this).attr('name'),
                            name_selected = num == '0' ? name : (num != '0' ? name_selected : ''),
                            email_selected = num == '1' ? name : email_selected;
                        if (num == '0') jQuery('#arname').val(name_selected);
                        if (num == '1') jQuery('#aremail').val(email_selected);
                        num++;
                    });
                    jQuery(':input[type=hidden]', hdn).each(function() {
                        jQuery('#arcode_hdn_div').append(jQuery('<input type="hidden" name="' + jQuery(this).attr('name') + '" />').val(jQuery(this).val()));
                    });
                    var hidden_f = jQuery('#arcode_hdn_div').html();
                    formurl.val(jQuery('form', hdn).attr('action'));
                    hiddenfields.val(hidden_f);
                    hdn.html('');
                };
                $('.ARform').attr('action', $('#arform').val());
                $('.ARhidden').html($('#arhidden').val());
                $('#optinEmail').attr('name', $('#aremail').val());
                $('#optinName').attr('name', $('#arname').val());

                //submit AR form in backend
                $('.ARform').submit(function() {
                    $.post("<?php echo $assets; ?>/ar_form.php?id=<?php echo $ID; ?>&name=" + encodeURI($("#optinName").val()) + "&email=" + encodeURI($("#optinEmail").val()) + "&_nounce=<?php echo wp_create_nonce( "
                        vop_click_counter " ); ?><?php echo $split_param; ?>",
                        function(data) {
                            $(".optinpop h3").html("<img src='<?php echo $assets; ?>/../assets/images/up.png'> <?php echo stripslashes($results->video_email_thanks_text); ?>");
                            setTimeout(function() {
                                vop_animate_out(".optinpop", "<?php echo $results->email_end_animation; ?>", <?php echo (int)$results->email_out_animation_time; ?>, "<?php echo $results->email_easing_out; ?>");
                            }, 2000);
                            player.playVideo();
                        });
                    $(".ARform :input").prop("disabled", true);
                    $(".optinpop h3").html("<img src='<?php echo $assets; ?>/../assets/images/wait.gif'> <?php echo stripslashes($results->video_email_wait_text); ?>");

                    if (typeof vop_ga === "function") {
                        vop_ga("Overplay # " + <?php echo $ID; ?>, "Signup", "Email Optin", 1);
                    }


                    return false;
                });

                <?php } ?>
                
                $('.trackClick').click(function(e) {
                    //track click
                    $.post("<?php echo $assets; ?>/clicks.php?id=<?php echo $ID; ?>&data=" + $(this).attr('data') + "&_nounce=<?php echo wp_create_nonce( "vop_click_counter" ); ?><?php echo $split_param; ?>");
                    if (typeof vop_ga === "function") {
                        //vop_ga("Click",$(this).attr('ga'));
                        //vop_ga(category, action, label, value);
                        vop_ga("Overplay # " + <?php echo $ID; ?>, "Click", $(this).attr('ga'), 1);
                    }
                });

                $('div.mainContainer').velocity({
                    opacity: 1
                }, {
                    duration: 1000
                });

            });

            function send_view_click(event) {
                if (window[event] == 0) {
                    $.post("<?php echo $assets; ?>/clicks.php?id=<?php echo $ID; ?>&data=" + event + "&_nounce=<?php echo wp_create_nonce( "vop_click_counter" ); ?><?php echo $split_param; ?>");
                    if (typeof vop_ga === "function") {
                        var view_type = "Unknown Event";
                        switch (event) {
                            case "end_url_view":
                                view_type = "Thumbnail Image";
                                break;
                            case "email_view":
                                view_type = "Email Optin";
                                break;
                            case "social_view":
                                view_type = "Social Media Icons";
                                break;
                            case "ad_banner_view":
                                view_type = "Ad Banner";
                                break;
                            case "cta_view":
                                view_type = "Click To Action";
                                break;
                            case "funnel_view":
                                view_type = "Funnel";
                                break;
                            default:
                                break;
                        }
                        vop_ga("Overplay # " + <?php echo $ID; ?>, "View", view_type, 1);

                    }
                    //alert(event);
                }
            }
        </script>
</body>

</html>
