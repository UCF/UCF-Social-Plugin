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
			if ( has_shortcode( $content, 'ucf-social-feed' ) || strpos( $content_processed, 'ucf-social-feed' ) !== false ) {
				$has_feed = true;
			}

			return $has_feed;
		}

		/**
		 * Retrieves data from Curator.io's API based on the API key provided
		 * in plugin options.
		 * Caches and references transient data.
		 *
		 * @author Jo Dickson
		 * @since 3.0.0
		 * @param string $feed_id | ID for a feed from curator.io
		 * @return mixed | array or WP_Error object on failure
		 */
		private static function get_social_feed_data() {
			$transient_name = 'ucf_social_curator_api_data';
			$result         = get_transient( $transient_name );

			if ( empty( $result ) ) {
				$api_key = get_option( UCF_Social_Config::$option_prefix . 'curator_api_key' );

				// Back out if we don't have an API key to use
				if ( empty( $api_key ) ) {
					return new WP_Error( 'ucf_social_invalid_curator_api_key', 'The Curator.io API key is either not set or is invalid.' );
				}

				$url           = 'https://api.curator.io/v1/feeds?api_key=' . $api_key;
				$response      = wp_remote_get( $url, array( 'timeout' => 15 ) );
				$response_code = wp_remote_retrieve_response_code( $response );

				// Decode the JSON response, or return an error if the response
				// is invalid
				if ( is_array( $response ) && is_int( $response_code ) && $response_code < 400 ) {
					$result = json_decode( wp_remote_retrieve_body( $response ) );
					set_transient( $transient_name, $result, 12 * HOUR_IN_SECONDS );
				}
				else {
					return new WP_Error( 'ucf_social_invalid_curator_api_response', 'The Curator.io API did not return a valid response. Make sure your Curator API key is valid, or wait and try again later.' );
				}
			}

			return $result;
		}

		/**
		 * Retrieves the container ID value for a given feed.
		 *
		 * @author Jo Dickson
		 * @since 3.0.0
		 * @param string $feed_id | ID for a feed from curator.io
		 * @return mixed | string or WP_Error object on failure
		 */
		public static function get_social_feed_container_id( $feed_id ) {
			$data = self::get_social_feed_data();
			$container_id = '';

			if ( !is_array( $data ) ) {
				return new WP_Error( 'ucf_social_invalid_curator_api_data', 'The Curator.io API data that was retrieved is not valid.' );
			}

			foreach ( $data as $feed_obj ) {
				if ( strtolower( $feed_obj->public_key ) === strtolower( $feed_id ) ) {
					$container_id = $feed_obj->slug;
					break;
				}
			}

			if ( empty( $container_id ) ) {
				return new WP_Error( 'ucf_social_invalid_curator_feed', 'The Curator.io feed ID provided is not valid.' );
			}

			return $container_id;
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
