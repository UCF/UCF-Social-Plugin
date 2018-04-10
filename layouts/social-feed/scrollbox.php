<?php

/**
 * Display the content before the social feed
 * @author Jo Dickson
 * @since 3.0.0
 * @return string
 **/
if ( ! function_exists( 'ucf_social_feed_display_scrollbox_before' ) ) {
	function ucf_social_feed_display_scrollbox_before( $content='', $atts ) {
		ob_start();
	?>
		<aside class="ucf-social-feed ucf-social-feed-scrollbox ucf-social-feed-scrollbox-md <?php echo $atts['class']; ?>" id="<?php echo $atts['id']; ?>">
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_feed_display_scrollbox_before', 'ucf_social_feed_display_scrollbox_before', 10, 2 );
