<?php
class EWD_UFAQ_Display_FAQ_Post_List extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_ufaq_display_faq_post_list', // Base ID
			__('UFAQ FAQ ID List', 'EWD_UFAQ'), // Name
			array( 'description' => __( 'Insert FAQ posts using a comma-separated list of post IDs', 'EWD_UFAQ' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo do_shortcode("[select-faq faq_id='". $instance['faq_id'] . "' no_comments='Yes']");
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$faq_id = ! empty( $instance['faq_id'] ) ? $instance['faq_id'] : __( 'FAQ ID List', 'EWD_UFAQ' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'faq_id' ); ?>"><?php _e( 'FAQ ID List:', 'EWD_UFAQ' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'faq_id' ); ?>" name="<?php echo $this->get_field_name( 'faq_id' ); ?>" type="text" value="<?php echo esc_attr( $faq_id ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['faq_id'] = ( ! empty( $new_instance['faq_id'] ) ) ? strip_tags( $new_instance['faq_id'] ) : '';

		return $instance;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("EWD_UFAQ_Display_FAQ_Post_List");'));

class EWD_UFAQ_Display_Recent_FAQS extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_ufaq_display_recent_faqs', // Base ID
			__('Recent FAQs', 'EWD_UFAQ'), // Name
			array( 'description' => __( 'Insert a number of the most recent FAQs', 'EWD_UFAQ' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo do_shortcode("[recent-faqs post_count='". $instance['post_count'] . "' no_comments='Yes']");
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : __( 'Number of FAQs', 'EWD_UFAQ' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e( 'Number of FAQs:', 'EWD_UFAQ' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="text" value="<?php echo esc_attr( $post_count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['post_count'] = ( ! empty( $new_instance['post_count'] ) ) ? strip_tags( $new_instance['post_count'] ) : '';

		return $instance;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("EWD_UFAQ_Display_Recent_FAQS");'));

class EWD_UFAQ_Display_Popular_FAQS extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_ufaq_display_popular_faqs', // Base ID
			__('Popular FAQs', 'EWD_UFAQ'), // Name
			array( 'description' => __( 'Insert a number of the most popular FAQs', 'EWD_UFAQ' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo do_shortcode("[popular-faqs post_count='". $instance['post_count'] . "' no_comments='Yes']");
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : __( 'Number of FAQs', 'EWD_UFAQ' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e( 'Number of FAQs:', 'EWD_UFAQ' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="text" value="<?php echo esc_attr( $post_count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['post_count'] = ( ! empty( $new_instance['post_count'] ) ) ? strip_tags( $new_instance['post_count'] ) : '';

		return $instance;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("EWD_UFAQ_Display_Popular_FAQS");'));

class EWD_UFAQ_Display_FAQ_Categories extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_ufaq_display_faq_categories', // Base ID
			__('UFAQ FAQ Category List', 'EWD_UFAQ'), // Name
			array( 'description' => __( 'Insert FAQ posts using a comma-separated list of categories', 'EWD_UFAQ' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo do_shortcode("[ultimate-faqs include_category='". $instance['include_category'] . "' no_comments='Yes']");
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$include_category = ! empty( $instance['include_category'] ) ? $instance['include_category'] : __( 'FAQ Category List', 'EWD_UFAQ' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'include_category' ); ?>"><?php _e( 'FAQ Category List:', 'EWD_UFAQ' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'include_category' ); ?>" name="<?php echo $this->get_field_name( 'include_category' ); ?>" type="text" value="<?php echo esc_attr( $include_category ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['include_category'] = ( ! empty( $new_instance['include_category'] ) ) ? strip_tags( $new_instance['include_category'] ) : '';

		return $instance;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("EWD_UFAQ_Display_FAQ_Categories");'));

?>