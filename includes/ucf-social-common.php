<?php
/**
 * Place common functions here.
 **/

if ( ! class_exists( 'UCF_Social_Common' ) ) {
	class UCF_Social_Common {

		/**
		* Displays the social social icons
		* @author RJ Bruneel
		* @since 1.0
		* @param array $atts | Assoc. array of shortcode options
		* @return string
		**/
		public static function display_social_icons( $atts ) {
				$before = self::ucf_social_icons_display_before( $atts );
				if ( has_filter( 'ucf_social_display_before' ) ) {
					$before = apply_filters( 'ucf_social_display_before', $before, $atts );
				}

				$content = self::ucf_social_icons_display( $atts );
				if ( has_filter( 'ucf_social_display' ) ) {
					$content = apply_filters( 'ucf_social_display', $content, $atts );
				}

				$after = self::ucf_social_icons_display_after( $atts );
				if ( has_filter( 'ucf_social_display_after' ) ) {
					$after = apply_filters( 'ucf_social_display_after', $after, $atts );
				}

				return $before . $content . $after;

		}

		/**
		* Display the content before the social icons
		* @author RJ Bruneel
		* @since 1.0
		* @return string
		**/
		function ucf_social_icons_display_before( $atts ) {
			ob_start();
		?>
			<div class="ucf-social-icons">
		<?php
			echo ob_get_clean();
		}

		/**
		* Display the social icons content
		* @author RJ Bruneel
		* @since 1.0
		* @param array $atts | Assoc. array of shortcode options
		* @return string
		**/
		function ucf_social_icons_display( $atts ) {
				$atts = shortcode_atts( array(
					'size'  => 'md',
					'color' => 'color'
				), $atts );

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
			echo ob_get_clean();
		}

		/**
		* Display the content after the social icons
		* @author RJ Bruneel
		* @since 1.0
		* @return string
		**/
		function ucf_social_icons_display_after( $atts ) {
			ob_start();
		?>
			</div>
		<?php
			echo ob_get_clean();
		}

		/**
		* Enqueue css for the social icons
		* @author RJ Bruneel
		* @since 1.0
		* @return string
		**/
		function add_css() {
			// CSS
			$include_css = UCF_social_Config::get_option_or_default( 'include_css' );
			$css_deps = apply_filters( 'ucf_social_style_deps', array() );

			if ( $include_css ) {
				wp_enqueue_style( 'ucf_social_css', plugins_url( 'static/css/ucf-social.min.css', UCF_SOCIAL__PLUGIN_FILE ), $css_deps, false, 'screen' );
			}
		}
	}
	add_action( 'wp_enqueue_scripts', array( 'UCF_Social_Common', 'add_css' ) );
}
