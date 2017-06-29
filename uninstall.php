<?php
/**
 * Handles uninstallation logic.
 **/

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

require_once 'includes/ucf-social-config.php';

// Delete options
UCF_Social_Config::delete_options();
?>
