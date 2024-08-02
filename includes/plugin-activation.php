<?php

function wpte_activate_plugin() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_table';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        value text NOT NULL,
        type tinytext NOT NULL,
        category tinytext NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
?>
