<?php

/**

 * Child Genesis Theme functions

 * 

 * Child Theme functions for Genesis by Scavone

 * 

 * @package Genesis Child Theme

 * @author  childgenesis Developer

 * @version 1.0

 * @link    http://www.childgenesis.com/

 */

/**

 * childgenesis Constents

 * 

 * @since 1.0

 */

add_action( 'genesis_after_loop', 'after_content' );
function after_content() {
?><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widgets2') ) : ?>
      <?php endif; ?> <?php
}


if (function_exists('register_sidebar')) {
     register_sidebar(array(
      'name' => 'Sidebar Widgets2',
      'id'   => 'sidebar-widgets2',
      'description'   => 'Widget Area',
      'before_widget' => '<div id="one" class="two">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2>',
      'after_title'   => '</h2>'
     ));
    }
    
define( 'CHILD_THEME_NAME', 'childgenesis' );

define( 'CHILD_THEME_URL', 'http://www.childgenesis.com/' );

define( 'CHILD_THEME_VER', '1.2' );

define( 'GA_CHILDTHEME_FIELD', 'childgenesis_dedicated_settings' );

add_action( 'genesis_init', 'childgenesis_childtheme_init', 20 );

/**

* childgenesis Child Theme init

 * 

 * @since 1.0

 * 

 * @return null

 */

function childgenesis_childtheme_init() {

	/* Load HTML5 for Genesis Child Theme */

	require_once( CHILD_DIR . '/lib/childgenesis-html5.php' );

	/* Load GenesisAwesome Settings Page class */

	require_once( CHILD_DIR . '/lib/childgenesis-settings.php' );

	/* Load GenesisAwesome Flexslider */

	require_once( CHILD_DIR . '/lib/childgenesis-slider.php' );

	/* Load Genesis Awesome Widgets */

	require_once( CHILD_DIR . '/lib/widgets/widget-facebook-likebox.php' );

	require_once( CHILD_DIR . '/lib/widgets/widget-flickr.php' );

	/* Add GenesisAwesome Theme supports */

	add_theme_support( 'genesis-footer-widgets', 4 );

	add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation', 'childgenesis' ), 'footernav' => __( 'Footer Navigation Links', 'childgenesis' ) ) );

	/* Register new Image sizes */

	add_image_size( 'childgenesis-slider-image', 980, 350, true );

	add_image_size( 'childgenesis-post-image', 630, 220, true );

	/* Load Parent Theme Stylesheet */

	add_action( 'genesis_meta', 'childgenesis_parent_stylesheet', 0 );

	/* Header Right Content. Social Icons and Search */

	add_action( 'genesis_header_right', 'childgenesis_do_header_right' );

	/* Load Styles and Stykes for Genesis Child Theme */

	add_action( 'wp_enqueue_styles', 'childgenesis_childtheme_styles' );

	add_action( 'wp_enqueue_scripts', 'childgenesis_childtheme_scripts' );

	/* Load inline Styles and Scripts for Genesis Child Theme */

	add_action( 'wp_head', 'childgenesis_childtheme_inline_styles' );

	//add_action( 'wp_footer', 'childgenesis_childtheme_inline_scripts' );

	/* Remove Default Post Image */

	remove_action( 'genesis_post_content', 'genesis_do_post_image' );

	/* Add Custom Post Image */

	add_action( 'genesis_post_content', 'childgenesis_do_post_image', 1 );

	/* Init Custom childgenesis Widgets */

	add_action( 'widgets_init', 'childgenesis_custom_widgets' );

	/* Post Share and Sunscribe Boxes */

	//add_action( 'genesis_after_post_content', 'childgenesis_subscribe_sharebox' );

}

add_action( 'after_setup_theme', 'childgenesis_childtheme_setup' );

/**

 * childgenesis Child Theme Setup

 * 

 * Instantiate Child theme settings page and Localization.

 * 

 * @since 1.0

 * 

 * @return null

 */

function childgenesis_childtheme_setup() {

	$GLOBALS['_childgenesis_childtheme_settings'] = new ChildGenesis_Childtheme_Settings;

	/* Loalization */

	load_child_theme_textdomain( 'childgenesis', CHILD_DIR . '/languages' );

}

/**

 * Print Google Fonts

 * 

 * @since 1.0

 * 

 * @return null

 */

function childgenesis_parent_stylesheet() {



	echo '<link rel="stylesheet" type="text/css" href="'.CHILD_URL.'/font/font.css">';



}

/**

 * childgenesis Childtheme Styles

 * 

 * @since 1.0

 * 

 * @return null

 */

function childgenesis_childtheme_styles() {



}

/**

 * childgenesis Childtheme Scripts

 * 

 * @since 1.0

 * 

 * @return null

 */

