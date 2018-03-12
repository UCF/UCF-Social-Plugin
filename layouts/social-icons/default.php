<?php

/**
* Display the content before the social icons
* @author RJ Bruneel
* @since 1.0
* @return string
**/
if ( ! function_exists( 'ucf_social_icons_display_default_before' ) ) {
	function ucf_social_icons_display_default_before( $atts ) {
		ob_start();
	?>
		<div class="ucf-social-icons">
	<?php
		return ob_get_clean();
	}
}

/**
* Display the social icons content
* @author RJ Bruneel
* @since 1.0
* @param array $atts | Assoc. array of shortcode options
* @return string
**/
if ( ! function_exists( 'ucf_social_icons_display_default' ) ) {
	function ucf_social_icons_display_default( $atts ) {
		$google_url     = UCF_Social_Config::get_option_or_default( 'google_url' );
		$linkedin_url   = UCF_Social_Config::get_option_or_default( 'linkedin_url' );
		$twitter_url    = UCF_Social_Config::get_option_or_default( 'twitter_url' );
		$facebook_url   = UCF_Social_Config::get_option_or_default( 'facebook_url' );
		$instagram_url  = UCF_Social_Config::get_option_or_default( 'instagram_url' );
		$youtube_url    = UCF_Social_Config::get_option_or_default( 'youtube_url' );

		ob_start();
	?>
		<?php if ( $google_url ) : ?>
			<a class="ucf-social-link btn-google <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $google_url; ?>">
				<span class="fa fa-google-plus" aria-hidden="true"></span>
				<p class="sr-only">Follow us on Google+</p>
			</a>
		<?php endif; ?>
		<?php if ( $linkedin_url ) : ?>
			<a class="ucf-social-link btn-linkedin <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $linkedin_url; ?>">
				<span class="fa fa-linkedin" aria-hidden="true"></span>
				<p class="sr-only">View our LinkedIn page</p>
			</a>
		<?php endif; ?>
		<?php if ( $twitter_url ) : ?>
			<a class="ucf-social-link btn-twitter <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $twitter_url; ?>">
				<span class="fa fa-twitter" aria-hidden="true"></span>
				<p class="sr-only">Follow us on Twitter</p>
			</a>
		<?php endif; ?>
		<?php if ( $facebook_url ) : ?>
			<a class="ucf-social-link btn-facebook <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $facebook_url; ?>">
				<span class="fa fa-facebook" aria-hidden="true"></span>
				<p class="sr-only">Like us on Facebook</p>
			</a>
		<?php endif; ?>
		<?php if ( $instagram_url ) : ?>
			<a class="ucf-social-link btn-instagram <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $instagram_url; ?>">
				<span class="fa fa-instagram" aria-hidden="true"></span>
				<p class="sr-only">Find us on Instagram</p>
			</a>
		<?php endif; ?>
		<?php if ( $youtube_url ) : ?>
			<a class="ucf-social-link btn-youtube <?php echo $atts['size'] . ' ' . $atts['color']; ?>" target="_blank" href="<?php echo $youtube_url; ?>">
				<span class="fa fa-youtube" aria-hidden="true"></span>
				<p class="sr-only">Follow us on YouTube</p>
			</a>
		<?php endif; ?>
	<?php
		return ob_get_clean();
	}
}

/**
* Display the content after the social icons
* @author RJ Bruneel
* @since 1.0
* @return string
**/
if ( ! function_exists( 'ucf_social_icons_display_default_after' ) ) {
	function ucf_social_icons_display_default_after( $atts ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
}
