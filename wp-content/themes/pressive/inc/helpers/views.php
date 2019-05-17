<?php

function _thrive_get_header_wrapper_class( $options = null ) {
	if ( ! $options ) {
		$options = thrive_get_theme_options();
	}
}

function _thrive_get_main_wrapper_class( $options = null ) {
	if ( ! $options ) {
		$options = thrive_get_theme_options();
	}

	if ( $options['blog_layout'] == "default" || $options['blog_layout'] == "full_width" ) {
		if ( ( is_archive() || is_tag() ) && ! is_author() && ! is_category() ) {
			return "wrp cnt";
		}

		return "wrp cnt ind";
	}

	if ( $options['blog_layout'] == "grid_full_width" || $options['blog_layout'] == "grid_sidebar" ) {
		return "wrp cnt gin";
	}
	if ( $options['blog_layout'] == "masonry_full_width" || $options['blog_layout'] == "masonry_sidebar" ) {
		return "wrp cnt mryv";
	}

	return "wrp cnt";
}

function _thrive_get_main_section_class( $options = null ) {
	if ( ! $options ) {
		$options = thrive_get_theme_options();
	}
	if ( is_page() ) {
		$sidebar_is_active = is_active_sidebar( 'sidebar-2' );
	} else {
		$sidebar_is_active = is_active_sidebar( 'sidebar-1' );
	}

	$masonry_class = "";
	if ( $options['blog_layout'] == "masonry_full_width" || $options['blog_layout'] == "masonry_sidebar" ) {
		$masonry_class = " mry";
	}
	if ( $options['blog_layout'] == "full_width" || $options['blog_layout'] == "grid_full_width" || $options['blog_layout'] == "masonry_full_width" || ! $sidebar_is_active ) {
		return "bSe fullWidth" . $masonry_class;
	}

	$sidebar_alignement = ( $options['sidebar_alignement'] == "right" ) ? "left" : "right";

	return "bSe " . $sidebar_alignement . $masonry_class;
}

function _thrive_get_main_content_class( $options = null ) {
	if ( ! $options ) {
		$options = thrive_get_theme_options();
	}
	$main_content_class = "fullWidth";
	if ( $options['sidebar_alignement'] == "right" ) {
		$main_content_class = "left";
	} elseif ( $options['sidebar_alignement'] == "left" ) {
		$main_content_class = "right";
	}
	if ( is_page() ) {
		$sidebar_is_active = is_active_sidebar( 'sidebar-2' );
	} else {
		$sidebar_is_active = is_active_sidebar( 'sidebar-1' );
	}
	if ( ! $sidebar_is_active ) {
		$main_content_class = "fullWidth";
	}

	return $main_content_class;
}

function _thrive_get_author_info( $author_id = 0 ) {
	if ( $author_id == 0 ) {
		if ( is_single() || is_page() ) {
			global $post;
			$author_id = $post->post_author;
		} elseif ( is_author() ) {
			$author_id = get_the_author_meta( 'ID' );
		}
	}
	$user_info = get_userdata( $author_id );
	if ( ! $user_info ) {
		return false;
	}
	$social_links = ( array(
		"twitter" => get_the_author_meta( 'twitter', $author_id ),
		"fb"      => get_the_author_meta( 'facebook', $author_id ),
		"g_plus"  => get_the_author_meta( 'gplus', $author_id )
	) );

	return array(
		'avatar'         => get_avatar( $user_info->user_email, 125 ),
		'display_name'   => $user_info->display_name,
		'description'    => $user_info->description,
		'social_links'   => $social_links,
		'posts_url'      => get_author_posts_url( $author_id ),
		'author_website' => get_the_author_meta( 'thrive_author_website', $author_id )
	);
}

function _thrive_get_featured_image_src( $style = null, $post_id = null, $featured_image_size = null ) {
	if ( ! $style ) {
		$style = thrive_get_theme_options( 'featured_image_style' );
	}
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	return thrive_get_post_featured_image_src( $post_id, $style );
}

function _thrive_get_footer_col_class( $num_cols ) {
	$f_class = "";
	switch ( $num_cols ) {
		case 0:
			return "";
		case 1:
			return "";
		case 2:
			return "colm twc";
		case 3:
			return "colm oth";
	}

	return $f_class;
}

