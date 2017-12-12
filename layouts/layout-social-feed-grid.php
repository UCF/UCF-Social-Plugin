<?php
/**
 * Returns the social feed HTML for the grid layout.
 * @author RJ Bruneel
 * @since 1.0.4
 * @param array $atts | contains the various elements of the social feed.
 * @return String
 **/
function ucf_social_feed_display_grid( $content='', $atts ) {
	ob_start();
?>
	<div id="<?php echo $atts['container']; ?>"></div>
	<script type="text/javascript">
		$(function() {
			var widget = new Curator.Grid({
				container:'#<?php echo $atts['container']; ?>',
				feedId:'<?php echo $atts['feed']; ?>',
				grid: {
					minWidth:<?php echo $atts['grid-width']; ?>,
					rows: <?php echo $atts['grid-rows']; ?>
				}
			});
		});
	</script>
<?php
	return ob_get_clean();
}

add_filter( 'ucf_social_feed_display_grid', 'ucf_social_feed_display_grid', 10, 2 );
?>
