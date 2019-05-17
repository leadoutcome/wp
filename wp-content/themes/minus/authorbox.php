<?php
$fname         = get_the_author_meta( 'first_name' );
$lname         = get_the_author_meta( 'last_name' );
$desc          = get_the_author_meta( 'description' );
$thrive_social = array_filter( array(
	"twt" => get_the_author_meta( 'twitter' ),
	"fbk" => get_the_author_meta( 'facebook' ),
	"ggl" => get_the_author_meta( 'gplus' )
) );

$author_name  = get_the_author_meta( 'display_name' );
$display_name = empty( $author_name ) ? $fname . " " . $lname : $author_name;
?>
<article>
	<div class="awr cat">
		<div class="left">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 72 ); ?>
			</a>
			<div class="clear"></div>
		</div>
		<div class="right">
			<h6><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo $display_name; ?></a></h6>
			<p>
				<?php echo $desc; ?>
			</p>
		</div>
		<div class="clear"></div>
	</div>
</article>
<div class="spr"></div>