function _thrive_get_footer_active_widget_areas( $appr = "" ) {
	$num            = 0;
	$active_footers = array();
	while ( $num < 4 ) {
		$num ++;
		if ( is_active_sidebar( 'footer-' . $appr . $num ) ) {
			array_push( $active_footers, 'footer-' . $appr . $num );
		}
	}

	return $active_footers;
}

function _thrive_render_bottom_related_posts( $postId, $options = null ) {
	if ( ! $postId || ! is_single() ) {
		return false;
	}
	if ( ! $options ) {
		$options = thrive_get_options_for_post( $postId );
	}
	if ( $options['related_posts_box'] != 1 ) {
		return false;
	}
	$postType = get_post_type( $postId );
	if ( $postType != "post" ) {
		return false;
	}

	if ( thrive_get_theme_options( 'related_posts_enabled' ) == 1 ) {
		$relatedPosts = _thrive_get_related_posts( $postId, 'array', $options['related_posts_number'] );
	}
	if ( empty( $relatedPosts ) || ! is_array( $relatedPosts ) ) {
		$relatedPosts = get_posts( array(
			'category__in' => wp_get_post_categories( $postId ),
			'numberposts'  => $options['related_posts_number'],
			'post__not_in' => array( $postId )
		) );
	}
	if ( ! $relatedPosts || ! is_array( $relatedPosts ) ) {
		return false;
	}

	require get_template_directory() . '/partials/bottom-related-posts.php';
}

