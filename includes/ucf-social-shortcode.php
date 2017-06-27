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
		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'color'  => 'color',
				'size'   => 'md'
			), $atts );

			return UCF_Social_Common::display_social_icons( $atts );
		}
	}
	add_shortcode( 'ucf-social-icons', array( 'UCF_Social_Shortcode', 'shortcode' ) );
}
