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
			$before  = apply_filters( 'ucf_social_icons_display_' . $atts['layout'] . '_before', '', $atts );
			$content = apply_filters( 'ucf_social_icons_display_' . $atts['layout'], '', $atts );
			$after   = apply_filters( 'ucf_social_icons_display_' . $atts['layout'] . '_after', '', $atts );

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
			$before  = apply_filters( 'ucf_social_links_display_' . $atts['layout'] . '_before', '', $atts );
			$content = apply_filters( 'ucf_social_links_display_' . $atts['layout'], '', $atts );
			$after   = apply_filters( 'ucf_social_links_display_' . $atts['layout'] . '_after', '', $atts );

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
			self::enqueue_feed_scripts();

			$before  = apply_filters( 'ucf_social_feed_display_' . $atts['layout'] . '_before', '', $atts );
			$content = apply_filters( 'ucf_social_feed_display_' . $atts['layout'], '', $atts );
			$after   = apply_filters( 'ucf_social_feed_display_' . $atts['layout'] . '_after', '', $atts );

			return $before . $content . $after;
		}

		/**
		 * Allow extra file types to be uploaded to the media library.
		 * @author Jim Barnes
		 * @since 3.0.0
		 * @param array $mimes The array of mime types allowed to be uploaded to wp media
		 * @return array The modified array of mime types
		 */
		public static function custom_mimes( $mimes ) {
			if ( ! key_exists( 'json', $mimes ) ) {
				$mimes['json'] = 'application/json';
			}
			return $mimes;
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

			// Check against unprocessed string contents for the
			// [ucf-social-feed] shortcode, as well as processed string
			// contents for substrings that are likely to be present in social
			// feed templates
			if ( has_shortcode( $content, 'ucf-social-feed' ) || strpos( $content, 'ucf-social-feed' ) !== false ) {
				$has_feed = true;
			}

			return $has_feed;
		}

		/**
		 * Returns a JSON object from the provided URL.  Detects undesirable status
		 * codes and returns false if the response doesn't look valid.
		 *
		 * @since 3.0.0
		 * @author Jo Dickson
		 * @param string $url URL that points to a JSON object/feed
		 * @return mixed JSON-decoded object or false on failure
		 */
		private static function fetch_json( $url ) {
			$response      = wp_remote_get( $url, array( 'timeout' => 5 ) );
			$response_code = wp_remote_retrieve_response_code( $response );
			$result        = false;

			if ( is_array( $response ) && is_int( $response_code ) && $response_code < 400 ) {
				$result = json_decode( wp_remote_retrieve_body( $response ) );
			}

			return $result;
		}

		/**
		 * Retrieves data from Curator.io's API based on the API key provided
		 * in plugin options.
		 * Caches and references transient data.
		 *
		 * @author Jo Dickson
		 * @since 3.0.0
		 * @return array
		 */
		public static function get_social_feed_data() {
			$transient_name = UCF_Social_Config::$curator_data_transient;
			$transient      = get_transient( $transient_name );
			$result         = array();

			if ( $transient === false ) {
				$api_key = get_option( UCF_Social_Config::$option_prefix . 'curator_api_key' );

				// Back out if we don't have an API key to use
				if ( empty( $api_key ) ) {
					return $result;
				}

				$url = 'https://api.curator.io/v1/feeds?api_key=' . $api_key;
				$response = self::fetch_json( $url );

				if ( $response ) {
					$result = $response;
					set_transient( $transient_name, $result, 12 * HOUR_IN_SECONDS );
				}
			}
			else if ( is_array( $transient ) ) {
				$result = $transient;
			}

			return $result;
		}

		/**
		 * Retrieves options set on the given feed within Curator.io.
		 *
		 * @author Jo Dickson
		 * @since 3.0.0
		 * @param string $feed_id | ID for a feed from curator.io
		 * @return object
		 */
		private static function get_social_feed_option_data( $feed_id ) {
			$data = self::get_social_feed_data();
			$options_str = '{}';
			$options = null;

			foreach ( $data as $feed_obj ) {
				if ( strtolower( $feed_obj->public_key ) === strtolower( $feed_id ) ) {
					$options_str = $feed_obj->widget_options;
					break;
				}
			}

			$options = json_decode( $options_str );

			// Handle decoding errors and/or if $options is null
			if ( JSON_ERROR_NONE !== json_last_error() || $options === null ) {
				$options = (object)[];
			}

			return $options;
		}

		/**
		 * Retrieves a merged option set for a Curator.io widget, suitable
		 * for passing to the widget JS directly.
		 *
		 * @author Jo Dickson
		 * @since 3.0.0
		 * @param array $sc_atts | [ucf-social-feed] shortcode attributes
		 * @return object
		 */
		public static function get_social_feed_options( $sc_atts ) {
			$feed_id          = $sc_atts['feed'];
			$type_default     = UCF_Social_Config::get_option_or_default( 'curator_default_type' );
			$type             = ucfirst( $sc_atts['type'] );
			$container_id     = $sc_atts['container'];
			$option_file_attr = $sc_atts['options_file'];
			$option_file      = '';

			$base_options     = array( 'type' => $type_default, 'feedId' => $feed_id );
			$data_options     = (array) self::get_social_feed_option_data( $feed_id );
			$file_options     = array();
			$core_options     = array( 'container' => '#' . $container_id );

			if ( !empty( $option_file_attr ) ) {
				// If the option file value looks like an attachment ID,
				// fetch the attachment url
				if ( is_numeric( $option_file_attr ) ) {
					$option_file_attr = wp_get_attachment_url( intval( $option_file_attr ) );
				}

				if ( $option_file_attr ) {
					$option_file = self::fetch_json( $option_file_attr );
					if ( $option_file ) {
						$file_options = (array) $option_file;
					}
				}
			}

			if ( !empty( $type ) ) {
				$core_options['type'] = $type;
			}

			return json_encode( array_merge( $base_options, $data_options, $file_options, $core_options ) );
		}

		/**
		 * Registers frontend static assets
		 *
		 * @since 3.0.6
		 * @author Jo Dickson
		 * @return void
		 */
		public static function register_assets() {
			// Backward compatibility: if this function is defined
			// (plugged) in a theme/plugin, just call it instead:
			if ( function_exists( 'ucf_social_enqueue_assets' ) ) return ucf_social_enqueue_assets();

			global $post;

			$plugin_data = get_plugin_data( UCF_SOCIAL__PLUGIN_FILE, false, false );
			$version     = $plugin_data['Version'];

			$css_deps = array();
			$js_deps  = array( 'jquery' );

			$curator_widget_version = UCF_Social_Config::get_option_or_default( 'curator_widget_version' );
			$curator_widget_version = trim( $curator_widget_version );
			if ( ! empty( $curator_widget_version ) ) {
				$curator_css_url = 'https://cdn.curator.io/' . $curator_widget_version . '/css/curator.css';
				$curator_js_url  = 'https://cdn.curator.io/' . $curator_widget_version . '/js/curator.js';

				// Try to conditionally load Curator CSS as best as we can.
				// NOTE: we currently *only* check post content
				// for social feeds.
				if ( is_a( $post, 'WP_Post' ) && self::has_social_feed( $post->post_content ) ) {
					$css_deps[] = 'ucf_social_curator_css';
					wp_register_style( 'ucf_social_curator_css', $curator_css_url, false, false, 'all' );
				}

				// JS is late-enqueued, so, always register here regardless of
				// has_social_feed() value:
				$js_deps[] = 'ucf_social_curator';
				wp_register_script( 'ucf_social_curator', $curator_js_url, false, false, true );
			}

			$include_css = UCF_Social_Config::get_option_or_default( 'include_css' );
			if ( $include_css ) {
				wp_register_style( 'ucf_social_css', UCF_SOCIAL__STYLES_URL . '/ucf-social.min.css', $css_deps, $version, 'all' );
			}

			wp_register_script( 'ucf_social_curator_js', UCF_SOCIAL__SCRIPT_URL . '/ucf-social.min.js', $js_deps, $version, true );
		}

		/**
		 * Enqueues frontend CSS
		 *
		 * @since 3.0.6
		 * @author Jo Dickson
		 * @return void
		 */
		public static function enqueue_styles() {
			// Backward compatibility: if this function is defined
			// (plugged) in a theme/plugin, back out early:
			if ( function_exists( 'ucf_social_enqueue_assets' ) ) return;

			if ( wp_style_is( 'ucf_social_css', 'registered' ) ) {
				wp_enqueue_style( 'ucf_social_css' );
			}
		}

		/**
		 * Enqueues frontend JS for social feeds.
		 *
		 * @since 3.0.6
		 * @author Jo Dickson
		 * @return void
		 */
		public static function enqueue_feed_scripts() {
			// Backward compatibility: if this function is defined
			// (plugged) in a theme/plugin, back out early:
			if ( function_exists( 'ucf_social_enqueue_assets' ) ) return;

			wp_enqueue_script( 'ucf_social_curator_js' );
		}

		/**
		 * Enqueues Curator.io widget CSS and JS. Does not include
		 * plugin-specific JS.
		 *
		 * @author Jo Dickson
		 * @since 3.0.0
		 * @deprecated Deprecated since 3.0.6; UCF_Social_Common::register_assets() takes care of this for you
		 * @return void
		 */
		public static function enqueue_curator_widget_assets() {
			$widget_version = UCF_Social_Config::get_option_or_default( 'curator_widget_version' );
			$widget_version = trim( $widget_version );
			if ( !empty( $widget_version ) ) {
				$css_url = 'https://cdn.curator.io/' . $widget_version . '/css/curator.css';
				$js_url  = 'https://cdn.curator.io/' . $widget_version . '/js/curator.js';

				wp_enqueue_style( 'ucf_social_curator_css', $css_url, false, false, 'all' );
				wp_enqueue_script( 'ucf_social_curator', $js_url, false, false, true );
			}
		}

	}
}

/**
 * Register assets
 */
add_action( 'wp_enqueue_scripts', array( 'UCF_Social_Common', 'register_assets' ), 10, 0 );
add_action( 'wp_enqueue_scripts', array( 'UCF_Social_Common', 'enqueue_styles' ), 11, 0 );

/**
 * Add hook to allow for json uploads
 */
add_filter( 'upload_mimes', array( 'UCF_Social_Common', 'custom_mimes' ), 10, 1 );