function childgenesis_childtheme_scripts() {

	wp_enqueue_script( 'ga-modernizr',  CHILD_URL . '/js/modernizr.min.js', '', null, false );

	wp_enqueue_script( 'ga-fancybox',   CHILD_URL . '/js/fancybox.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-fitvids',    CHILD_URL . '/js/fitvids.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-flexslider', CHILD_URL . '/js/flexslider.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-jcarousel', CHILD_URL . '/js/jquery.jcarousel.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-fogo', CHILD_URL . '/js/fogo.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-vids', CHILD_URL . '/js/vid.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-touch', CHILD_URL . '/js/touch.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-tipsy',      CHILD_URL . '/js/tipsy.min.js', array( 'jquery' ), null, true );

	wp_enqueue_script( 'ga-dedicated',  CHILD_URL . '/js/dedicated-custom.js', array( 'ga-fancybox','ga-fitvids','ga-flexslider','ga-tipsy' ), null, true );

}

/**

 * childgenesis Custom Stylings

 * 

 * @since 1.0

 * 

 * @return null

 */

function childgenesis_childtheme_inline_styles() {

	// Logo CSS

	$logo_url    = esc_url_raw( genesis_get_option( 'logo_url', GA_CHILDTHEME_FIELD ) );

	$logo_width  = absint( genesis_get_option( 'logo_width', GA_CHILDTHEME_FIELD ) );

	$logo_height = absint( genesis_get_option( 'logo_height', GA_CHILDTHEME_FIELD ) );

	$logo_css    = ( $logo_url && $logo_width && $logo_height ) ? ".header-image #title-area #title { background: url('{$logo_url}') no-repeat;width: {$logo_width}px;height: {$logo_height}px;}\n" : '' ;

	// Typography CSS

	$the_css = '';

	if ( ! $logo_css && ! $the_css )

		return;

	?>

<style type="text/css">

/* <![CDATA[ */

 <?php echo $logo_css . $the_css;

?>

	/* ]]> */

</style>



<?php

}



function childgenesis_do_header_right() {

	?>



<?php

}

function childgenesis_do_post_image() {

	$full_image = genesis_get_image( array( 'format' => 'url' ) );

	if ( $full_image && ! is_singular() && genesis_get_option( 'content_archive_thumbnail' ) ) {

		?>

	<div class="dedicated-thumb"> <a href="<?php echo esc_attr( $full_image ); ?>" title="<?php the_title_attribute(); ?>">

  		<?php genesis_image( array( 'size' => 'dedicated-post-image' ) ); ?>

  	</a> </div>

<?php

	}

}

add_filter( 'the_content_more_link', 'childgenesis_more_link' );

add_filter( 'get_the_content_more_link', 'childgenesis_more_link' );

/**

 * More Link

 * 

 * @since 1.0 

 * 

 * @param  string $html Default More Link

 * @return string       Custom More link

 */

function childgenesis_more_link( $html ) {

	global $post;

	$morelink = '<a href="' . get_permalink() . '#more-' . $post->ID . '" class="more-link">' . __( 'Read More', 'childgenesis' ) . '</a>';

	return $morelink;

}

add_filter( 'genesis_footer_output', 'childgenesis_footer_output', 10, 3 );

/**

 * childgenesis Custom Footer output

 * 

 * @since 1.0

 * 

 * @param  string $output      Default Footer HTML

 * @param  string $backtoptext BacktoTop HTML (Left)

 * @param  string $creds_text  Credits HTML (Right)

 * @return string              Custom Footer HTML

 */

function childgenesis_footer_output( $output, $backtoptext, $creds_text ) {

	$left_text = $backtoptext;

	if ( has_nav_menu( 'footernav' ) ) {

		$left_text = wp_nav_menu(

			array(

				'theme_location'  => 'footernav',

				'container'       => 'null', 

				'container_class' => null, 

				'container_id'    => null,

				'menu_class'      => null, 

				'menu_id'         => 'footernav',

				'echo'            => false,

				'depth'           => 1

			)

		);

	}



}

/**

 * childgenesis Custom Widgets Register.

 * 

 * @since 1.0

 * 

 * @return null

 */

function childgenesis_custom_widgets() {

	/* Unregister Defailt Header Right */

	//unregister_sidebar( 'header-right' );

		 register_sidebar( 'header-tagline' );

	/* Register Custom Widgets */

	unregister_widget( 'GA_Facebook_Likebox_Widget' );

	unregister_widget( 'GA_Flickr_Widget' );

}

/**

 * childgenesis Subscribe and Shareing boxes.

 * 

 * @since 1.0

 * 

 * @return null

 */



add_filter( 'genesis_available_sanitizer_filters', 'childgenesis_custom_filters' );

