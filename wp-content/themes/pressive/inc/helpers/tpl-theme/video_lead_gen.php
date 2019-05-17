<?php if ( $top_section === false ) : ?>
	[page_section template="1" position="top" padding_bottom="on"][thrive_optin color="dark" text="GET INSTANT ACCESS" optin="<?php echo $optin_id; ?>" size="medium" layout="horizontal"][/page_section]

	[thrive_testimonial name="John Doe" company="" image="" color="dark"]"Add a testimonial about how awesome your app is, here! Suspendisse sed nulla ut tellus ultrices pharetra. Etiam blandit est finibus tempor vulputate."[/thrive_testimonial]
<?php else : ?>
	[content_container max_width="1000" align="center"][one_half_first]

	[blank_space height="1.5em"]
	<h1>Attention-Grabbing Headline <strong>Goes Here!</strong></h1>
	[divider style="left"]

	Sign up today to get free access to the demo version of our app and see the power of what it can do for your business with your own eyes.

	[/one_half_first][one_half_last][responsive_video type="youtube" hide_related="1" hide_logo="1" hide_controls="1" hide_title="1" hide_fullscreen="0" autoplay="0"]https://www.youtube.com/watch?v=DB2B58MrPMk[/responsive_video][/one_half_last][/content_container]
<?php endif ?>