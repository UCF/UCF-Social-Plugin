<?php

/**
 * Display the content before the social feed
 * @author RJ Bruneel
 * @since 1.0.4
 * @return string
 **/
if ( ! function_exists( 'ucf_social_feed_display_default_before' ) ) {
	function ucf_social_feed_display_default_before( $atts ) {
		ob_start();
	?>
		<aside class="ucf-social-feed <?php echo $atts['class']; ?>">
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_feed_display_default_before', 'ucf_social_feed_display_default_before', 10, 1 );


/**
 * Returns the social feed HTML for the default (waterfall) layout.
 * @author RJ Bruneel
 * @since 1.0.4
 * @param array $atts | contains the various elements of the social feed.
 * @return String
 **/
if ( ! function_exists( 'ucf_social_feed_display_default' ) ) {
	function ucf_social_feed_display_default( $content='', $atts ) {
		global $post;
		if ( !$post ) { return; }  // back out if there's no post data to reference

		ob_start();
	?>
		<div id="<?php echo $atts['container']; ?>"></div>
		<script type="text/javascript">
			$(function() {
				scrollToggleInit('<?php echo $atts['container']; ?>', () => {
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
			});
		</script>
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_feed_display_default', 'ucf_social_feed_display_default', 10, 2 );


/**
 * Display the content after the social feed
 * @author RJ Bruneel
 * @since 1.0.4
 * @return string
 **/
if ( ! function_exists( 'ucf_social_feed_display_default_after' ) ) {
	function ucf_social_feed_display_default_after( $atts ) {
		ob_start();
	?>
		</aside>
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_feed_display_default_after', 'ucf_social_feed_display_default_after', 10, 1 );
