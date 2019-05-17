<?php
$options       = thrive_get_options_for_post();
$template_name = _thrive_get_item_template( get_the_ID() );
?>

<?php if ( $options['display_breadcrumbs'] && $options['display_breadcrumbs'] == 1 && ! is_front_page() && ! is_search() && ! is_404() ): ?>

	<section class="brd">
		<div class="wrp <?php if ( $template_name == "Narrow" ): ?>bwr<?php endif; ?>">
			<?php if ( _thrive_check_is_woocommerce_page() ): ?>
				<?php woocommerce_breadcrumb(); ?>
			<?php else: ?>
				<ul xmlns:v="http://rdf.data-vocabulary.org/#">
					<?php thrive_breadcrumbs(); ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php else: ?>

<?php endif; ?>

