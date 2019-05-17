<?php
$downloadLinksJson    = get_post_meta( get_the_ID(), '_thrive_meta_appr_download_links', true );
$downloadLinksArray   = json_decode( $downloadLinksJson, true );
$downloadLinksHeading = thrive_get_theme_options( "appr_download_heading" );

$listContainerClass = "";
?>

<?php if ( is_array( $downloadLinksArray ) && count( $downloadLinksArray ) > 0 ): ?>

	<?php if ( ! empty( $downloadLinksHeading ) ): ?>
		<h3><?php echo $downloadLinksHeading; ?></h3>
	<?php endif; ?>

	<div class="apd">
		<?php foreach ( $downloadLinksArray as $link ): ?>
			<?php
			switch ( $link['icon'] ):
				case 'document':
					$listContainerClass = "adci";
					break;
				case 'audio':
					$listContainerClass = "aaud";
					break;
				case 'video':
					$listContainerClass = "avdi";
					break;
				case 'link':
					$listContainerClass = "adwn";
					break;
				default:
					$listContainerClass = "agls";
			endswitch;
			?>
			<a class="apl" href="<?php echo $link['link_url']; ?>"
			   <?php if ( $link['new_tab'] == 1 ): ?>target="_blank"<?php endif; ?>>
				<div class="api">
                    <span class="<?php echo $listContainerClass; ?>">

                    </span>
				</div>
				<p><span><?php echo $link['link_text']; ?></span></p>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>