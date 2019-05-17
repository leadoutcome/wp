<?php
$options       = thrive_get_options_for_post( get_the_ID(), array( 'apprentice' => 1 ) );
$post_template = _thrive_get_item_template( get_the_ID() );
$style_options = _thrive_get_header_style_options( $options );
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

<?php _thrive_render_top_fb_script(); ?>

<?php tha_body_top(); ?>

<?php tha_header_before(); ?>

<div class="h-b <?php echo $style_options['header_container_class']; ?>"
     style="<?php echo $style_options['header_container_style']; ?>">
	<div class="c-ti" style="<?php echo $style_options['header_overlay_style']; ?>">
	</div>
	<div class="h-bi">
		<div id="floating_menu" <?php echo $style_options['float_menu_attr']; ?>>
			<header
				class="<?php echo $style_options['logo_pos_class']; ?> <?php echo $style_options['header_class']; ?>"
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
										<a href="<?php echo _thrive_appr_get_lessons_root_url(); ?>"><?php echo $options['logo_text']; ?></a>
									</div>
								<?php endif; ?>
							<?php elseif ( $options['logo'] && $options['logo'] != "" ): $thrive_logo = true; ?>
								<div id="logo">
									<a href="<?php echo _thrive_appr_get_lessons_root_url(); ?>"><img
											src="<?php echo $options['logo']; ?>" class="l-d"
											alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
									<a href="<?php echo _thrive_appr_get_lessons_root_url(); ?>"><img
											src="<?php echo $options['logo_dark']; ?>" class="l-l"
											alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
								</div>
								<?php
							endif;
						endif;
						?>

						<div class="hsm"
						     <?php if ( $post_template == "Landing Page" ): ?>style="display:none;"<?php endif; ?>>
							<span><?php _e( 'Menu', 'thrive' ); ?></span>
						</div>
						<div class="m-s"
						     <?php if ( $post_template == "Landing Page" ): ?>style="display:none;"<?php endif; ?>>
							<div class="m-si">
								<?php if ( has_nav_menu( "apprentice" ) ): ?>
									<?php wp_nav_menu( array(
										'container'      => 'nav',
										'depth'          => 0,
										'theme_location' => 'apprentice',
										'menu_class'     => 'menu',
										'walker'         => new thrive_custom_menu_walker()
									) ); ?>
								<?php else: ?>
									<div class="dfm">
										<?php _e( "Assign an 'apprentice' menu", 'thrive' ); ?>
									</div>
								<?php endif; ?>
								<div class="s-b clearfix">
									<form action="<?php echo _thrive_appr_get_lessons_root_url(); ?>" method="get">
										<label for="search"><?php _e( "SEARCH", 'thrive' ); ?>: </label>
										<input type="text" name="s" id="search"/>

										<div class="clear"></div>
									</form>
									<span class="s-bb"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
		</div>
	</div>

	<?php if ( is_archive() || is_category() || is_author() || is_search() || ! is_tag() ): ?>
		<div class="b-tt <?php echo $style_options['title_color_class']; ?>">
			<div class="wrp">
				<?php get_template_part( "appr/header-title" ); ?>
			</div>
		</div>
	<?php endif; ?>

</div>

<?php tha_content_before(); ?>

<?php tha_content_top(); ?>
