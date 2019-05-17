<?php

/**

 * childgenesis Child Theme Settings 

 * 

 * @package    childgenesis Child Theme

 * @subpackage Admin

 * @author     childgenesis Developer

 * @version    1.0

 * @link       http://www.childgenesis.com/

 */



/**

 * childgenesis Childtheme Settings Class

 * 

 * @since 1.0

 */

class ChildGenesis_Childtheme_Settings extends Genesis_Admin_Boxes {



	/**

	 * ChildGenesis_Childtheme_Settings Constructor

	 */

	function __construct() {



		$page_id = 'childgenesis-settings';



		$menu_ops = array(

			'submenu' => array(

				'parent_slug' => 'genesis',

				'page_title'  => __( 'Genesis Child  Theme Settings', 'childgenesis' ),

				'menu_title'  => __( 'Genesis Child  Settings', 'childgenesis' )

			)

		);



		$page_ops = array(

			'screen_icon'       => 'options-general',

			'save_button_text'  => __( 'Save Settings', 'genesis' ),

			'reset_button_text' => __( 'Reset Settings', 'genesis' ),

			'saved_notice_text' => __( 'Settings saved.', 'genesis' ),

			'reset_notice_text' => __( 'Settings reset.', 'genesis' ),

			'error_notice_text' => __( 'Error saving settings.', 'genesis' ),

		);



		$settings_field = GA_CHILDTHEME_FIELD;



		$default_settings = array(

			'logo_url'                      => '',

			'logo_width'                    => '',

			'logo_height'                   => '',

			'facebook_url'                  => '',

			'twitter_url'                   => '',

			'linkedin_url'                  => '',

			'googleplus_url'                => '',

			'youtube_url'                   => '',
			
			'rss_url'                   => '',

			
		);



		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );



		add_action( 'genesis_settings_sanitizer_init', array( $this, 'childgenesis_childtheme_filters' ) );



		//add_action( 'admin_init', array( $this, 'ga_load_scripts' ) );



	}



	/**

	 * Options Filters for  Scavone

	 * 

	 * @return null

	 */

	public function childgenesis_childtheme_filters() {



		genesis_add_option_filter(

			'one_zero',

			$this->settings_field,

			array(

				'enable_homepage_slider',

				
			)

		);



		genesis_add_option_filter(

			'no_html',

			$this->settings_field,

			array(

				'logo_url',

				'facebook_url',

				'twitter_url',

				'linkedin_url',

				'googleplus_url',

				'youtube_url',
				
				'rss_url',

				

			)

		);



		genesis_add_option_filter(

			'requires_unfiltered_html',

			$this->settings_field,

			array(



			)

		);



		genesis_add_option_filter(

			'email',

			$this->settings_field,

			array(

				'contact_email'

			)

		);



		genesis_add_option_filter(

			'integer',

			$this->settings_field,

			array(

				'logo_width',

				'logo_height',
			)

		);



	}



	/**

	 * Register Metaboxes

	 * 

	 * Registers the metaboxes for ChildGenesis Child Theme Options page.

	 * 

	 * @return null

	 */

	function metaboxes() {




		add_meta_box( 'childgenesis-general-settings', __( 'General Settings', 'childgenesis' ), array( $this, 'general_settings' ), $this->pagehook, 'main', 'high' );

		add_meta_box( 'childgenesis-social-settings', __( 'Social Settings', 'childgenesis' ), array( $this, 'social_settings' ), $this->pagehook, 'main', 'high' );

		add_meta_box( 'childgenesis-box-settings', __( 'Homepage Boxes Settings', 'childgenesis' ), array( $this, 'homepage_box_settings' ), $this->pagehook, 'main', 'high' );




	}



	/**

	 * Child Theme Information 

	 * 

	 * @return null

	 */

	



	/**

	 * General Settings Box

	 * 

	 * @return null 

	 */

	function general_settings() {



		?>

		<table class="form-table">

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'logo_url' ); ?>"><?php _e( 'Custom Logo URL', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'logo_url' ); ?>" id="<?php echo $this->get_field_id( 'logo_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'logo_url' ) ); ?>" class="widefat" /></td>

			</tr>

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'logo_width' ); ?>"><?php _e( 'Logo Width', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'logo_width' ); ?>" id="<?php echo $this->get_field_id( 'logo_width' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'logo_width' ) ); ?>" size="4" /> px</td>

			</tr>

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'logo_height' ); ?>"><?php _e( 'Logo Height', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'logo_height' ); ?>" id="<?php echo $this->get_field_id( 'logo_height' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'logo_height' ) ); ?>" size="4" /> px</td>

			</tr>

			

			

			

		</table>

		<?php



	}



	/**

	 * Social Settings Box

	 * @return null

	 */

	function social_settings() {



		?>

		<table class="form-table">

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook URL', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'facebook_url' ) ); ?>" class="widefat" /></td>

			</tr>

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter URL', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'twitter_url' ) ); ?>" class="widefat" /></td>

			</tr>

			

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"><?php _e( 'Linkedin URL', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'linkedin_url' ) ); ?>" class="widefat" /></td>

			</tr>

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'googleplus_url' ); ?>"><?php _e( 'Google Plus URL', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'googleplus_url' ); ?>" id="<?php echo $this->get_field_id( 'googleplus_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'googleplus_url' ) ); ?>" class="widefat" /></td>

			</tr>

			

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e( 'Youtube URL', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'youtube_url' ) ); ?>" class="widefat" /></td>

			</tr>
            
            <tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'rss_url' ); ?>"><?php _e( 'Rss URL', 'childgenesis' ) ?></label></th>

				<td><input type="text" name="<?php echo $this->get_field_name( 'rss_url' ); ?>" id="<?php echo $this->get_field_id( 'rss_url' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'rss_url' ) ); ?>" class="widefat" /></td>

			</tr>

		

		</table>

		

		<?php



	}



	/**

	 * Home page Box settings 

	 * 

	 * @return null

	 */

	function homepage_box_settings() {



		?>

		<table class="form-table">

			<tr valign="top">

				<th scope="row"><label for="<?php echo $this->get_field_id( 'homepage_box_number1' ); ?>"><?php _e( 'Select Page for Box 1 in Home Page', 'childgenesis' ) ?></label></th>

				<td>
                <?php $value1=genesis_get_option( 'homepage_box_number1', GA_CHILDTHEME_FIELD );?>
                <select name="<?php echo $this->get_field_name( 'homepage_box_number1' ); ?>" id="<?php echo $this->get_field_id( 'homepage_box_number1' ); ?>">
                <option value="">Select a page :</option>
               <?php $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
			   foreach($options_pages_obj as $page){
			   ?> 
               <option value="<?php echo $page->ID;?>" <?php if($value1==$page->ID){?> selected="selected"<?php } ?>><?php echo $page->post_title;?></option>
                <?php } ?>
                </select></td>

			</tr>

           
		</table>

		

		<?php



	}



	
	

}