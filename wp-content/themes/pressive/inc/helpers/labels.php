<?php

function _thrive_get_theme_options_fields_titles() {

	$titles = array(
		'logo_type'                         => __( 'Logo Type', 'thrive' ) . '<span class="tooltips" title="' . __( "Select 'image' to upload an image logo. Select 'text' to type your website or brand name, which will be displayed instead of the logo image. <a href='//thrivethemes.com/tkb_item/text-image-logo-type/' target='_blank'>Read more about logo settings in our knowledge base</a>", 'thrive' ) . '"></span>',
		'logo'                              => __( 'Light Logo', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the URL of your light logo image or upload a new one. Recommended size: 200px x 50px', 'thrive' ) . '"></span>',
		'logo_dark'                         => __( 'Dark Logo', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the URL of your dark logo image or upload a new one. Recommended size: 200px x 50px', 'thrive' ) . '"></span>',
		'logo_text'                         => __( 'Logo Text', 'thrive' ) . '<span class="tooltips" title="' . __( 'What you enter here will appear as a text logo on your site. It is recommended to keep this short, since logo space is limited.', 'thrive' ) . '"></span>',
		'logo_color'                        => __( 'Logo Color', 'thrive' ) . '<span class="tooltips" title="' . __( "Select what color the logo text should be displayed in. Choose 'default' to have the logo color match your theme colors.", 'thrive' ) . '"></span>',
		'logo_position'                     => __( 'Logo Position', 'thrive' ) . '<span class="tooltips" title="' . __( "Choose 'Side of Menu' to have the logo and main navigation menu displayed side-by-side. Choose 'Top of Menu' to show the logo above and the main navigation menu below.", 'thrive' ) . '"></span>',
		'header_phone'                      => __( 'Header Phone', 'thrive' ) . '<span class="tooltips" title="' . __( "Activate this option to display a phone number in your website's header area <a href='//thrivethemes.com/tkb_item/header-phone-number/' target='_blank'>Read more about adding a phone number in our knowledge base</a>", 'thrive' ) . '"></span>',
		'header_phone_no'                   => __( 'Header Phone Number', 'thrive' ) . '<span class="tooltips" title="' . __( "Enter the phone number you want to display in the header here", 'thrive' ) . '"></span>',
		'header_phone_text'                 => __( 'Header Phone Text', 'thrive' ) . '<span class="tooltips" title="' . __( "Enter a short call to action, which will be displayed above the phone number. Keep this very short, as space is limited.", 'thrive' ) . '"></span>',
		'header_phone_text_mobile'          => __( 'Header Phone Mobile Text', 'thrive' ) . '<span class="tooltips" title="' . __( "On mobile devices, visitors will see a tap-to-call button. Enter the call to action to be shown to mobile visitors here", 'thrive' ) . '"></span>',
		'header_phone_btn_color'            => __( 'Header Phone Button Color', 'thrive' ) . '<span class="tooltips" title="' . __( "Choose the color of the tap-to-call button that will be shown to mobile visitors", 'thrive' ) . '"></span>',
		'favicon'                           => __( 'Favicon', 'thrive' ) . '<span class="tooltips" title="' . __( "Enter the URL of your favicon image, or upload a new one. Recommended size is 16x16 px or 32 x 32 px. Recommended formats are .ico or .png.", 'thrive' ) . '"></span>',
		'footer_copyright'                  => __( 'Footer Copyright Text', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the text displayed below the footer area of your site. <br><br> You can use {Y} shortcode to display the current year', 'thrive' ) . '"></span>',
		'footer_copyright_links'            => __( 'Footer Copyright Links', 'thrive' ) . '<span class="tooltips" title="' . __( 'Display credit links in the footer', 'thrive' ) . '"></span>',
		'display_breadcrumbs'               => __( "Display Breadcrumbs" ) . '<span class="tooltips" title="' . __( "This is the global setting for displaying breadcrumbs on your site. <a href='//thrivethemes.com/tkb_item/turn-onoff-breadcrumbs-individual-posts-pages-thrive-themes/' target='_blank'>This setting can be overridden at 'post'/'page' level.</a>", 'thrive' ) . '"></span>',
		'comments_on_pages'                 => __( 'Show Comments On Pages' . '<span class="tooltips" title="' . __( "This is the global setting for displaying comments on your pages. <a href='//thrivethemes.com/tkb_item/deactivate-comments/' target='_blank'>This setting can be overridden at 'post'/'page' level.</a>", 'thrive' ) . '"></span>', 'thrive' ),
		'relative_time'                     => __( 'Relative Time', 'thrive' ) . '<span class="tooltips" title="' . __( "When activated, all dates on the site are shown in relative time or 'human time'. For example: instead of showin a date like '03/05/2015', the date will display as something like '4 days ago'.", 'thrive' ) . '"></span>',
		'highlight_author_comments'         => __( 'Highlight Author Comments' . '<span class="tooltips" title="' . __( "When set to 'On' author comments will be highlighted on your site making a clear separation between a user comment and an author comment.", 'thrive' ) . '"></span>', 'thrive' ),
		'color_scheme'                      => __( 'Color Scheme', 'thrive' ),
		'sidebar_alignement'                => __( 'Sidebar Alignment', 'thrive' ) . '<span class="tooltips" title="' . __( 'Select the sidebar alignment for standard posts and pages', 'thrive' ) . '"></span>',
		'extended_menu'                     => __( 'Extended Menu', 'thrive' ) . '<span class="tooltips" title="' . __( 'The extended (multi-column) menu features can be deactivated here. This is usually not necessary, but if you\'re experiencing conflicts with a different menu plugin, switching extended menus off can solve the issue.', 'thrive' ) . '"></span>',
		'custom_css'                        => __( 'Custom Css', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter any custom CSS you want to add in the field below. CSS added here will override the standard CSS rules of the theme. <a href=\'//thrivethemes.com/tkb_item/add-custom-css-thrive-theme/\' target=\'_blank\'>Read more about adding custom CSS in our knowledge base</a>', 'thrive' ) . '"></span>',
		'navigation_type'                   => __( 'Navigation', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/46781dvgn1?popover=true" class="wistia-popover[height=450,playerColor=333333,width=800]"><span class="videotips"></span></a><span class="tooltips" title="' . __( "When set to 'Floating', the top navigation will remain visible while scrolling down a page. When set to 'Float on scroll-up', the top navigation will only re-appear once you start scrolling up on a page. Set to 'default' to not use a floating or sticky navigation style.", 'thrive' ) . '"></span>',
		'featured_image_style'              => __( 'Featured Image Style', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/d1rhppxr8r?popover=true" class="wistia-popover[height=450,playerColor=333333,width=800]"><span class="videotips"></span></a><span class="tooltips" title="' . __( 'Select the type of featured image to show with blog posts.  Applies to both the single post and the blog/archive view.', 'thrive' ) . '"></span>',
		'featured_image_single_post'        => __( 'Show Featured Image in Single Post?', 'thrive' ) . '<span class="tooltips" title="' . __( 'Turn this off to only show featured images in the blog/archive view', 'thrive' ) . '"></span>',
		'meta_author_name'                  => __( 'Author Name', 'thrive' ),
		'meta_post_date'                    => __( 'Post Date', 'thrive' ),
		'meta_post_category'                => __( 'Post Category', 'thrive' ),
		'meta_comment_count'                => __( 'Comment Count', 'thrive' ) . '<span class="tooltips" title="' . __( 'Comment count is only shown if the number is greater than 0', 'thrive' ) . '"></span>',
		'meta_post_tags'                    => __( 'Post Tags', 'thrive' ),
		'bottom_about_author'               => __( 'Display About the Author Box?', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/v9rdgw7ext?popover=true" class="wistia-popover[height=450,playerColor=333333,width=800]"><span class="videotips"></span></a><span class="tooltips" title="' . __( 'Toggles on author bio box to be displayed at the bottom of each post. Set the content in Users -> Your Profile -> Biographical Info', 'thrive' ) . '"></span>',
		'bottom_previous_next'              => __( 'Display Links to Previous and Next Posts?', 'thrive' ),
		'related_posts_box'                 => __( 'Display Related Posts Box?', 'thrive' ),
		'related_posts_title'               => __( 'Related Posts Title', 'thrive' ),
		'related_posts_number'              => __( 'Related Posts to Show', 'thrive' ),
		'related_posts_images'              => __( 'Display Featured Images?', 'thrive' ),
		'other_read_more_type'              => __( 'Show Read More as', 'thrive' ),
		'other_read_more_text'              => __( 'Read More Button/Link Text', 'thrive' ),
		'other_show_comment_date'           => __( 'Show Comments Date', 'thrive' ),
		'other_show_excerpt'                => __( 'In Blog List display', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/548xnwg71n?popover=true" class="wistia-popover[height=450,playerColor=333333,width=800]"><span class="videotips"></span></a>' . '<span class="tooltips" title="' . __( 'In the blog display you can choose between displaying an automatically generated excerpt or adding a manual cut off point <a href=\'//thrivethemes.com/tkb_item/excerpts-full-content-display/\' target=\'_blank\'>Read more about this setting in our knowledge base</a>', 'thrive' ) . '"></span>',
		'hide_cats_from_blog'               => __( 'Hide Categories from Blog Page', 'thrive' ) . '<span class="tooltips" title="' . __( 'Categories added here will not show on the main blog page. They will still show in the RSS feed and in archive pages. They will also still be indexable by search engines.', 'thrive' ) . '"></span>',
		'analytics_header_script'           => __( 'Header Script', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the scripts you want to load in the <head> section of each post and page on your site. Typically, this is used for split-testing scripts and some analytics scripts. <a href=\'//thrivethemes.com/tkb_item/add-google-analytics-tracking-thrives-themes/\' target=\'_blank\'>Read more about how to add Analytics tracking in our knowledge base</a>', 'thrive' ) . '"></span>',
		'analytics_body_script'             => __( 'Body Script', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the scripts you want to load before the closing </body> tag of each post and page on your site.', 'thrive' ) . '"></span>',
		'analytics_body_script_top'         => __( 'Opening Body Script', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the scripts you want to load right after the opening body tag on each page. Typically used for Google Tag Manager.', 'thrive' ) . '"></span>',
		'image_optimization_type'           => __( 'Image Optimization', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/0fdirwh9w6?popover=true" class="wistia-popover[height=450,playerColor=252525,width=800]"><span class="videotips"></span></a><span class="tooltips" title="' . __( "Set to 'Lossy Compression' or 'Lossless Image' to automatically reduce the size of all images you upload to your site. 'Lossless Image' retains 100% of your image quality, while reducing the size. 'Lossy' can lead to a slight reduction in image quality, but also dramatically reduces the size of your images.", 'thrive' ) . '"></span>',
		'comments_lazy'                     => __( 'Lazy Load Comments', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/w5s8s86k67?popover=true" class="wistia-popover[height=450,playerColor=333333,width=800]"><span class="videotips"></span></a><span class="tooltips" title="' . __( 'Activate this option to start loading comments only once the visitor scrolls down far enough to see the comment section. On posts with many comments, this can dramatically speed up the loading time. <a href=\'//thrivethemes.com/tkb_item/enable-lazy-load-comments/\' target=\'_blank\'>Read more about this setting in our knowledge base</a>', 'thrive' ) . '"></span>',
		'enable_fb_comments'                => __( 'Enable Facebook Comments', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/ygkn210cf2?popover=true" class="wistia-popover[height=450,playerColor=333333,width=800]"><span class="videotips"></span></a><span class="tooltips" title="' . __( "Determines in what way Facebook comments are shown on your site. Note that you MUST create a Facebook app and add an app ID for this feature to work.", 'thrive' ) . '"></span>',
		'fb_app_id'                         => __( 'Facebook App Id', 'thrive' ) . '<a href="//fast.wistia.net/embed/iframe/uvwo9dml3l?popover=true" class="wistia-popover[height=450,playerColor=333333,width=800]"><span class="videotips"></span></a><span class="tooltips" title="' . __( "This is the App ID of a Facebook App associated with your website's domain. You can set up your app by going to http://developers.facebook.com/apps/", 'thrive' ) . '"></span>',
		'fb_no_comments'                    => __( 'Facebook Number of Comments', 'thrive' ) . '<span class="tooltips" title="' . __( "This number determines how many Facebook comments are displayed before a 'show more comments' button appears.", 'thrive' ) . '"></span>',
		'fb_color_scheme'                   => __( 'Color Scheme', 'thrive' ) . '<span class="tooltips" title="' . __( 'Choose whether to show the Facebook comments in the light or dark style.', 'thrive' ) . '"></span>',
		'fb_moderators'                     => __( 'Moderators', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter profile ID(s) for Facebook users that are allowed to moderate the comments', 'thrive' ) . '"></span>',
		'privacy_tpl_website'               => __( 'Website', 'thrive' ) . '<span class="tooltips" title="' . __( 'Website', 'thrive' ) . '"></span>',
		'privacy_tpl_company'               => __( 'Company Name', 'thrive' ) . '<span class="tooltips" title="' . __( 'Company name', 'thrive' ) . '"></span>',
		'privacy_tpl_contact'               => __( 'Contact Page Url', 'thrive' ) . '<span class="tooltips" title="' . __( 'Contact page url', 'thrive' ) . '"></span>',
		'privacy_tpl_address'               => __( 'Company Address', 'thrive' ) . '<span class="tooltips" title="' . __( 'Company address', 'thrive' ) . '"></span>',
		'enable_social_buttons'             => __( 'Use Thrive Social Buttons', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enable or disable the Thrive social sharing buttons on your entire site. If this is set to OFF, no social sharing buttons will show, regardless of the options set below', 'thrive' ) . '"></span>',
		'enable_floating_icons'             => __( 'Show Floating Icons by Default', 'thrive' ) . '<span class="tooltips" title="' . __( 'When this option is set to \'On\' the social sharing icons will move up and down the page as your visitor is scrolling. Set it to \'Off\' and the icons will remain in a fixed position at the top of the page.', 'thrive' ) . '"></span>',
		'enable_twitter_button'             => __( 'Twitter Button', 'thrive' ) . '',
		'social_twitter_username'           => __( 'Twitter Username', 'thrive' ) . '<span class="tooltips" title="' . __( 'The username entered here will automatically be appended to the end of shared tweet texts, like this: via @username', 'thrive' ) . '"></span>',
		'enable_facebook_button'            => __( 'Facebook Button', 'thrive' ) . '',
		'enable_google_button'              => __( 'Google+1 Button', 'thrive' ) . '',
		'enable_linkedin_button'            => __( 'Linkedin Button', 'thrive' ) . '',
		'enable_pinterest_button'           => __( 'Pinterest Button', 'thrive' ) . '',
		'social_display_location'           => __( "Display Location", 'thrive' ),
		'social_attention_grabber'          => __( 'Attention Grabber', 'thrive' ) . '<span class="tooltips" title="' . __( 'This is displayed above or next to the social sharing buttons and helps draw attention towards them.', 'thrive' ) . '"></span>',
		'social_cta_text'                   => __( 'CTA Text', 'thrive' ) . '<span class="tooltips" title="' . __( "A call-to-action shown above or next to the social sharing buttons. Keep it short. Something like 'Sharing is Caring!' or 'Spread the Word'.", 'thrive' ) . '"></span>',
		'social_add_like_btn'               => __( 'Additional Like Button', 'thrive' ) . '<span class="tooltips" title="' . __( 'Additional like button', 'thrive' ) . '"></span>',
		'social_custom_posts'               => __( 'Display on Custom Post Types', 'thrive' ) . '<span class="tooltips" title="' . __( "If there are custom post types you use and on which you want to display the social sharing icons, you can check them here. By default, the social icons only show on posts and pages, but not on any custom post types.", 'thrive' ) . '"></span>',
		'social_site_meta_enable'           => __( 'Use Thrive Social Meta Data', 'thrive' ) . '<span class="tooltips" title="' . __( "By enabling this option any meta data added by other plugins will be overwritten", 'thrive' ) . '"></span>',
		'social_site_name'                  => __( 'Site Name', 'thrive' ) . '<span class="tooltips" title="' . __( "Add the name of your site, this will show in the share snippet.  This isn’t the title of the content, but simply the brand name of your web site.", 'thrive' ) . '"></span>',
		'social_site_title'                 => __( 'Site Title', 'thrive' ) . '<span class="tooltips" title="' . __( "This is a short sentence to describe your web site.  The title should be no longer than 10 words, and should be about the same length as a Google search snippet.  Brand names should be included in the “Site Name” section.  In this section you should summarise your site in a succinct way to let visitors know what your site is about.", 'thrive' ) . '"></span>',
		'social_site_description'           => __( 'Site Description', 'thrive' ) . '<span class="tooltips" title="' . __( "Give a generic 2-4 sentences to encourage visitors to click through from the various social media networks. Remember, this snippet will only be displayed when the visitor shares from an archive page where there are lots of pieces of content, so a general description of the site works best.", 'thrive' ) . '"></span>',
		'social_site_image'                 => __( 'Site Image', 'thrive' ) . '<span class="tooltips" title="' . __( "Use images that are at least 1200 x 630 pixels to display large, beautiful stories on the social networks with high resolution devices.  Choose an image that will capture people’s attention in order to try and encourage a higher click through rate from the various social media networks.", 'thrive' ) . '"></span>',
		'social_site_twitter_username'      => __( 'Twitter Username', 'thrive' ) . '<span class="tooltips" title="' . __( "Add your Twitter username for when users share your content.  This is the Twitter username for the “publisher”.  You can also add a Twitter username for the “author” in your page settings for individual pieces of content.", 'thrive' ) . '"></span>',
		'404_custom_text'                   => __( 'Custom Text for the 404 Page', 'thrive' ) . '<span class="tooltips" title="' . __( "Custom text for the 404 page", 'thrive' ) . '"></span>',
		'404_display_sitemap'               => __( 'Display Sitemap', 'thrive' ) . '<span class="tooltips" title="' . __( "Display sitemap at the bottom of the page", 'thrive' ) . '"></span>',
		'related_no_text'                   => __( 'Text when no Related Posts are found', 'thrive' ),
		'related_ignore_cats'               => __( 'Ignore Categories', 'thrive' ),
		'related_ignore_tags'               => __( 'Ignore Tags', 'thrive' ),
		'related_number_posts'              => __( 'Number of Related Posts to store', 'thrive' ),
		'social_facebook'                   => __( 'Facebook Url', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the link of the Facebook page/profile', 'thrive' ) . '"></span>',
		'social_twitter'                    => __( 'Twitter Url', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the link of the Twitter profile', 'thrive' ) . '"></span>',
		'social_gplus'                      => __( 'Google Plus Url', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the link of the Google Plus profile', 'thrive' ) . '"></span>',
		'social_pinterest'                  => __( 'Pinterest Url', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the link of the Pinterest profile', 'thrive' ) . '"></span>',
		'social_youtube'                    => __( 'Youtube Url', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the link of the Youtube profile', 'thrive' ) . '"></span>',
		'social_linkedin'                   => __( 'Linkedin Url', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enter the link of the Linkedin profile', 'thrive' ) . '"></span>',
		'client_logos'                      => __( 'Client Logos', 'thrive' ) . '<span class="tooltips" title="' . __( 'Client logos', 'thrive' ) . '"></span>',
		'featured_title_bg_type'            => __( 'Title Section Background', 'thrive' ) . '<span class="tooltips" title="' . __( "This setting determines what is shown in the title section of your posts and pages. This is the area behind the large page or post title, above the content", 'thrive' ) . '"></span>',
		'featured_title_bg_solid_color'     => __( 'Background Color', 'thrive' ),
		'featured_title_bg_img_static'      => __( 'Image Type', 'thrive' ),
		'featured_title_bg_img_full_height' => __( 'Full Height Image', 'thrive' ),
		'featured_title_bg_img_trans'       => __( 'Overlay', 'thrive' ) . '<span class="tooltips" title="' . __( "You can choose to overlay a transparent color layer on your featured images in the single post and page views. Set to 'none' to show the featured images without a color overlay.", 'thrive' ) . '"></span>',
		'featured_title_bg_img_default_src' => __( 'Default Image', 'thrive' ),
		'featured_title_bg_color_type'      => __( 'Title Color', 'thrive' ),
		'blog_layout'                       => __( 'Blog Layout', 'thrive' ) . '<span class="tooltips" title="' . __( 'This setting determines how your posts are displayed in the blog view', 'thrive' ) . '"></span>',
		'blog_layout'                       => __( 'Blog Layout', 'thrive' ) . '<span class="tooltips" title="' . __( 'This setting determines how your posts are displayed in the blog view', 'thrive' ) . '"></span>',
		'appr_enable_feature'               => __( 'Enable apprentice feature', 'thrive' ),
		'appr_different_logo'               => __( 'Use Different Logo', 'thrive' ) . '<span class="tooltips" title="' . __( 'Activate this option if you want to display a different logo on your Apprentice content pages and lessons than on the rest of your site.', 'thrive' ) . '"></span>',
		'appr_breadcrumbs'                  => __( 'Breadcrumbs', 'thrive' ) . '<span class="tooltips" title="' . __( 'Activate this option if you want to display breadcrumb navigation links in your Apprentice content pages and lessons.', 'thrive' ) . '"></span>',
		'appr_root_page'                    => __( 'Lessons Root Page', 'thrive' ) . '<span class="tooltips" title="' . __( 'Choose the page here that you want to use as your membership homepage.', 'thrive' ) . '"></span>',
		'appr_sidebar'                      => __( 'Sidebar Alignment', 'thrive' ) . '<span class="tooltips" title="' . __( 'Choose which side you want to show the sidebar on. Note that you can show the sidebar on different sides in Apprentice pages and content than on the rest of your site.', 'thrive' ) . '"></span>',
		'appr_page_comments'                => __( 'Lesson Page Comments', 'thrive' ) . '<span class="tooltips" title="' . __( 'By default, comments are enabled on your lesson pages. You can use this option to globally deactivate comments on your lesson pages.', 'thrive' ) . '"></span>',
		'appr_prev_next_link'               => __( 'Previous/Next Links', 'thrive' ) . '<span class="tooltips" title="' . __( 'When activated, this option will display links to the previous and next lessons at the bottom of each lesson, making your course easier to navigate for your members.', 'thrive' ) . '"></span>',
		'appr_media_bg_color'               => __( 'Video/Audio BG Color', 'thrive' ) . '<span class="tooltips" title="' . __( 'Set a default background color you want to use for video and audio lessons. The background only applies to the video or audio player, not the entire page.', 'thrive' ) . '"></span>',
		'appr_favorites'                    => __( 'Favorites Feature', 'thrive' ) . '<span class="tooltips" title="' . __( 'The favorites feature lets your members mark specific lessons as favorites and easily find them again later.', 'thrive' ) . '"></span>',
		'appr_progress_track'               => __( 'Progress Tracking', 'thrive' ) . '<span class="tooltips" title="' . __( 'Enable this feature to let your members mark lessons as completed and easily continue the course where they last left off.', 'thrive' ) . '"></span>',
		'appr_completed_text'               => __( 'Completed Text', 'thrive' ) . '<span class="tooltips" title="' . __( 'This is the text shown next to the check box that indicates a lesson has been completed.', 'thrive' ) . '"></span>',
		'appr_download_heading'             => __( 'Download Box Heading', 'thrive' ) . '<span class="tooltips" title="' . __( 'If you add download links and resources to a lesson, this is the title that will be shown above the resources box.', 'thrive' ) . '"></span>',
		'appr_url_pages'                    => __( 'URL Base for Pages', 'thrive' ) . '<span class="tooltips" title="' . __( 'The string all your Apprentice content pages will have in common. By default: yoursite.com/members/', 'thrive' ) . '"></span>',
		'appr_url_lessons'                  => __( 'URL Base for Lessons', 'thrive' ) . '<span class="tooltips" title="' . __( 'The string all your Apprentice lessons will have in common. By default: yoursite.com/lessons/', 'thrive' ) . '"></span>',
		'appr_url_categories'               => __( 'URL Base for Apprentice Categories', 'thrive' ) . '<span class="tooltips" title="' . __( 'The string all your Apprentice categories will have in common. By default: yoursite.com/apprentice/', 'thrive' ) . '"></span>',
		'appr_url_tags'                     => __( 'URL Base for Apprentice Tags', 'thrive' ) . '<span class="tooltips" title="' . __( 'The string all your Apprentice tags will have in common. By default: yoursite.com/apprentice-tag/', 'thrive' ) . '"></span>',
		'blog_post_layout'                  => __( 'Default Blog Post Layout', 'thrive' ),


	);

	return $titles;
}

function _thrive_get_theme_options_sections_tooltips() {
	$titles = array(
		'meta_info_settings'  => '<span class="tooltips" title="' . __( 'These settings determine which meta elements are shown along with a blog post title.', 'thrive' ) . '"></span>',
		'social_sharing_data' => '<span class="tooltips" title="' . __( 'In this section you can set the default image that is shared on Facebook, Google+, Twitter and Pinterest when the visitor clicks one of the social media share buttons (for example, the Facebook like button) and there is more than one piece of content listed on the page. For individual posts and pages, you can set this by going to the Thrive Options in the Wordpress editor for each specific piece of content.', 'thrive' ) . '"></span>'
	);

	return $titles;
}

?>