function thrive_include_meta_post_tags() {

	if ( _thrive_check_is_woocommerce_page() ) {
		return false;
	}


	$theme_options = thrive_get_options_for_post();

	if ( ! isset( $theme_options['social_site_meta_enable'] ) || $theme_options['social_site_meta_enable'] === null || $theme_options['social_site_meta_enable'] == "" ) {
		$theme_options['social_site_meta_enable'] = _thrive_get_social_site_meta_enable_default_value();
	}

	if ( $theme_options['social_site_meta_enable'] != 1 ) {
		return false;
	}

	if ( is_single() || is_page() ) {
		$plugin_file_path = thrive_get_wp_admin_dir() . "/includes/plugin.php";
		include_once( $plugin_file_path );
		if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
			if ( ( ! isset( $theme_options['social_site_title'] ) || $theme_options['social_site_title'] == '' )
			     && ( ! isset( $theme_options['social_site_image'] ) || $theme_options['social_site_image'] == '' )
			     && ( ! isset( $theme_options['social_site_description'] ) || $theme_options['social_site_description'] == '' )
			     && ( ! isset( $theme_options['social_site_twitter_username'] ) || $theme_options['social_site_twitter_username'] == '' )
			) {
				return;
			} else {
				thrive_remove_yoast_meta_description();
			}
		}

		$page_type = 'article';
		if ( ! isset( $theme_options['social_site_title'] ) || $theme_options['social_site_title'] == '' ) {
			$theme_options['social_site_title'] = wp_strip_all_tags( get_the_title() );
		}
		if ( ! isset( $theme_options['social_site_image'] ) || $theme_options['social_site_image'] == '' ) {
			if ( has_post_thumbnail( get_the_ID() ) ) {
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ) );
				if ( $featured_image && isset( $featured_image[0] ) ) {
					$theme_options['social_site_image'] = $featured_image[0];
				}
			}
		}
		if ( ! isset( $theme_options['social_site_description'] ) || $theme_options['social_site_description'] == '' ) {
			$post    = get_post();
			$content = strip_shortcodes( $post->post_content );
			$content = strip_tags( $content );
			$content = preg_replace( "/\s+/", " ", $content );
			$content = str_replace( '&nbsp;', ' ', $content );

			$first_dot         = strpos( $content, '.' ) !== false ? strpos( $content, '.' ) : strlen( $content );
			$first_question    = strpos( $content, '.' ) !== false ? strpos( $content, '.' ) : strlen( $content );
			$first_exclamation = strpos( $content, '.' ) !== false ? strpos( $content, '.' ) : strlen( $content );

			$fist_sentence                            = min( $first_dot, $first_exclamation, $first_question );
			$content                                  = substr( $content, 0, intval( $fist_sentence ) + 1 );
			$theme_options['social_site_description'] = addslashes( $content );
		}
	} else {
		$page_type = 'website';
	}
	$current_url = get_permalink();

	$meta = array(
		//uniqueID => meta
		'og:type'      => array(
			//attribute -> value
			'property' => 'og:type',
			'content'  => $page_type,
		),
		'og:url'       => array(
			'property' => 'og:url',
			'content'  => $current_url,
		),
		'twitter:card' => array(
			'name'    => 'twitter:card',
			'content' => 'summary_large_image'
		),
	);

	if ( isset( $theme_options['social_site_name'] ) && $theme_options['social_site_name'] != '' ) {
		$meta['og:site_name'] = array(
			'property' => 'og:site_name',
			'content'  => str_replace( '"', "'", $theme_options['social_site_name'] )
		);
	}
	if ( isset( $theme_options['social_site_title'] ) && $theme_options['social_site_title'] != '' ) {
		$meta['og:title']      = array(
			'property' => 'og:title',
			'content'  => str_replace( '"', "'", $theme_options['social_site_title'] ),
		);
		$meta['twitter:title'] = array(
			'name'    => 'twitter:title',
			'content' => str_replace( '"', "'", $theme_options['social_site_title'] )
		);
	}
	if ( isset( $theme_options['social_site_image'] ) && $theme_options['social_site_image'] != '' ) {
		$meta['og:image']          = array(
			'property' => 'og:image',
			'content'  => str_replace( '"', "'", $theme_options['social_site_image'] ),
		);
		$meta['twitter:image:src'] = array(
			'name'    => 'twitter:image:src',
			'content' => str_replace( '"', "'", $theme_options['social_site_image'] )
		);

	}
	if ( isset( $theme_options['social_site_description'] ) && $theme_options['social_site_description'] != '' ) {
		$meta['og:description']      = array(
			'property' => 'og:description',
			'content'  => str_replace( '"', "'", $theme_options['social_site_description'] )
		);
		$meta['twitter:description'] = array(
			'name'    => 'twitter:description',
			'content' => str_replace( '"', "'", $theme_options['social_site_description'] )
		);
	}
	if ( isset( $theme_options['social_site_twitter_username'] ) && $theme_options['social_site_twitter_username'] != '' ) {
		$meta['twitter:creator'] = array(
			'name'    => 'twitter:creator',
			'content' => '@' . str_replace( '"', "'", $theme_options['social_site_twitter_username'] )
		);
		$meta['twitter:site']    = array(
			'name'    => 'twitter:site',
			'content' => '@' . str_replace( '"', "'", $theme_options['social_site_twitter_username'] )
		);
	}

	$meta = apply_filters( 'tha_social_meta', $meta );

	if ( empty( $meta ) ) {
		return;
	}
	echo "\n";
	//display all the meta
	foreach ( $meta as $uniquekey => $attributes ) {
		if ( empty( $attributes ) || ! is_array( $attributes ) ) {
			continue;
		}
		echo "<meta ";
		foreach ( $attributes as $attr_name => $attr_value ) {
			echo $attr_name . '="' . $attr_value . '" ';
		}
		echo "/>\n";
	}
	echo "\n";
}

function thrive_remove_yoast_meta_description() {
	if ( has_action( 'wpseo_head' ) ) {
		if ( isset( $GLOBALS['wpseo_og'] ) ) {
			remove_action( 'wpseo_head', array( $GLOBALS['wpseo_og'], 'opengraph' ), 30 );
		}
		remove_action( 'wpseo_head', array( 'WPSEO_Twitter', 'get_instance' ), 40 );
		remove_action( 'wpseo_head', array( 'WPSEO_GooglePlus', 'get_instance' ), 35 );
	}
}

function thrive_get_wp_admin_dir() {
	$wp_include_dir = preg_replace( '/wp-content$/', 'wp-admin', WP_CONTENT_DIR );

	return $wp_include_dir;
}

