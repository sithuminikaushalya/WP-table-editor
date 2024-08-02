<?php

// Shortcode to display table
function wpte_table_shortcode() {
    ob_start();
    wpte_table_display(); 
    return ob_get_clean();
}

// Register the shortcode
function wpte_register_shortcodes() {
    add_shortcode('wp_table_editor', 'wpte_table_shortcode');
}
add_action('init', 'wpte_register_shortcodes');
?>
