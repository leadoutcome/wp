<?php

function _thrive_get_page_template_privacy() {
	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/privacy.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_disclaimer() {

	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/disclaimer.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_lead_gen( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_email_confirmation() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/email_confirmation.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_video_lead_gen( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/video_lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_homepage1( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/homepage1.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_homepage2() {
	$images_dir = get_template_directory_uri() . "/images/templates";
	$content    = "<h1>This is Your Big, <span style='color: #4174dc;'><strong>Bold Headline</strong></span>
to Grab Attention.</h1>
[page_section image='" . $images_dir . "/urban_building.jpg' textstyle='light' position='default' padding_bottom='on' padding_top='on' img_static='on']
<p style='text-align: right; margin-bottom: 12em;'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non euismod elit, et tempor augue.</p>
[/page_section]
<h3 style='text-align: center;'>Lorem Ipsum Dolor Sit Amet</h3>
<p style='text-align: center;'>Mauris venenatis ac nulla nec pharetra. Nam interdum lectus diam, ac pulvinar velit vehicula ut. Duis a vulputate tellus. Sed mattis justo diam, non vehicula orci auctor rutrum.</p>
[divider style='dark']

[one_third_first]<img class='aligncenter size-full wp-image-433' alt='icon1b' src='" . $images_dir . "/icon1b.png' width='78' height='68' />
<h4 style='text-align: center;'>Lorem Ipsum</h4>
<p style='text-align: center;'>Praesent tortor nibh, faucibus at purus nec, tincidunt condimentum ligula. Sed lobortis laoreet lorem, nec fermentum enim suscipit non.</p>
<p style='text-align: center;'>[/one_third_first][one_third]<img class='aligncenter size-full wp-image-434' alt='icon2b' src='" . $images_dir . "/icon2b.png' width='78' height='68' /></p>

<h4 style='text-align: center;'>Dolor Sit Amet</h4>
<p style='text-align: center;'>Phasellus est lacus, congue sodales urna tristique, vehicula vulputate ligula. Phasellus leo dui, adipiscing eu mollis sed, rhoncus vel sapien.</p>
[/one_third][one_third_last]<img class='aligncenter size-full wp-image-435' alt='icon3b' src='" . $images_dir . "/icon3b.png' width='78' height='68' />
<h4 style='text-align: center;'>Consectetur Adipiscing</h4>
<p style='text-align: center;'>Mauris venenatis ac nulla nec pharetra. Nam interdum lectus diam, ac pulvinar velit vehicula ut. Duis a vulputate tellus. Sed mattis justo diam.</p>
[/one_third_last]

[page_section color='#ededed' textstyle='dark' position='default' padding_top='on']
<h2 style='text-align: center;'>Our Recent Contributions</h2>
[thrive_posts_gallery title='' no_posts='4' filter='recent']

[/page_section][page_section image='" . $images_dir . "/urban_building.jpg' textstyle='light' position='default' padding_bottom='on' img_static='on']
<h2 style='text-align: center;'>Our Clients</h2>
[one_third_first]<img class='aligncenter size-full wp-image-438' alt='fastforward-white-2' src='" . $images_dir . "/fastforward-white-2.png' width='400' height='140' />[/one_third_first][one_third]<img class='aligncenter size-full wp-image-440' alt='morning-star-white-2' src='" . $images_dir . "/morning-star-white-2.png' width='400' height='140' />[/one_third][one_third_last]<img class='aligncenter size-full wp-image-441' alt='wastingtime-white-2' src='" . $images_dir . "/wastingtime-white-2.png' width='400' height='140' />[/one_third_last]

&nbsp;

[/page_section]
<h3 style='text-align: center;'>Praesent at Leo Pellentesque</h3>
<p style='text-align: center;'>Cras interdum et justo sed posuere. In hac habitasse platea dictumst. Quisque pharetra, purus quis viverra aliquet, sem libero congue lectus, nec consequat justo mi tempus felis. Curabitur ut tempor augue. Phasellus venenatis venenatis pellentesque. Aliquam erat volutpat.</p>
[thrive_link color='blue' link='#' target='_self' size='medium' align='aligncenter']Get a Quote[/thrive_link]

[page_section color='#ededed' textstyle='dark' position='bottom' padding_top='on'][thrive_follow_me facebook='http://facebook.com/imimpact' twitter='shanerqr' linkedin='555'][/page_section]";

	return $content;
}

function _thrive_get_page_template_sales() {
	$images_dir = get_template_directory_uri() . "/images/templates";
	$content    = "";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/sales.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_thank_you_dld() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-theme/thank_you_dld.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_privacy() {
	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/privacy.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_disclaimer() {

	$options = array(
		'website' => thrive_get_theme_options( 'privacy_tpl_website' ),
		'company' => thrive_get_theme_options( 'privacy_tpl_company' ),
		'contact' => thrive_get_theme_options( 'privacy_tpl_contact' ),
		'address' => thrive_get_theme_options( 'privacy_tpl_address' ),
	);

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/disclaimer.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_lead_gen( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_email_confirmation() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/email_confirmation.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_video_lead_gen( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/video_lead_gen.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_homepage1( $optin_id = 0 ) {

	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/homepage1.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_homepage2( $optin_id = 0 ) {
	$images_dir = get_template_directory_uri() . "/images/templates";
	$content    = "";

	return $content;
}

function _thrive_get_page_template_tcb_homepage3( $optin_id = 0 ) {

	$images_dir = get_template_directory_uri() . "/images/templates";
	$content    = "";

	return $content;
}

function _thrive_get_page_template_tcb_sales() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/sales.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function _thrive_get_page_template_tcb_thank_you_dld() {
	$images_dir = get_template_directory_uri() . "/images/templates";

	ob_start();
	include plugin_dir_path( __FILE__ ) . 'tpl-tcb/thank_you_dld.php';
	$content = ob_get_contents();
	ob_end_clean();


	return $content;
}

function _thrive_get_lorem_ipsum_post_content() {
	$content = "";

	return $content;
}