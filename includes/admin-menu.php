<?php

function wpte_register_admin_menu() {
    add_menu_page(
        'WP Table Editor',
        'Table Editor',
        'manage_options',
        'wp-table-editor',
        'wpte_table_display_page',
        'dashicons-table',
        26
    );
}
?>
