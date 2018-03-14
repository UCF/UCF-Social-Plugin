<?php
/*
Plugin Name: UCF Social
Description: Provides a shortcode, functions, and default styles for displaying UCF social assets.
Version: 1.0.7
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: https://github.com/UCF/UCF-Social-Plugin
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'plugins_loaded', function() {

	define( 'UCF_SOCIAL__PLUGIN_FILE', __FILE__ );

	require_once 'layouts/layout-social-feed-grid.php';
	require_once 'layouts/layout-social-feed-waterfall.php';
	require_once 'includes/ucf-social-config.php';
	require_once 'includes/ucf-social-common.php';
	require_once 'includes/ucf-social-shortcode.php';

} );

?>