function _thrive_is_active_sidebar( $options = null ) {
	if ( _thrive_check_is_woocommerce_page() ) {
		return is_active_sidebar( 'sidebar-woo' );
	}
	if ( ! $options ) {
		$options = thrive_get_theme_options();
	}
	if ( is_singular() ) {
		$post_template = _thrive_get_item_template( get_the_ID() );
		if ( $post_template == "Narrow" || $post_template == "Full Width" || $post_template == "Landing Page" ) {
			return false;
		}
	}
	if ( is_page() ) {
		$sidebar_is_active = is_active_sidebar( 'sidebar-2' );
		if ( $options['blog_post_layout'] === 'full_width' || $options['blog_post_layout'] === 'narrow' ) {
			$sidebar_is_active = false;
		}
	} else {
		$sidebar_is_active = is_active_sidebar( 'sidebar-1' );
	}


	if ( is_singular() ) {
		return $sidebar_is_active;
	}
	if ( $options['blog_layout'] == "full_width" || $options['blog_layout'] == "grid_full_width" || $options['blog_layout'] == "masonry_full_width" || ! $sidebar_is_active ) {
		return false;
	}

	return true;
}

function _thrive_render_post_content_template( $options = null ) {
	if ( ! $options ) {
		$options = thrive_get_theme_options();
	}
	$template_file = "partials/content-default.php";
	if ( ( is_archive() || is_author() || is_tag() || is_category() ) && ( $options['blog_layout'] == "default" || $options['blog_layout'] == "full_width" ) ) {
		$template_file = "partials/content-default.php";
	}

	if ( $options['blog_layout'] == "default" || $options['blog_layout'] == "full_width" ) {
		$template_file = "partials/content-default.php";
	}
	if ( $options['blog_layout'] == "grid_full_width" || $options['blog_layout'] == "grid_sidebar" ) {
		$template_file = "partials/content-grid.php";
	}
	if ( $options['blog_layout'] == "masonry_full_width" || $options['blog_layout'] == "masonry_sidebar" ) {
		$template_file = "partials/content-masonry.php";
	}
	include locate_template( $template_file );
}

function _thrive_get_post_format_fields( $format, $post_id ) {
	$options = array();
	switch ( $format ) {
		case "audio":
			$options['audio_type']                  = get_post_meta( $post_id, '_thrive_meta_postformat_audio_type', true );
			$options['audio_file']                  = get_post_meta( $post_id, '_thrive_meta_postformat_audio_file', true );
			$options['audio_soundcloud_embed_code'] = get_post_meta( $post_id, '_thrive_meta_postformat_audio_soundcloud_embed_code', true );
			break;
		case "gallery":
			$options['gallery_images'] = get_post_meta( $post_id, '_thrive_meta_postformat_gallery_images', true );
			$options['gallery_ids']    = explode( ",", $options['gallery_images'] );
			break;
		case "quote":
			$options['quote_text']   = get_post_meta( $post_id, '_thrive_meta_postformat_quote_text', true );
			$options['quote_author'] = get_post_meta( $post_id, '_thrive_meta_postformat_quote_author', true );
			break;
		case "video":
			$thrive_meta_postformat_video_type        = get_post_meta( $post_id, '_thrive_meta_postformat_video_type', true );
			$thrive_meta_postformat_video_youtube_url = get_post_meta( $post_id, '_thrive_meta_postformat_video_youtube_url', true );
			$thrive_meta_postformat_video_vimeo_url   = get_post_meta( $post_id, '_thrive_meta_postformat_video_vimeo_url', true );
			$thrive_meta_postformat_video_custom_url  = get_post_meta( $post_id, '_thrive_meta_postformat_video_custom_url', true );

			$youtube_attrs = array(
				'hide_logo'       => get_post_meta( $post_id, '_thrive_meta_postformat_video_youtube_hide_logo', true ),
				'hide_controls'   => get_post_meta( $post_id, '_thrive_meta_postformat_video_youtube_hide_controls', true ),
				'hide_related'    => get_post_meta( $post_id, '_thrive_meta_postformat_video_youtube_hide_related', true ),
				'hide_title'      => get_post_meta( $post_id, '_thrive_meta_postformat_video_youtube_hide_title', true ),
				'autoplay'        => get_post_meta( $post_id, '_thrive_meta_postformat_video_youtube_autoplay', true ),
				'hide_fullscreen' => get_post_meta( $post_id, '_thrive_meta_postformat_video_youtube_hide_fullscreen', true ),
				'video_width'     => 1080
			);

			if ( $thrive_meta_postformat_video_type == "youtube" ) {
				$options['youtube_autoplay'] = $youtube_attrs['autoplay'];
				$video_code                  = _thrive_get_youtube_embed_code( $thrive_meta_postformat_video_youtube_url, $youtube_attrs );
			} elseif ( $thrive_meta_postformat_video_type == "vimeo" ) {
				$video_code = _thrive_get_vimeo_embed_code( $thrive_meta_postformat_video_vimeo_url );
			} else {
				if ( strpos( $thrive_meta_postformat_video_custom_url, "<" ) !== false || strpos( $thrive_meta_postformat_video_custom_url, "[" ) !== false ) { //if embeded code or shortcode
					$video_code = do_shortcode( $thrive_meta_postformat_video_custom_url );
				} else {
					$video_code = do_shortcode( "[video src='" . $thrive_meta_postformat_video_custom_url . "']" );
				}
			}
			$options['video_type'] = $thrive_meta_postformat_video_type;
			$options['video_code'] = $video_code;
			break;
	}

	return $options;
}

