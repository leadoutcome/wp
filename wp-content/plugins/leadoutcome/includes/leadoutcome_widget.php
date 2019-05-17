<?php
/**
* LeadOutcomeSidebarWidget Class
*/
class LeadOutcomeSidebarWidget extends WP_Widget
{
	/** constructor */
	function LeadOutcomeSidebarWidget() {
		//parent::WP_Widget(false, $name = __('LeadOutcome Opt-in Form Widget','lo'));
		parent::__construct(false, 
				__('LeadOutcome Opt-in Form Widget','lo'));
		
		
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		global $wpdb;

		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$lo_form_id = $instance['form_id'];
		$lo_form_type = $instance['form_type'];

		$form_data = $wpdb->get_row($wpdb->prepare("SELECT `".$wpdb->escape($instance['form_type'])."` FROM `".$wpdb->prefix . "lo_optin_forms` WHERE `id`=%d AND `blog_id`=".get_current_blog_id(),$lo_form_id));

		echo $before_widget;

		if ( $title )
		{
			echo $before_title . $title . $after_title;
		}
		echo stripslashes($form_data->{$instance['form_type']});
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = esc_html($new_instance['title']);
		$instance['form_id'] = esc_attr($new_instance['form_id']);
		$instance['form_type'] = esc_attr($new_instance['form_type']);

		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance)
	{
		global $wpdb;

		$instance = wp_parse_args( (array) $instance, array('title'=>'Opt-In Form', 'form_id' => 1, 'form_type' => 'full_form_content') );

		$title = esc_html($instance['title']);
		$form_id = esc_attr($instance['form_id']);
		$form_type = esc_attr($instance['form_type']);

		$optinforms = $wpdb->get_results($wpdb->prepare("SELECT * FROM `".$wpdb->prefix . "lo_optin_forms` WHERE `blog_id`=".get_current_blog_id()));

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><strong><?php _e('Title:','lo'); ?></strong></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />

			<label for="<?php echo $this->get_field_id('form_id'); ?>"><strong><?php _e('Form:','lo'); ?></strong></label>
			<select class="widefat" name="<?php echo $this->get_field_name('form_id'); ?>" id="<?php echo $this->get_field_id('form_id'); ?>">
			<?php
			foreach ( $optinforms as $optinform ) 
			{
			?>
				<option class="widefat" value="<?php echo $optinform->id; ?>" <?php selected($instance['form_id'], $optinform->id); ?>><?php echo $optinform->form_name; ?></option>
			<?php
			}
			?>
			</select>
			<label for="<?php echo $this->get_field_id('form_type'); ?>"><strong><?php _e('Form Type:','lo'); ?></strong></label>
			<select class="widefat" name="<?php echo $this->get_field_name('form_type'); ?>" id="<?php echo $this->get_field_id('form_type'); ?>">
				<option class="widefat" value="full_form_content" <?php selected( $instance['form_type'],'full_form_content' ); ?>><?php echo __('Full Opt In Form','lo'); ?></option>
				<option class="widefat" value="email_only_form_content" <?php selected( $instance['form_type'],'email_only_form_content' ); ?>><?php echo __('Only Email Field','lo'); ?></option>
				<option class="widefat" value="subscribe_only_form_content" <?php selected( $instance['form_type'],'subscribe_only_form_content' ); ?>><?php echo __('Subscribe Button','lo'); ?></option>
			</select>
		</p>
	<?php 
	}

} // class LeadOutcomeSidebarWidget
