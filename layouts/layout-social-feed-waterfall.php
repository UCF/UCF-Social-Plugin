<?php
/**
 * Returns the social feed HTML for the waterfall layout.
 * @author RJ Bruneel
 * @since 1.0.4
 * @param array $atts | contains the various elements of the social feed.
 * @return String
 **/
function ucf_social_feed_display_waterfall( $content='', $atts ) {
	ob_start();
?>
	<div id="<?php echo $atts['container']; ?>"></div>
	<script type="text/javascript">
		$(function() {
			var widget = new Curator.Waterfall({
				container:'#<?php echo $atts['container']; ?>',
				feedId:'<?php echo $atts['feed']; ?>',
			<?php if($atts['grid-width'] > 0) : ?>
				waterfall: {
					gridWidth:<?php echo $atts['grid-width']; ?>
				}
			<?php endif; ?>
			});
		});
	</script>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_social_feed_display_waterfall', 'ucf_social_feed_display_waterfall', 10, 2 );
?>
