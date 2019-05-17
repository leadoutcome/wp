<?php
$options       = thrive_appr_get_theme_options();
$sidebar_class = ( $options['sidebar_alignement'] == "right" || $options['sidebar_alignement'] == "left" ) ? $options['sidebar_alignement'] : "";
?>
<?php tha_sidebars_before(); ?>
	<div class="sAsCont">
		<?php tha_sidebar_top(); ?>
		<aside class="sAs <?php echo $sidebar_class; ?>">
			<?php if ( ! dynamic_sidebar( 'sidebar-appr' ) ) : ?>
				<!--IF THE MAIN SIDEBAR IS NOT REGISTERED-->
			<?php endif; // end page sidebar widget area  ?>
		</aside>
		<?php tha_sidebar_bottom(); ?>
	</div>
<?php tha_sidebars_after(); ?>