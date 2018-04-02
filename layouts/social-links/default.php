<?php

/**
 * Content displayed before social links
 * @author Jo Dickson
 * @since 1.0.8
 * @param array $atts | shortcode attributes
 * @return String
 **/
if ( ! function_exists( 'ucf_social_links_display_default_before' ) ) {
	function ucf_social_links_display_default_before( $content='', $atts ) {
		ob_start();
	?>
		<aside class="ucf-social-links ucf-social-links-default">
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_links_display_default_before', 'ucf_social_links_display_default_before', 10, 2 );


/**
 * Social link (e.g. like/share links) content
 * @author Jo Dickson
 * @since 1.0.8
 * @param array $atts | shortcode attributes
 * @return String
 **/
if ( ! function_exists( 'ucf_social_links_display_default' ) ) {
	function ucf_social_links_display_default( $content='', $atts ) {
		$permalink = substr( urlencode( $atts['permalink'] ), 0, 1024 );
		$share_text = substr( urlencode( $atts['share_text'] ), 0, 200 );
		$share_text_email = esc_attr( $atts['share_text'] );
		$site_title_email = esc_attr( get_bloginfo( 'site_title' ) );

		ob_start();
	?>
		<?php if ( $atts['facebook'] ): ?>
		<a class="btn btn-facebook color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" title="Like this content on Facebook">
			<span class="fa fa-facebook" aria-hidden="true"></span><span class="btn-text">Like</span>
		</a>
		<?php endif; ?>

		<?php if ( $atts['twitter'] ): ?>
		<a class="btn btn-twitter color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $share_text; ?>&amp;url=<?php echo $permalink; ?>" title="Tweet this content">
			<span class="fa fa-twitter" aria-hidden="true"></span><span class="btn-text">Tweet</span>
		</a>
		<?php endif; ?>

		<?php if ( $atts['google'] ): ?>
		<a class="btn btn-google color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://plus.google.com/share?url=<?php echo $permalink; ?>" title="Share this content on Google+">
			<span class="fa fa-google-plus" aria-hidden="true"></span><span class="btn-text">Share</span>
		</a>
		<?php endif; ?>

		<?php if ( $atts['linkedin'] ): ?>
		<a class="btn btn-linkedin color btn-<?php echo $atts['size']; ?>" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $share_text; ?>" title="Share this content on LinkedIn">
			<span class="fa fa-linkedin-square" aria-hidden="true"></span><span class="btn-text">Share</span>
		</a>
		<?php endif; ?>

		<?php if ( $atts['email'] ): ?>
		<a class="btn btn-email color btn-<?php echo $atts['size']; ?>" target="_blank" href="mailto:?subject=<?php echo $share_text_email; ?>&amp;body=Check out this page from <?php echo $site_title_email; ?>:%0A%0A<?php echo $share_text_email; ?>%0A<?php echo $permalink; ?>" title="Share this content via email">
			<span class="fa fa-envelope" aria-hidden="true"></span><span class="btn-text">Email</span>
		</a>
		<?php endif; ?>
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_links_display_default', 'ucf_social_links_display_default', 10, 2 );


/**
 * Content displayed after social links
 * @author Jo Dickson
 * @since 1.0.8
 * @param array $atts | shortcode attributes
 * @return String
 **/
if ( ! function_exists( 'ucf_social_links_display_default_after' ) ) {
	function ucf_social_links_display_default_after( $content='', $atts ) {
		ob_start();
	?>
		</aside>
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_links_display_default_after', 'ucf_social_links_display_default_after', 10, 2 );

