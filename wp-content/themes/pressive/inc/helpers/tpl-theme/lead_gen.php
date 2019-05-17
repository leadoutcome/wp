<?php if ( $top_section === false ) : ?>
	[page_section template="1" position="top" padding_bottom="on"][thrive_optin color="dark" text="GET INSTANT ACCESS" optin="<?php echo $optin_id ?>" size="medium" layout="horizontal"][/page_section]

	[thrive_testimonial name="John Doe" company="" image="" color="dark"]"Add a testimonial about how awesome your app is, here! Suspendisse sed nulla ut tellus ultrices pharetra. Etiam blandit est finibus tempor vulputate."[/thrive_testimonial]

<?php else : ?>
	[content_container max_width="950" align="center"][one_half_first]<img class="aligncenter size-full wp-image-181"
	                                                                       src="<?php echo $images_dir; ?>/notebook.png"
	                                                                       alt="notebook" width="629"
	                                                                       height="343"/>[/one_half_first][one_half_last]

	[blank_space height="1.5em"]
	<h1>Get Our Demo App!</h1>
	Sign up today to get free access to the demo version of our app and see the power of what it can do for your business with your own eyes.

	[blank_space height="1.5em"]

	<img class="alignnone wp-image-277 size-full" src="<?php echo $images_dir; ?>/platform-logos-2.png" alt=""
	     width="244" height="70"/>

	[/one_half_last][/content_container]
<?php endif ?>