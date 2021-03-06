<?php
$options = thrive_get_options_for_post( get_the_ID() );

$logo_width_txt  = "";
$logo_height_txt = "";
$logo_pos_class  = ( $options['logo_position'] != "top" ) ? "side_logo" : "center_logo";
if ( $options['logo_width'] <= 200 && $options['logo_height'] <= 100 && $options['logo_width'] != "" && $options['logo_height'] != "" ) {
	$logo_width_txt  = "width='" . $options['logo_width'] . "'";
	$logo_height_txt = "height='" . $options['logo_height'] . "'";
}
$enable_fb_comments = thrive_get_theme_options( "enable_fb_comments" );
$fb_app_id          = thrive_get_theme_options( "fb_app_id" );
$float_menu_attr    = "";
if ( $options['navigation_type'] == "float" || $options['navigation_type'] == "scroll" ) {
	$float_menu_attr = ( $options['navigation_type'] == "float" ) ? " data-float='float-fixed'" : " data-float='float-scroll'";
}
?>
<!DOCTYPE html>
<?php tha_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
	<?php tha_head_top(); ?>
	<title>
		<?php wp_title( '' ); ?>
	</title>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri() ?>/js/html5/dist/html5shiv.js"></script>
	<script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/ie8.css"/>
	<![endif]-->
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/ie7.css"/>
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php thrive_enqueue_head_fonts(); ?>

	<?php wp_head(); ?>
	<?php if ( $options['favicon'] && $options['favicon'] != "" ): ?>
		<link rel="shortcut icon" href="<?php echo $options['favicon']; ?>"/>
	<?php endif; ?>

	<?php if ( isset( $options['analytics_header_script'] ) && $options['analytics_header_script'] != "" ): ?>
		<?php echo $options['analytics_header_script']; ?>
	<?php endif; ?>
	<?php if ( isset( $options['custom_css'] ) && $options['custom_css'] != "" ): ?>
		<style type="text/css"><?php echo $options['custom_css']; ?></style>
	<?php endif; ?>
	<?php tha_head_bottom(); ?>
</head>
<body>
<?php if ( isset( $options['analytics_body_script_top'] ) && ! empty( $options['analytics_body_script_top'] ) ): ?>
	<?php echo $options['analytics_body_script_top']; ?>
<?php endif; ?>
<?php if ( is_single() && $enable_fb_comments != "off" && ! empty( $fb_app_id ) ) : ?>
	<?php include get_template_directory() . '/partials/fb-script.php' ?>
<?php endif; ?>
<?php tha_body_top(); ?>
<div class="flex-cnt">
	<div id="floating_menu">
		<?php tha_header_before(); ?>
		<?php
		$header_type  = get_theme_mod( 'thrivetheme_theme_background' );
		$header_class = '';
		$header_style = '';
		switch ( $header_type ) {
			case 'default-header':
				$header_class = '';
				$header_style = '';
				break;
			case '#customize-control-thrivetheme_background_value':
				$header_class = 'hbc';
				$header_style = 'background-image: none; background-color:' . get_theme_mod( 'thrivetheme_background_value' );
				break;
			case '#customize-control-thrivetheme_header_pattern':
				$header_class = 'hbp';
				if ( get_theme_mod( 'thrivetheme_header_pattern' ) != 'anopattern' ) {
					$header_style = 'background-image:url(' . get_bloginfo( 'template_url' ) . '/images/patterns/' . get_theme_mod( 'thrivetheme_header_pattern' ) . '.png);';
				}
				break;
			case '#customize-control-thrivetheme_header_background_image, #customize-control-thrivetheme_header_image_type, #customize-control-thrivetheme_header_image_height':
				switch ( get_theme_mod( 'thrivetheme_header_image_type' ) ) {
					case 'full':
						$header_class = 'hif';
						$header_style = 'background-image:url(' . get_theme_mod( 'thrivetheme_header_background_image' ) . '); height:' . get_theme_mod( 'thrivetheme_header_image_height' ) . 'px;';
						break;
					case 'centered':
						$header_class = 'hic';
						$header_style = 'background-image:url(' . get_theme_mod( 'thrivetheme_header_background_image' ) . ');';
						break;
				}
				break;
		}
		?>
		<header class="<?php echo $header_class; ?>" style="<?php echo $header_style; ?>">
			<?php tha_header_top(); ?>
			<?php if ( $header_class == "hic" ): ?>
				<img class="tt-dmy" src="<?php echo get_theme_mod( 'thrivetheme_header_background_image' ); ?>"/>
			<?php endif; ?>
			<div class="wrp <?php echo $logo_pos_class; ?>" id="head_wrp">
				<div class="h-i">
					<?php
					$thrive_logo = false;
					if ( $options['logo_type'] == "text" ):
						if ( get_theme_mod( 'thrivetheme_header_logo' ) != 'hide' ):
							?>
							<div id="text_logo"
							     class="<?php if ( $options['logo_color'] == "default" ): ?><?php echo $options['color_scheme'] ?><?php else: ?><?php echo $options['logo_color'] ?><?php endif; ?> ">
								<a href="<?php echo home_url( '/' ); ?>"><?php echo $options['logo_text']; ?></a>
							</div>

							<?php
						endif;
					elseif ( $options['logo'] && $options['logo'] != "" ):
						$thrive_logo = true;
						if ( get_theme_mod( 'thrivetheme_header_logo' ) != 'hide' ):
							?>
							<div id="logo" class="lg left">
								<a href="<?php echo home_url( '/' ); ?>">
									<img src="<?php echo $options['logo']; ?>"
									     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"/>
								</a>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<div class="hmn">
						<div class="awe rmn right">&#xf039;</div>
						<div class="clear"></div>
					</div>

					<div class="clear"></div>
				</div>
			</div>
			<?php tha_header_bottom(); ?>
		</header>
		<?php tha_header_after(); ?>
	</div>
	<div class="bspr"></div>
	<?php
	if ( thrive_check_top_focus_area() ):
		thrive_render_top_focus_area();
	endif;
	?>

	<?php tha_content_before(); ?>

	<?php tha_content_top(); ?>
	<!--Start the wrapper for all the content-->
	<div class="wrp cnt">
