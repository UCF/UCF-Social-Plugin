<?php
/**
 * Place common functions here.
 **/

if ( ! class_exists( 'UCF_Social_Common' ) ) {
	class UCF_Social_Common {

		/**
		 * Displays the social icons
		 * @author RJ Bruneel
		 * @since 1.0
		 * @param array $atts | Assoc. array of shortcode options
		 * @return string
		 **/
		public static function display_social_icons( $atts ) {
			$before = ucf_social_icons_display_default_before( '', $atts );
			if ( has_filter( 'ucf_social_icons_display_' . $atts['layout'] . '_before' ) ) {
				$before = apply_filters( 'ucf_social_icons_display_' . $atts['layout'] . '_before', $before, $atts );
			}

			$content = ucf_social_icons_display_default( '', $atts );
			if ( has_filter( 'ucf_social_icons_display_' . $atts['layout'] ) ) {
				$content = apply_filters( 'ucf_social_icons_display_' . $atts['layout'], $content, $atts );
			}

			$after = ucf_social_icons_display_default_after( '', $atts );
			if ( has_filter( 'ucf_social_icons_display_' . $atts['layout'] . '_after' ) ) {
				$after = apply_filters( 'ucf_social_icons_display_' . $atts['layout'] . '_after', $after, $atts );
			}

			return $before . $content . $after;
		}

		/**
		* Displays the social links
		* @author RJ Bruneel
		* @since 1.0
		* @param array $atts | Assoc. array of shortcode options
		* @return string
		**/
		public static function display_social_links( $atts ) {
			$before = ucf_social_links_display_default_before( '', $atts );
			if ( has_filter( 'ucf_social_links_display_' . $atts['layout'] . '_before' ) ) {
				$before = apply_filters( 'ucf_social_links_display_' . $atts['layout'] . '_before', $before, $atts );
			}

			$content = ucf_social_links_display_default( '', $atts );
			if ( has_filter( 'ucf_social_links_display_' . $atts['layout'] ) ) {
				$content = apply_filters( 'ucf_social_links_display_' . $atts['layout'], $content, $atts );
			}

			$after = ucf_social_links_display_default_after( '', $atts );
			if ( has_filter( 'ucf_social_links_display_' . $atts['layout'] . '_after' ) ) {
				$after = apply_filters( 'ucf_social_links_display_' . $atts['layout'] . '_after', $after, $atts );
			}

			return $before . $content . $after;
		}

		/**
		* Displays the social feed
		* @author RJ Bruneel
		* @since 1.0.4
		* @param array $atts | Assoc. array of shortcode options
		* @return string
		**/
		public static function display_social_feed( $atts ) {
			$before = ucf_social_feed_display_default_before( '', $atts );
			if ( has_filter( 'ucf_social_feed_display_' . $atts['layout'] . '_before' ) ) {
				$before = apply_filters( 'ucf_social_feed_display_' . $atts['layout'] . '_before', $before, $atts );
			}

			$content = ucf_social_feed_display_default( '', $atts );
			if ( has_filter( 'ucf_social_feed_display_' . $atts['layout'] ) ) {
				$content = apply_filters( 'ucf_social_feed_display_' . $atts['layout'], $content, $atts );
			}

			$after = ucf_social_feed_display_default_after( '', $atts );
			if ( has_filter( 'ucf_social_feed_display_' . $atts['layout'] . '_after' ) ) {
				$after = apply_filters( 'ucf_social_feed_display_' . $atts['layout'] . '_after', $after, $atts );
			}

			return $before . $content . $after;
		}

		/**
		 * Determines whether the provided content contains a [ucf-social-feed]
		 * shortcode.
		 * @author Jo Dickson
		 * @since 1.0.6
		 * @param string $content | arbitrary string of content
		 * @return boolean
		 */
		public static function has_social_feed( $content ) {
			$has_feed = false;
			ob_start();
			echo do_shortcode( $content );
			$content_processed = ob_get_clean();

			// Check against unprocessed string contents for the
			// [ucf-social-feed] shortcode, as well as processed string
			// contents for substrings that are likely to be present in social
			// feed templates
			if (
				has_shortcode( $content, 'ucf-social-feed' )
				|| ( strpos( $content_processed, 'new Curator.' ) !== false || strpos( $content_processed, 'ucf-social-feed' ) !== false )
			) {
				$has_feed = true;
			}

			return $has_feed;
		}

		/**
		 * TODO Retrieves the container ID value for a given feed.
		 *
		 * @author Jo Dickson
		 * @since 3.0.0
		 * @param string $feed_id | ID for a feed from curator.io
		 * @return string
		 */
		public static function get_social_feed_container_id( $feed_id ) {
			return 'curator-feed';
		}

	}
}


/**
 * Enqueue css assets for the plugin
 * @author RJ Bruneel
 * @since 1.0
 **/
if ( ! function_exists( 'ucf_social_enqueue_assets' ) ) {
	function ucf_social_enqueue_assets() {
		global $post;

		$include_css = UCF_Social_Config::get_option_or_default( 'include_css' );
		if ( $include_css ) {
			wp_enqueue_style( 'ucf_social_css', plugins_url( 'static/css/ucf-social.min.css', UCF_SOCIAL__PLUGIN_FILE ), false, false, 'all' );
		}

		if ( is_a( $post, 'WP_Post' ) && UCF_Social_Common::has_social_feed( $post->post_content ) ) {
			wp_enqueue_script( 'ucf_social_curator_js', plugins_url( 'static/js/ucf-social.min.js', UCF_SOCIAL__PLUGIN_FILE ), false, false, true );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'ucf_social_enqueue_assets' );
