<?php

/**
 * Display the content before the social feed
 * @author RJ Bruneel
 * @since 1.0.4
 * @return string
 **/
if ( ! function_exists( 'ucf_social_feed_display_default_before' ) ) {
	function ucf_social_feed_display_default_before( $content='', $atts ) {
		ob_start();
	?>
		<aside class="ucf-social-feed ucf-social-feed-default <?php echo $atts['class']; ?>">
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_feed_display_default_before', 'ucf_social_feed_display_default_before', 10, 2 );


/**
 * Returns the social feed HTML for the default layout.
 * @author RJ Bruneel
 * @since 1.0.4
 * @param array $atts | contains the various elements of the social feed.
 * @return String
 **/
if ( ! function_exists( 'ucf_social_feed_display_default' ) ) {
	function ucf_social_feed_display_default( $content='', $atts ) {
		global $post;
		if ( !$post ) { return; }  // back out if there's no post data to reference

		$options = UCF_Social_Common::get_social_feed_options( $atts );

		ob_start();
	?>
		<div id="<?php echo $atts['container']; ?>"></div>
		<script type="text/javascript">
		$(function() {
			socialFeedInit('<?php echo $atts['container']; ?>', <?php echo $options; ?>);
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
	function ucf_social_feed_display_default_after( $content='', $atts ) {
		ob_start();
	?>
		</aside>
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_feed_display_default_after', 'ucf_social_feed_display_default_after', 10, 2 );
