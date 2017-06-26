<?php
/*
Plugin Name: UCF Social
Description:
Version: 1.0.1
Author: UCF Web Communications
License: GPL3
*/


if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'plugins_loaded', function() {

	define( 'UCF_SOCIAL__PLUGIN_FILE', __FILE__ );

	require_once 'includes/ucf-social-common.php';
	require_once 'includes/ucf-social-shortcode.php';

} );

?>
