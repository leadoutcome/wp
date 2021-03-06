<div id="<?php echo $unique_id; ?>" class="tvo-testimonials-display tvo-testimonials-display-single tvo-set12-template tve_teal">
	<?php foreach ( $testimonials as $testimonial ) : ?>
		<?php if ( ! empty( $testimonial ) ) : ?>
			<div class="tvo-testimonial-display-item tvo-apply-background">
				<div class="tvo-item-grid">
					<div class="tvo-image-wrapper">
						<div class="tvo-testimonial-image-cover tvo-testimonial-real-border" style="background-image: url(<?php echo $testimonial['picture_url'] ?>)">
							<img src="<?php echo $testimonial['picture_url'] ?>"
							     class="tvo-testimonial-image tvo-dummy-image">
						</div>
					</div>
					<div class="tvo-testimonial-content tvo-relative">
						<div class="tvo-testimonial-quote tvo-info-special-bg">&#x0201C;</div>
						<?php if ( ! empty( $config['show_title'] ) ) : ?>
							<h4>
								<?php echo $testimonial['title'] ?>
							</h4>
						<?php endif; ?>
						<p>
							<?php echo $testimonial['content'] ?>
						</p>
						<div class="tvo-testimonial-info">
							<svg height="11" width="100%" viewbox="0 0 1000 11" preserveAspectRatio="none" class="tvo-separator-svg-stroke">
								<polyline points="0,0 70,0 84,11 98,0 1000 0"></polyline>
							</svg>
							<span class="tvo-testimonial-name">
								<?php echo $testimonial['name'] ?>
							</span>
							<?php if ( ! empty( $config['show_role'] ) ) : ?>
								<span class="tvo-testimonial-role">
								<?php $role_wrap_before = empty( $config['show_site'] ) || empty( $testimonial['website_url'] ) ? '' : '<a href="' . $testimonial['website_url'] . '">';
								$role_wrap_after        = empty( $config['show_site'] ) || empty( $testimonial['website_url'] ) ? '' : '</a>';
								echo $role_wrap_before . $testimonial['role'] . $role_wrap_after; ?>
							</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach ?>
</div>

