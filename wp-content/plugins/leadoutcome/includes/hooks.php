<?php
/*
 * 2.0 hooks
 */
add_action('init','lo_initialize');
add_action('wp_enqueue_scripts', 'lo_init_scripts');
add_action('admin_enqueue_scripts', 'lo_init_scripts');
add_action( 'post_edit_form_tag' , 'lo_post_edit_form_tag' );
add_action( 'save_post', 'lo_save_post' );

add_action('admin_menu','lo_admin_menu');
//add_action( 'user_register', 'lo_user_register', 20, 1 );

// Used for tracking page visits
add_action( 'wp_footer', 'lo_wp_footer' );
//add_action('wp_logout', 'lo_logout'); 
add_action('edit_user_profile_update', 'lo_edit_user_profile_update');
add_action('personal_options_update', 'lo_edit_user_profile_update');

// Used for autologin into LO
add_action('wp_login', 'lo_login', 10, 2);

// leni here - action had wrong syntax - action, function, 1, 100 - priority was too low and number of parameters too high
add_action('woocommerce_payment_complete', 'lo_order_complete', 99);

// for dev
//add_action('woocommerce_payment_complete', 'lo_order_complete', 1);

// leni here - disable to avoid problems - this hook doesnt work and we are already handling the api key update on the new site
//add_action( 'blog_templates-copy-after_copying', 'lo_after_template_copy', 10, 2 );

// Used to fetch lead personilization fields.
add_shortcode( 'lead_field', 'lo_fetch_lead_field' );

// Used to fetch member personilization fields.
add_shortcode( 'member_field', 'lo_fetch_member_field' );

// Used to fetch lead personilization fields.
add_shortcode( 'video_smart_pixel', 'lo_video_smart_pixel' );


if(!is_admin())
{
	add_shortcode('leadoutcome_optin_form', 'lo_optin_form_shortcode');
}

//include_once('leadoutcome_widget.php');
//add_action('widgets_init', create_function('', 'return register_widget("LeadOutcomeSidebarWidget");'));
