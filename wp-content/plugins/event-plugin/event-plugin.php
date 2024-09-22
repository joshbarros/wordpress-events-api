<?php
/*
Plugin Name: Online Events Plugin
Plugin URI: http://josuebarros.com
Description: A custom plugin to register the 'Online Event' post type and integrate with WPGraphQL.
Version: 1.0
Author: Josue A. da S. Barros
Author URI: http://josuebarros.com
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants for the plugin
define( 'ONLINE_EVENT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ONLINE_EVENT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include the file that registers the custom post type
require_once( ONLINE_EVENT_PLUGIN_DIR . 'includes/post-type-online-event.php' );

// Flush rewrite rules when the plugin is activated
function online_event_plugin_activate() {
    online_event_plugin_register_post_type();
    online_event_plugin_register_custom_fields();

    // Flush rewrite rules to update custom post type
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'online_event_plugin_activate' );

// Flush rewrite rules when the plugin is deactivated
function online_event_plugin_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'online_event_plugin_deactivate' );