<?php
/**
 * Registers the social shortcode
 * @author RJ Bruneel
 * @since 1.0.0
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

			ob_start();
			echo UCF_Social_Common::display_social_icons( $atts );
			return ob_get_clean();
		}

		public static function links_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'size'   => 'sm',
				'layout' => 'default'
			), $atts, 'ucf-social-links' );

			ob_start();
			echo UCF_Social_Common::display_social_links( $atts );
			return ob_get_clean();
		}

		public static function feed_shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'feed'       => '',
				'container'  => 'ucf-social-feed',
				'layout'     => 'waterfall',
				'grid-width' => 320,
				'grid-rows'  => 3,
				'class'      => ''
			), $atts, 'ucf-social-feed' );

			ob_start();
			echo UCF_Social_Common::display_social_feed( $atts );
			return ob_get_clean();
		}
	}

	add_shortcode( 'ucf-social-icons', array( 'UCF_Social_Shortcode', 'icons_shortcode' ) );
	add_shortcode( 'ucf-social-links', array( 'UCF_Social_Shortcode', 'links_shortcode' ) );
	add_shortcode( 'ucf-social-feed', array( 'UCF_Social_Shortcode', 'feed_shortcode' ) );
}
