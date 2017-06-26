<?php
/**
 * Handles the registration of the UCF Social Shortcode
 **/
if ( !function_exists( 'sc_ucf_social' ) ) {
	function sc_ucf_social( $atts, $content='' ) {
		$atts = shortcode_atts( UCF_Social_Config::get_option_defaults(), $atts, 'sc_ucf_social' );
		ob_start();
		echo UCF_Social_Common::display_social( $atts['layout'] );
		return ob_get_clean(); // Shortcode must *return*!  Do not echo the result!
	}
	add_shortcode( 'ucf-social', 'sc_ucf_social' );
}
if ( ! function_exists( 'ucf_social_shortcode_interface' ) ) {
	function ucf_social_shortcode_interface( $shortcodes ) {
		$settings = array(
			'command' => 'ucf-social',
			'name'    => 'UCF Social',
			'desc'    => 'Displays social icons.',
			'fields'  => array(),
			'content' => false
		);
		$shortcodes[] = $settings;
		return $shortcodes;
	}
}
