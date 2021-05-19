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
			add_filter( 'ucf_social_has_social_icons', '__return_true' );

			$before  = apply_filters(
				'ucf_social_icons_display_' . $atts['layout'] . '_before',
				ucf_social_icons_display_default_before( '', $atts ),
				$atts
			);
			$content = apply_filters(
				'ucf_social_icons_display_' . $atts['layout'],
				ucf_social_icons_display_default( '', $atts ),
				$atts
			);
			$after   = apply_filters(
				'ucf_social_icons_display_' . $atts['layout'] . '_after',
				ucf_social_icons_display_default_after( '', $atts ),
				$atts
			);

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
			add_filter( 'ucf_social_has_social_links', '__return_true' );

			$before  = apply_filters(
				'ucf_social_links_display_' . $atts['layout'] . '_before',
				ucf_social_links_display_default_before( '', $atts ),
				$atts
			);
			$content = apply_filters(
				'ucf_social_links_display_' . $atts['layout'],
				ucf_social_links_display_default( '', $atts ),
				$atts
			);
			$after   = apply_filters(
				'ucf_social_links_display_' . $atts['layout'] . '_after',
				ucf_social_links_display_default_after( '', $atts ),
				$atts
			);

			return $before . $content . $after;
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

			$plugin_data = get_plugin_data( UCF_SOCIAL__PLUGIN_FILE, false, false );
			$version     = $plugin_data['Version'];

			$include_css = UCF_Social_Config::get_option_or_default( 'include_css' );
			if ( $include_css ) {
				wp_register_style( 'ucf_social_css', UCF_SOCIAL__STYLES_URL . '/ucf-social.min.css', null, $version, 'all' );
			}
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
		 * Conditionally includes SVG symbols in the document when
		 * a dependent shortcode is used.  Conditions to load SVG symbols
		 * can be overridden by themes/other plugins using the
		 * `ucf_social_has_social_icons` and `ucf_social_has_social_links`
		 * filters.
		 *
		 * For use with the `wp_footer` action.
		 *
		 * @since 4.0.0
		 * @author Jo Dickson
		 * @return void
		 */
		public static function inline_svg_symbols() {
			if ( filter_var( apply_filters( 'ucf_social_has_social_icons', false ), FILTER_VALIDATE_BOOLEAN ) ) {
				echo file_get_contents( UCF_SOCIAL__IMAGES_URL . '/social-icons-circle.svg' );
			}

			if ( filter_var( apply_filters( 'ucf_social_has_social_links', false ), FILTER_VALIDATE_BOOLEAN ) ) {
				echo file_get_contents( UCF_SOCIAL__IMAGES_URL . '/social-icons.svg' );
			}
		}

	}
}

/**
 * Register assets
 */
add_action( 'wp_enqueue_scripts', array( 'UCF_Social_Common', 'register_assets' ), 10, 0 );
add_action( 'wp_enqueue_scripts', array( 'UCF_Social_Common', 'enqueue_styles' ), 11, 0 );
add_action( 'wp_footer', array( 'UCF_Social_Common', 'inline_svg_symbols' ), 9, 0 );
