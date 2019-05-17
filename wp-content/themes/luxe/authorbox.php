<?php
$fname         = get_the_author_meta( 'first_name' );
$lname         = get_the_author_meta( 'last_name' );
$desc          = get_the_author_meta( 'description' );
$thrive_social = array_filter( array(
	"twt"  => get_the_author_meta( 'twitter' ),
	"fbk"  => get_the_author_meta( 'facebook' ),
	"lnk"  => get_the_author_meta( 'linkedin' ),
	"ggl"  => get_the_author_meta( 'gplus' ),
	"xing" => get_the_author_meta( 'xing' )
) );

$show_social_profiles = explode( ',', get_the_author_meta( 'show_social_profiles' ) );
$show_social_profiles = array_filter( $show_social_profiles );
if ( empty( $show_social_profiles ) ) { // back-compatibility
	$show_social_profiles = array( 'e', 'fbk', 'twt', 'ggl' );
}
$author_name      = get_the_author_meta( 'display_name' );
$display_name     = empty( $author_name ) ? $fname . " " . $lname : $author_name;
$has_social_links = false;
?>
<article>
	<div class="scn awr aut">
		<div class="left">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
			<ul class="left">
				<?php foreach ( $thrive_social as $service => $url ): ?>
					<?php if ( in_array( $service, $show_social_profiles ) || empty( $show_social_profiles[0] ) ):
						$has_social_links = true;
						$url = _thrive_get_social_link( $url, $service );

						?>
						<li>
							<a href="<?php echo $url; ?>" class="<?php echo $service; ?>" target="_blank">
								<?php if ( $service == "twt" ) { ?>
									<span class="awe">&#xe60a;</span>
								<?php } elseif ( $service == "fbk" ) { ?>
									<span class="awe">&#xe60b;</span>
								<?php } elseif ( $service == "ggl" ) { ?>
									<span class="awe">&#xe60c;</span>
								<?php } elseif ( $service == "lnk" ) { ?>
									<span class="awe">&#xe60e;</span>
								<?php } else { ?>
									<span class="awe">&#xf168;</span>
								<?php } ?>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="right <?php if ( ! $has_social_links ): ?>noSocial<?php endif; ?>">
			<h4><?php echo $display_name; ?></h4>
			<p>
				<?php echo $desc; ?>
			</p>
		</div>
		<div class="clear"></div>
	</div>
</article>

<div class="spr"></div>
