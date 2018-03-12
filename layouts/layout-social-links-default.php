<?php
/**
 * TODO
 * @author Jo Dickson
 * @since 1.0.8
 * @param array $atts | shortcode attributes
 * @return String
 **/
function ucf_social_links_display_default_before( $atts ) {
	ob_start();
?>
	<aside class="ucf-social-links ucf-social-links-default">
<?php
	echo ob_get_clean();
}

add_filter( 'ucf_social_links_display_default_before', 'ucf_social_links_display_default_before', 10, 1 );


/**
 * TODO
 * @author Jo Dickson
 * @since 1.0.8
 * @param array $atts | shortcode attributes
 * @return String
 **/
function ucf_social_links_display_default( $content='', $atts ) {
	global $post;
	if ( !$post ) { return; }  // back out if there's no post data to reference
	$permalink = urlencode( get_permalink( $post->ID ) );

	ob_start();
?>
	<a class="btn btn-facebook color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" title="Like this story on Facebook">
		<span class="fa fa-facebook"></span> Like
	</a>
	<a class="btn btn-twitter color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo $permalink; ?>" title="Tweet this story">
		<span class="fa fa-twitter"></span> Tweet
	</a>
	<a class="btn btn-google color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://plus.google.com/share?url=<?php echo $permalink; ?>" title="Share this story on Google+">
		<span class="fa fa-google-plus"></span> Share
	</a>
<?php
	echo ob_get_clean();
}

add_filter( 'ucf_social_links_display_default', 'ucf_social_links_display_default', 10, 2 );

/**
 * TODO
 * @author Jo Dickson
 * @since 1.0.8
 * @param array $atts | shortcode attributes
 * @return String
 **/
function ucf_social_links_display_default_after( $atts ) {
	ob_start();
?>
	</aside>
<?php
	echo ob_get_clean();
}

add_filter( 'ucf_social_links_display_default_after', 'ucf_social_links_display_default_after', 10, 1 );

