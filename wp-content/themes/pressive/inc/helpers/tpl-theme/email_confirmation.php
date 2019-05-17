<?php if ( $top_section === false ) : ?>
	[one_third_first]<img class="aligncenter size-full wp-image-254" src="<?php echo $images_dir; ?>/email-1.png"
	                      alt="email-1" width="90" height="90"/>
	<h4 style="text-align: center;">Step 1</h4>
	<p style="text-align: center;">[thrive_text_block color="light" headline=""]Check the <strong>email inbox</strong>
		of the address that you used to sign up on the previous page.[/thrive_text_block]</p>
	[/one_third_first][one_third]<img class="aligncenter wp-image-256 size-full"
	                                  src="<?php echo $images_dir; ?>/email-2.png" alt="" width="90" height="90"/>
	<h4 style="text-align: center;">Step 2</h4>
	<p style="text-align: center;">[thrive_text_block color="light" headline=""]Find the email sent by <strong>[from
			name]</strong> with the subject line: <strong>[subject line here]</strong>.[/thrive_text_block]</p>
	[/one_third][one_third_last]<img class="aligncenter wp-image-257 size-full"
	                                 src="<?php echo $images_dir; ?>/email-3.png" alt="" width="90" height="90"/>
	<h4 style="text-align: center;">Step 3</h4>
	<p style="text-align: center;">[thrive_text_block color="light" headline=""]Open this email and <strong>click on the
			link inside</strong>. Done![/thrive_text_block]</p>
	[/one_third_last]

	[page_section template="1" position="bottom" padding_top="on"][content_container max_width="900" align="center"]Once you've completed these confirmation steps, you will get immediate access to the free product you signed up for![/content_container][/page_section]
<?php else : ?>
	[blank_space height="2em"]
	<h1 style="text-align: center;">Congratulations for Signing Up!</h1>
	[blank_space height="1em"]
	<h3 style="text-align: center;">Here are your <strong>important</strong> next steps:</h3>
	<p style="text-align: center;">To make sure we got the correct email address, we need you to click on a confirmation
		link in an email we just sent to you.</p>
<?php endif ?>