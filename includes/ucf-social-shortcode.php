<?php
/**
 * Registers the social shortcode
 * @author RJ Bruneel
 * @since 1.0
 * @param array $atts | Assoc. array of shortcode options
 * @return array
 **/

if ( ! class_exists( 'UCF_Social_Shortcode' ) ) {
	class UCF_Social_Shortcode {
		public static function icons_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'color'  => 'color',
				'size'   => 'md'
			), $atts, 'ucf-social-icons' );

			return UCF_Social_Common::display_social_icons( $atts );
		}

		public static function links_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'size'   => 'sm'
			), $atts, 'ucf-social-links' );

			return UCF_Social_Common::display_social_links( $atts );
		}
	}

	add_shortcode( 'ucf-social-icons', array( 'UCF_Social_Shortcode', 'icons_shortcode' ) );
	add_shortcode( 'ucf-social-links', array( 'UCF_Social_Shortcode', 'links_shortcode' ) );
}
