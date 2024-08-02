<?php

function wpte_deactivate_plugin() {
    delete_option('wpte_some_option');
    
    wpte_clear_scheduled_events();
}

function wpte_clear_scheduled_events() {
    $timestamp = wp_next_scheduled('wpte_some_event');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'wpte_some_event');
    }
}
?>
