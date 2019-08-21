<?php
/*
Plugin Name: UCF Social
Description: Provides a shortcode, functions, and default styles for displaying UCF social assets.
Version: 3.0.3
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: https://github.com/UCF/UCF-Social-Plugin
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'UCF_SOCIAL__PLUGIN_FILE', __FILE__ );


// Layouts - social feed
require_once 'layouts/social-feed/default.php';
require_once 'layouts/social-feed/scrollbox.php';
require_once 'layouts/social-feed/scrollbox_sm.php';
require_once 'layouts/social-feed/scrollbox_lg.php';

// Layouts - social icons
require_once 'layouts/social-icons/default.php';

// Layouts - social links
require_once 'layouts/social-links/default.php';

// Core plugin files
require_once 'includes/ucf-social-config.php';
require_once 'includes/ucf-social-common.php';
require_once 'includes/ucf-social-shortcodes.php';


if ( ! function_exists( 'ucf_social_activate' ) ) {
	function ucf_social_activate() {
		UCF_Social_Config::add_options();
	}
}

if ( ! function_exists( 'ucf_social_deactivate' ) ) {
	function ucf_social_deactivate() {
		UCF_Social_Config::delete_options();
	}
}

register_activation_hook( UCF_SOCIAL__PLUGIN_FILE, 'ucf_social_activate' );
register_deactivation_hook( UCF_SOCIAL__PLUGIN_FILE, 'ucf_social_deactivate' );


add_action( 'plugins_loaded', function() {

	if ( class_exists( 'WP_SCIF_Config' ) ) {
		add_filter( 'wp_scif_add_shortcode', array( 'UCF_Social_Shortcode', 'icons_shortcode_interface' ), 10, 1 );
		add_filter( 'wp_scif_add_shortcode', array( 'UCF_Social_Shortcode', 'links_shortcode_interface' ), 10, 1 );
		add_filter( 'wp_scif_add_shortcode', array( 'UCF_Social_Shortcode', 'feed_shortcode_interface' ), 10, 1 );
	}

} );
