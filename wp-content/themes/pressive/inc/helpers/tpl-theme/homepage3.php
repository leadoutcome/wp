<?php if ( $top_section === false ) : ?>
	[page_section template="1" position="top" padding_bottom="on"]
	<p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc imperdiet sem in lorem
		vestibulum, eu condimentum massa tempus. Praesent sit amet odio pulvinar, lacinia ante at, tincidunt lectus.
		Nullam egestas bibendum ante, ut volutpat tellus feugiat non. Morbi nec diam blandit arcu sodales tristique.</p>
	<p style="text-align: center;">[thrive_optin color="dark" text="Sign Up Today!" optin="<?php echo $optin_id; ?>"
		size="big" layout="horizontal"]</p>
	[/page_section]

	[thrive_posts_gallery title="Latest Posts" no_posts="6" filter="recent"]

	[thrive_posts_gallery title="Greatest Hits" no_posts="3" filter="popular"]

	[page_section template="1" position="bottom" padding_top="on"]
	<h2><img class="alignright size-thumbnail wp-image-249" src="<?php echo $images_dir; ?>/person-2-150x150.png"
	         alt="person-2" width="150" height="150"/>Sign Up &amp; Join Over 20,000 Happy Subscribers!</h2>
	Praesent posuere tincidunt accumsan. Suspendisse aliquet mauris consequat, rutrum sem in, varius augue. Nunc consequat nisi eget consectetur euismod. Aenean ultrices ante egestas, luctus libero convallis, pretium urna.

	[thrive_optin color="dark" text="Sign Up Today!" optin="<?php echo $optin_id; ?>" size="big" layout="horizontal"]

	[/page_section]
<?php else : ?>
	[blank_space height="1em"]
	<h1 style="text-align: center; font-size:62px;">Describe Your Main Selling Point Here</h1>
	<img src="<?php echo $images_dir; ?>/person-2-150x150.png" alt="person-2" width="150" height="150"
	     class="aligncenter size-thumbnail wp-image-249"/>
	<p style="text-align: center; font-size:24px;">What is it that you do? What makes your site different from others?
		Why should a new visitor care? Describe it here, as clearly as possible.</p>
	[blank_space height="1em"]
<?php endif ?>