<?php
/*
Plugin Name: WP Table Editor
Description: A plugin to edit WordPress tables via a mobile app.
Version: 1.0
Author: Sithumini
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once plugin_dir_path(__FILE__) . 'includes/plugin-activation.php';
require_once plugin_dir_path(__FILE__) . 'includes/plugin-deactivation.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-menu.php';
require_once plugin_dir_path(__FILE__) . 'includes/table-display.php';
require_once plugin_dir_path(__FILE__) . 'includes/api-endpoints.php';
require_once plugin_dir_path(__FILE__) . 'includes/api-endpoints.php'; 
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php'; 

// Activation and Deactivation Hooks
register_activation_hook(__FILE__, 'wpte_activate_plugin');
register_deactivation_hook(__FILE__, 'wpte_deactivate_plugin');

// Initialize the plugin
add_action('admin_menu', 'wpte_register_admin_menu');
add_action('admin_enqueue_scripts', 'wpte_enqueue_admin_styles');

function wpte_enqueue_admin_styles() {
    wp_enqueue_style('wpte-admin-style', plugin_dir_url(__FILE__) . 'css/admin-style.css');
}
?>