function _thrive_get_post_text_content_excerpt( $content, $postId, $limit = 120, $allowTags = array(), $force_excerpt = false ) {
	$GLOBALS['thrive_post_excerpts']   = isset( $GLOBALS['thrive_post_excerpts'] ) ? $GLOBALS['thrive_post_excerpts'] : array();
	$GLOBALS['thrive_post_excerpts'][] = $postId;

	$content = get_extended( $content );
	$content = $content['main'];

	//get the global post
	global $post;

	//save it temporary
	$current_post = $post;

	//set the global post the post received as parameter
	$post = get_post( $postId );

	if ( $force_excerpt || ! empty( $GLOBALS['thrive_theme_options']['other_show_excerpt'] ) ) {
		$content = get_post_meta( $postId, 'tve_updated_post', true ) . $content;
		$content = strip_shortcodes( $content );
		$content = preg_replace( '/___TVE_SHORTCODE_RAW__(.+?)__TVE_SHORTCODE_RAW___/', '', $content );
		$content = preg_replace( '#>__CONFIG_%s__(.+?)__CONFIG_%s__</div>#', '>', $content );
	} else {
		$content = apply_filters( 'the_content', $content );
	}

	//set the global post back to original
	$post = $current_post;

	//remove the continue reading text
	$read_more_type   = thrive_get_theme_options( 'other_read_more_type' );
	$read_more_option = thrive_get_theme_options( "other_read_more_text" );
	$read_more_text   = ( $read_more_option != "" ) ? $read_more_option : "Read more";

	if ( $read_more_type === 'button' ) {
		/**
		 * if there is a button we need to remove it entirely
		 *
		 * @see thrive_more_link
		 */
		$content = preg_replace( '/<a\sclass=\"(.*?)\"\shref=\"(.*?)\"><span>' . $read_more_text . '<\/span><\/a>/s', "", $content );
	} else if ( $read_more_type === 'text' ) {
		$content = preg_replace( '/<a\sclass=\"(.*?)\"\shref=\"(.*?)\">' . str_replace( array( '[', ']' ), array(
				'\\[',
				'\\]'
			), $read_more_text ) . '<\/a>/s', "", $content );
	} else {
		//default case
		$content = str_replace( $read_more_text, "", $content );
	}

	//remove empty P tags
	$content = preg_replace( '/<p><\/p>/s', "", $content );

	//if post content is check in thrive options for In Blog List Display
	if ( ! $force_excerpt && isset( $GLOBALS['thrive_theme_options']['other_show_excerpt'] ) && $GLOBALS['thrive_theme_options']['other_show_excerpt'] == 0 ) {
		return $content;
	}

	$start = '\[';
	$end   = '\]';
	if ( isset( $allowTags['br'] ) ) {
		$content = nl2br( $content );
	}
	/**
	 * Remove any possible <style> and <script> tags from the content
	 */
	$content = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $content);
	$content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);
	$content = wp_kses( $content, $allowTags );
	$content = preg_replace( '#(' . $start . ')(.*)(' . $end . ')#si', '', $content );
	if ( strpos( $content, "[" ) < $limit ) {
		$subcontent = substr( $content, strpos( $content, "]" ), $limit );
		if ( strpos( $subcontent, "[" ) === false ) {
			return _thrive_substring( $content, $limit );
		}
	}

	return _thrive_substring( $content, $limit );
}

