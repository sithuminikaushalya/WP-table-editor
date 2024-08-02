<?php

add_action('rest_api_init', function () {
    register_rest_route('daily-updater/v1', '/details', [
        'methods' => 'GET',
        'callback' => 'wpte_get_details',
    ]);

    register_rest_route('daily-updater/v1', '/update', [
        'methods' => 'POST',
        'callback' => 'wpte_update_details',
        'permission_callback' => '__return_true', 
    ]);

    register_rest_route('daily-updater/v1', '/details/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'wpte_delete_details',
        'permission_callback' => '__return_true', 
    ]);

    register_rest_route('daily-updater/v1', '/details/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'wpte_put_details',
        'permission_callback' => '__return_true',
    ]);
});

function wpte_get_details() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_table';

    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    return new WP_REST_Response(['details' => $results], 200);
}

function wpte_update_details(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_table';

    $data_type = sanitize_text_field($request->get_param('type'));
    $data_category = sanitize_text_field($request->get_param('category'));
    $name = sanitize_text_field($request->get_param('name'));
    $value = sanitize_text_field($request->get_param('value'));

    $wpdb->insert($table_name, [
        'type' => $data_type,
        'category' => $data_category,
        'name' => $name,
        'value' => $value
    ]);

    return new WP_REST_Response('Data added successfully', 200);
}

function wpte_put_details(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_table';
    $id = (int) $request->get_param('id');

    $data_type = sanitize_text_field($request->get_param('type'));
    $data_category = sanitize_text_field($request->get_param('category'));
    $name = sanitize_text_field($request->get_param('name'));
    $value = sanitize_text_field($request->get_param('value'));

    $wpdb->update($table_name, [
        'type' => $data_type,
        'category' => $data_category,
        'name' => $name,
        'value' => $value
    ], ['id' => $id]);

    return new WP_REST_Response('Data updated successfully', 200);
}

function wpte_delete_details(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_table';
    $id = (int) $request->get_param('id');

    $wpdb->delete($table_name, ['id' => $id]);

    return new WP_REST_Response('Data deleted successfully', 200);
}