/**

 * childgenesis Custom Option Filters for Genesis

 * 

 * @since 1.0

 * 

 * @param  array $filters Default Genesis Options Filters

 * @return array          Custom and Default Genesis Options Filters

 */

function childgenesis_custom_filters( $filters ) {

	$filters['email']   = 'sanitize_email';

	$filters['integer'] = 'childgenesis_intval';

	return $filters;

}

/**

 * Helper intval function for sanitization

 * 

 * @since 1.0

 * 

 * @param  mixed    $new_val submitted value

 * @param  mixed    $old_val old value

 * @return integeer          Integer value

 */

function childgenesis_intval( $new_val, $old_val ) {

	return intval( $new_val );

}

/**

 * childgenesis Related Posts Query

 * 

 * @since 1.0

 * 

 * @param  integer $number Number of related posts to show

 * @return null

 */

function childgenesis_related_posts( $number = 5 ) {

	global $post;

	$categories = get_categories( $post->ID );

	$cat_ids = array();

	if ( ! $categories )

		return;

	foreach ( $categories as $cat ) {

		$cat_ids[] = $cat->term_id;

	}

	$args = array(

		'category__in'     => $cat_ids,

		'post__not_in'     => array( $post->ID ),

		'posts_per_page'   => absint( $number ),

	);

	$ga_related = new WP_Query( $args );

	if ( $ga_related->have_posts() ) {

		echo '<ul>';

		while ( $ga_related->have_posts() ) {

			$ga_related->the_post();

			printf( '<li><a href="%s" title="%s">%s</a></li>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );

		}

		echo '</ul>';

	}

	wp_reset_query();

}

add_filter( 'genesis_export_options', 'childgenesis_childtheme_export_options' );

/**

 * Add to Genesis Import & Export Options

 * 

 * @since 1.0

 * 

 * @param  array $options Default Import & Export support

 * @return array          childgenesis and Default Import & Exoirt support

 */

function childgenesis_childtheme_export_options( $options ) {

	$options['dedicated'] = array(

		'label'          => __( 'Genesis Child Theme Settings', 'childgenesis' ),

		'settings-field' => GA_CHILDTHEME_FIELD,

	);

	return $options;

}

/**********************************custom function by developer*********************************/

add_action( 'genesis_setup', 'genesis_child_register_default_widget_areas' );

function genesis_child_register_default_widget_areas(){

 genesis_register_sidebar(

		array(

			'id'          => 'header-address',

			'name'        => is_rtl() ? __( 'Header Address', 'genesis' ) : __( 'Header Address', 'genesis' ),

			'description' => __( 'This is the widget area in the header.', 'genesis' ),

	)

	);

	genesis_register_sidebar(

		array(

			'id'          => 'after-footer',

			'name'        => is_rtl() ? __( 'After Footer', 'genesis' ) : __( 'After Footer', 'genesis' ),

			'description' => __( 'This is the widget area in the footer.', 'genesis' ),

		)

	);

}



add_action( 'init', 'create_post_type' );

function create_post_type() {

	register_post_type( 'slider',

		array(

			'labels' => array(

				'name' => __( 'Slider' ),

				'singular_name' => __( 'Slider' )

			),

		'public' => true,

		'has_archive' => true,

		'rewrite' => array('slug' => 'Slider'),

		'supports' => array( 'title', 'editor','thumbnail' ),

		)

	);

	register_post_type( 'video',

		array(

			'labels' => array(

				'name' => __( 'Video' ),

				'singular_name' => __( 'video' )

			),

		'public' => true,

		'has_archive' => true,

		'rewrite' => array('slug' => 'video'),

		'supports' => array( 'title','thumbnail', 'editor' ),

		)

	);

}




function new_excerpt_more($post) {



    return '<a href="'. get_permalink($post->ID) . '">' . '&nbsp;Read More' . '</a>';



}

add_filter('excerpt_more', 'new_excerpt_more');

function GetCertainPostTypes($query) {

    if ($query->is_search) {

        $query->set('post_type',array('post','page'));

    }

return $query;

}

add_filter('pre_get_posts','GetCertainPostTypes');



register_sidebar( array(

    'name'         => __( 'Home Sidebar' ),

    'id'           => 'home-sidebar',

    'description'  => __( 'Widgets in this area will be shown on the Home page.' ),

) );




register_sidebar( array(

    'name'         => __( 'Linkdin  Sidebar' ),

    'id'           => 'tweet-sidebar',

    'description'  => __( 'Widgets in this area will be shown on the Home page Linkdin .' ),

) );

register_sidebar( array(

    'name'         => __( 'Footer  Sidebar' ),

    'id'           => 'footer-sidebar',

    'description'  => __( 'Widgets in this area will be shown on the Footer .' ),

) );