/**
 * Cut the content to the limit without cutting the last word
 *
 * @param $content
 * @param $limit
 *
 * @return string
 */
function _thrive_substring( $content, $limit ) {
	if ( strlen( $content ) <= $limit ) {
		return $content;
	}
	$length = strpos( $content, " ", $limit );

	/**
	 * this means there's a really long word there, which has no space after it
	 */
	if ( false === $length ) {
		$content = substr( $content, 0, $limit ) . '...';
	} else {
		$content = substr( $content, 0, $length );
	}

	return $content;
}

function thrive_trim_title_words( $title, $characters = 35 ) {

	if ( strlen( $title ) < $characters ) {
		return $title;
	}

	$final_title = '';
	$space_pos   = 0;
	while ( strlen( $final_title ) < $characters ) {
		if ( strpos( $title, ' ', $space_pos ) === false ) {
			break;
		}
		$space_pos   = strpos( $title, ' ', $space_pos ) + 1;
		$final_title = substr( $title, 0, $space_pos ) . ' ...';
	}
	if ( $final_title == '' ) {
		$final_title = substr( $title, 0, $characters ) . '...';
	}

	return $final_title;
}

function _thrive_get_read_more_text( $read_more_option = null ) {
	if ( ! $read_more_option ) {
		$read_more_option = thrive_get_theme_options( "other_read_more_text" );
	}
	$read_more_text = ( ! empty( $read_more_option ) ) ? $read_more_option : __( "Read more", 'thrive' );

	return $read_more_text;
}

function _thrive_render_top_fb_script( $options = null ) {
	if ( ! is_singular() ) {
		return false;
	}
	if ( ! $options ) {
		$options = thrive_get_options_for_post( get_the_ID() );
	}
	if ( $options['enable_fb_comments'] == "off" || empty( $options['fb_app_id'] ) ) {
		return false;
	}

	require get_template_directory() . '/partials/fb-script.php';
}

add_action( 'tha_head_top', 'thrive_include_meta_post_tags' );

