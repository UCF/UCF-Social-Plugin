<?php

/**
 * Display the content before the social icons
 * @author RJ Bruneel
 * @since 1.0
 * @return string
 */
if ( ! function_exists( 'ucf_social_icons_display_default_before' ) ) {
	function ucf_social_icons_display_default_before( $content='', $atts ) {
		ob_start();
	?>
		<div class="ucf-social-icons">
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_icons_display_default_before', 'ucf_social_icons_display_default_before', 10, 2 );


/**
 * Display the social icons content
 * @author RJ Bruneel
 * @since 1.0
 * @param array $atts | Assoc. array of shortcode options
 * @return string
 */
if ( ! function_exists( 'ucf_social_icons_display_default' ) ) {
	function ucf_social_icons_display_default( $content='', $atts ) {
		$linkedin_url   = UCF_Social_Config::get_option_or_default( 'linkedin_url' );
		$twitter_url    = UCF_Social_Config::get_option_or_default( 'twitter_url' );
		$facebook_url   = UCF_Social_Config::get_option_or_default( 'facebook_url' );
		$instagram_url  = UCF_Social_Config::get_option_or_default( 'instagram_url' );
		$youtube_url    = UCF_Social_Config::get_option_or_default( 'youtube_url' );
		$tiktok_url     = UCF_Social_Config::get_option_or_default( 'tiktok_url' );

		ob_start();
	?>
		<?php if ( $facebook_url ) : ?>
			<a class="ucf-social-link btn-facebook <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $facebook_url; ?>">
				<svg class="ucf-social-icon" height="80px" width="80px" aria-hidden="true">
					<use href="#ucf-social-icons--facebook" />
				</svg>
				<span class="sr-only">Like us on Facebook</span>
			</a>
		<?php endif; ?>
		<?php if ( $twitter_url ) : ?>
			<a class="ucf-social-link btn-twitter <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $twitter_url; ?>">
				<svg class="ucf-social-icon" height="80px" width="80px" aria-hidden="true">
					<use href="#ucf-social-icons--twitter" />
				</svg>
				<span class="sr-only">Follow us on X</span>
			</a>
		<?php endif; ?>
		<?php if ( $instagram_url ) : ?>
			<a class="ucf-social-link btn-instagram <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $instagram_url; ?>">
				<svg class="ucf-social-icon" height="80px" width="80px" aria-hidden="true">
					<use href="#ucf-social-icons--instagram" />
				</svg>
				<span class="sr-only">Find us on Instagram</span>
			</a>
		<?php endif; ?>
		<?php if ( $linkedin_url ) : ?>
			<a class="ucf-social-link btn-linkedin <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $linkedin_url; ?>">
				<svg class="ucf-social-icon" height="80px" width="80px" aria-hidden="true">
					<use href="#ucf-social-icons--linkedin" />
				</svg>
				<span class="sr-only">View our LinkedIn page</span>
			</a>
		<?php endif; ?>
		<?php if ( $youtube_url ) : ?>
			<a class="ucf-social-link btn-youtube <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $youtube_url; ?>">
				<svg class="ucf-social-icon" height="80px" width="80px" aria-hidden="true">
					<use href="#ucf-social-icons--youtube" />
				</svg>
				<span class="sr-only">Follow us on YouTube</span>
			</a>
		<?php endif; ?>
		<?php if ( $tiktok_url ) : ?>
			<a class="ucf-social-link btn-tiktok <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $tiktok_url; ?>">
				<svg class="ucf-social-icon" height="80px" width="80px" aria-hidden="true">
					<use href="#ucf-social-icons--tiktok" />
				</svg>
				<span class="sr-only">Follow us on TikTok</span>
			</a>
		<?php endif; ?>
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_icons_display_default', 'ucf_social_icons_display_default', 10, 2 );


/**
 * Display the content after the social icons
 * @author RJ Bruneel
 * @since 1.0
 * @return string
 */
if ( ! function_exists( 'ucf_social_icons_display_default_after' ) ) {
	function ucf_social_icons_display_default_after( $content='', $atts ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
}

add_filter( 'ucf_social_icons_display_default_after', 'ucf_social_icons_display_default_after', 10, 2 );
