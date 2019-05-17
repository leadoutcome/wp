<?php
$options       = thrive_get_options_for_post( get_the_ID() );
$post_template = _thrive_get_item_template( get_the_ID() );
$style_options = _thrive_get_header_style_options( $options );

//just because the appr-landing-page template includes this fucking template
if ( in_array( get_post_type(), array( TT_APPR_POST_TYPE_LESSON, TT_APPR_POST_TYPE_PAGE ) ) ) {
	$appr_options         = thrive_appr_get_theme_options();
	$options['logo']      = $appr_options['logo'];
	$options['logo_dark'] = $appr_options['logo'];
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

	<?php if ( $options['favicon'] && ! empty( $options['favicon'] ) ): ?>
		<link rel="shortcut icon" href="<?php echo $options['favicon']; ?>"/>
	<?php endif; ?>

	<?php if ( isset( $options['analytics_header_script'] ) && ! empty( $options['analytics_header_script'] ) ): ?>
		<?php echo $options['analytics_header_script']; ?>
	<?php endif; ?>

	<?php thrive_enqueue_head_fonts(); ?>
	<?php wp_head(); ?>
	<?php if ( isset( $options['custom_css'] ) && $options['custom_css'] != "" ): ?>
		<style type="text/css"><?php echo $options['custom_css']; ?></style>
	<?php endif; ?>
	<?php tha_head_bottom(); ?>

</head>
<body <?php body_class() ?>>
<?php if ( isset( $options['analytics_body_script_top'] ) && ! empty( $options['analytics_body_script_top'] ) ): ?>
	<?php echo $options['analytics_body_script_top']; ?>
<?php endif; ?>
<?php _thrive_render_top_fb_script(); ?>

<?php tha_body_top(); ?>

<?php tha_header_before(); ?>

<?php unset( $GLOBALS['thrive_post_excerpts'] ); /* clear out any content that would have been generated for the <head> meta tags */ ?>

<div class="h-b l-h <?php echo $style_options['header_container_class']; ?> "
     style="<?php echo $style_options['header_container_style']; ?>">
	<div class="c-ti" style="<?php echo $style_options['header_overlay_style']; ?>">
	</div>
	<div class="h-bi">
		<div id="floating_menu" <?php echo $style_options['float_menu_attr']; ?>>
			<header class="center <?php echo $style_options['header_class']; ?>"
			        style="<?php echo $style_options['header_style']; ?>">
				<?php if ( $style_options['header_class'] == "hic" ): ?>
					<img class="tt-dmy" src="<?php echo get_theme_mod( 'thrivetheme_header_background_image' ); ?>"/>
				<?php endif; ?>
				<div class="h-i">
					<div class="wrp">
						<?php
						if ( get_theme_mod( 'thrivetheme_header_logo' ) != 'hide' ):
							$thrive_logo = false;
							if ( $options['logo_type'] == "text" ):
								if ( get_theme_mod( 'thrivetheme_header_logo' ) != 'hide' ):
									?>
									<div id="text-logo"
									     class="<?php if ( $options['logo_color'] == "default" ): ?><?php echo $options['color_scheme'] ?><?php else: ?><?php echo $options['logo_color'] ?><?php endif; ?> ">
										<a href="<?php echo home_url( '/' ); ?>"><?php echo $options['logo_text']; ?></a>
									</div>
								<?php endif; ?>
							<?php elseif ( $options['logo'] && $options['logo'] != "" ): $thrive_logo = true; ?>
								<div id="logo">
									<a href="<?php echo home_url( '/' ); ?>">
										<img src="<?php echo $options['logo']; ?>" class="l-d"
										     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
									<a href="<?php echo home_url( '/' ); ?>">
										<img src="<?php echo $options['logo_dark']; ?>" class="l-l"
										     alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
								</div>
								<?php
							endif;
						endif;
						?>
					</div>
				</div>
			</header>
		</div>
	</div>

	<?php if ( is_archive() || is_category() || is_author() || is_search() || ! is_tag() ): ?>
		<div class="b-tt <?php echo $style_options['title_color_class']; ?>">
			<div class="wrp">
				<?php get_template_part( "partials/header-title" ); ?>
			</div>
		</div>
	<?php endif; ?>

</div>

<?php tha_content_before(); ?>

<?php tha_content_top(); ?>
