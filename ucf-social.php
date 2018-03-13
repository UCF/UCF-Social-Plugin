<?php
/*
Plugin Name: UCF Social
Description: Provides a shortcode, functions, and default styles for displaying UCF social assets.
Version: 1.0.7
Author: UCF Web Communications
License: GPL3
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'plugins_loaded', function() {

	define( 'UCF_SOCIAL__PLUGIN_FILE', __FILE__ );

	// Layouts - social feed
	require_once 'layouts/social-feed/default.php';
	require_once 'layouts/social-feed/grid.php';
	require_once 'layouts/social-feed/waterfall.php';

	// Layouts - social icons
	require_once 'layouts/social-icons/default.php';

	// Layouts - social links
	require_once 'layouts/social-links/default.php';

	// Core plugin files
	require_once 'includes/ucf-social-config.php';
	require_once 'includes/ucf-social-common.php';
	require_once 'includes/ucf-social-shortcodes.php';

} );

?>