function _thrive_get_header_style_options( $options = null ) {
	if ( ! $options ) {
		$options = thrive_get_options_for_post( get_the_ID() );
	}
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
			$header_class   = 'hbp';
			$header_pattern = get_theme_mod( 'thrivetheme_header_pattern' );
			if ( $header_pattern != 'anopattern' && strpos( $header_pattern, '#' ) === false ) {
				$header_style = 'background-image:url(' . get_bloginfo( 'template_url' ) . '/images/patterns/' . $header_pattern . '.png);';
			}
			break;
		case '#customize-control-thrivetheme_header_background_image, #customize-control-thrivetheme_header_image_type, #customize-control-thrivetheme_header_image_height':
			$header_image_type = get_theme_mod( 'thrivetheme_header_image_type' ) ? get_theme_mod( 'thrivetheme_header_image_type' ) : 'full';
			switch ( $header_image_type ) {
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
	$header_container_class = "t-c";
	$header_container_style = "";
	$header_overlay_style   = "";
	$theme_color_options    = thrive_get_default_customizer_options();


	$custom_homepage_id = get_option( 'page_for_posts' );
	if ( $custom_homepage_id != "0" && get_option( 'show_on_front' ) == 'page' && is_home() ) {
		$options                                      = thrive_get_options_for_post( $custom_homepage_id );
		$featured_image                               = wp_get_attachment_image_src( get_post_thumbnail_id( $custom_homepage_id ), "full" );
		$options['featured_title_bg_img_default_src'] = isset( $featured_image[0] ) ? $featured_image[0] : $options['featured_title_bg_img_default_src'];
	}

	//overwrite the general settings for a single post
	if ( is_singular() && has_post_thumbnail() ) {
		$post_format = get_post_format();
		if ( $post_format == "video" || $post_format == "quote" || $options['featured_image_style'] == "top" ) {
			$options['featured_title_bg_type']            = "image";
			$featured_image                               = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), "full" );
			$options['featured_title_bg_img_default_src'] = isset( $featured_image[0] ) ? $featured_image[0] : "";
		}
	}

	if ( $options['featured_title_bg_type'] == "image" ) {
		if ( ! ( $options['featured_title_bg_img_trans'] == "blur" ) ) {
			$header_container_style = "background-image:url('" . $options['featured_title_bg_img_default_src'] . "');";
		}

		if ( $options['featured_title_bg_img_trans'] == "none" ) {
			$header_container_class = "d-i";
		} elseif ( $options['featured_title_bg_img_trans'] == "dots" ) {
			$header_container_class = "d-o d-ow";
		} elseif ( $options['featured_title_bg_img_trans'] == "dots_narrow" ) {
			$header_container_class = "d-o d-on";
		} elseif ( $options['featured_title_bg_img_trans'] == "blur" ) {
			$header_container_class = "b-i";
			$header_overlay_style   = "background-image:url('" . $options['featured_title_bg_img_default_src'] . "');";
		} else {
			if ( $options['featured_title_bg_img_trans'] == $theme_color_options['thrivetheme_link_color'] ) { //the current theme color
				$header_container_class = "c-t";
			} else {
				$header_container_class = "c-o";
				$header_overlay_style   = "background-color: " . $options['featured_title_bg_img_trans'] . ";";
			}
		}
	} else {
		if ( $options['featured_title_bg_solid_color'] == $theme_color_options['thrivetheme_link_color'] ) { //the current theme color
			$header_container_class = "t-c";
		} else {
			$header_container_class = "c-c";
			$header_container_style = "background-color: " . $options['featured_title_bg_solid_color'] . ";";
		}
	}

	$logo_pos_class  = ( $options['logo_position'] != "top" ) ? "side" : "center";
	$has_phone       = ( ! empty( $options['header_phone_no'] ) || ! empty( $options['header_phone_text'] ) ) ? "has_phone" : "";
	$float_menu_attr = "";

	$post_template = "";
	if ( is_singular() ) {
		$post_template = _thrive_get_item_template( get_the_ID() );
	}

	if ( ( $options['navigation_type'] == "float" || $options['navigation_type'] == "scroll" ) && $post_template != "Landing Page" ) {
		$float_menu_attr = ( $options['navigation_type'] == "float" ) ? " data-float='float-fixed'" : " data-float='float-scroll'";
	}

	return array(
		'header_class'           => $header_class,
		'header_style'           => $header_style,
		'logo_pos_class'         => $logo_pos_class,
		'has_phone'              => $has_phone,
		'float_menu_attr'        => $float_menu_attr,
		'header_container_class' => $header_container_class,
		'header_container_style' => $header_container_style,
		'title_color_class'      => ( $options['featured_title_bg_color_type'] != "dark" ) ? "b-tl" : "b-td",
		'header_overlay_style'   => $header_overlay_style
	);
}

function _thrive_check_focus_area_for_pages( $page, $position = "top" ) {
	if ( ! $page ) {
		return false;
	}
	if ( $page == "blog" && ! is_home() ) {
		return false;
	}

	if ( $page == "blog" ) {
		$query = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_page_blog&meta_value=blog&order=ASC" );
	} elseif ( $page == "archive" ) {
		$query = new WP_Query( "post_type=focus_area&meta_key=_thrive_meta_focus_page_archive&meta_value=archive&order=ASC" );
	}

	$focus_areas = $query->get_posts();

	foreach ( $focus_areas as $focus_area ) {
		$post_custom_atr = get_post_custom( $focus_area->ID );
		if ( isset( $post_custom_atr['_thrive_meta_focus_display_location'] )
		     && isset( $post_custom_atr['_thrive_meta_focus_display_location'][0] )
		     && $post_custom_atr['_thrive_meta_focus_display_location'][0] == $position
		) {
			return true;
		}
	}

	return false;
}