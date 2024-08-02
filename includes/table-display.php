<?php

function wpte_table_display() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_custom_table';

    // Handle Add New Entry
    if (isset($_POST['new_name'])) {
        $wpdb->insert($table_name, [
            'name' => sanitize_text_field($_POST['new_name']),
            'value' => sanitize_text_field($_POST['new_value']),
            'type' => sanitize_text_field($_POST['new_type']),
            'category' => sanitize_text_field($_POST['new_category']),
        ]);
    }

    // Handle Delete Entry
    if (isset($_POST['delete_id'])) {
        $wpdb->delete($table_name, ['id' => intval($_POST['delete_id'])]);
    }

    // Handle Edit Entry
    if (isset($_POST['edit_id'])) {
        $id = intval($_POST['edit_id']);
        $entry = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    } else {
        $entry = null;
    }

    // Handle Save Edited Entry
    if (isset($_POST['save_id'])) {
        $id = intval($_POST['save_id']);
        $wpdb->update($table_name, [
            'name' => sanitize_text_field($_POST['edit_name']),
            'value' => sanitize_text_field($_POST['edit_value']),
            'type' => sanitize_text_field($_POST['edit_type']),
            'category' => sanitize_text_field($_POST['edit_category']),
        ], ['id' => $id]);
    }

    $results = $wpdb->get_results("SELECT * FROM $table_name");
    ?>
    <div class="wrap">
        <h1>WP Table Editor</h1>
        <form method="post">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                    <tr>
                        <td><?php echo esc_html($row->type); ?></td>
                        <td><?php echo esc_html($row->category); ?></td>
                        <td><?php echo esc_html($row->name); ?></td>
                        <td><?php echo esc_html($row->value); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="edit_id" value="<?php echo esc_attr($row->id); ?>">
                                <input type="submit" value="Edit" class="button button-secondary">
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo esc_attr($row->id); ?>">
                                <input type="submit" value="Delete" class="button button-secondary">
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h2>Add New Entry</h2>
            <p>
                <label for="new_type">Type:</label>
                <input type="text" id="new_type" name="new_type">
            </p>
            <p>
                <label for="new_category">Category:</label>
                <input type="text" id="new_category" name="new_category">
            </p>
            <p>
                <label for="new_name">Name:</label>
                <input type="text" id="new_name" name="new_name">
            </p>
            <p>
                <label for="new_value">Value:</label>
                <input type="text" id="new_value" name="new_value">
            </p>
            <p>
                <input type="submit" value="Add" class="button button-primary">
            </p>
        </form>

        <?php if ($entry) { ?>
        <h2>Edit Entry</h2>
        <form method="post">
            <input type="hidden" name="save_id" value="<?php echo esc_attr($entry->id); ?>">
            <p>
                <label for="edit_type">Type:</label>
                <input type="text" id="edit_type" name="edit_type" value="<?php echo esc_attr($entry->type); ?>">
            </p>
            <p>
                <label for="edit_category">Category:</label>
                <input type="text" id="edit_category" name="edit_category" value="<?php echo esc_attr($entry->category); ?>">
            </p>
            <p>
                <label for="edit_name">Name:</label>
                <input type="text" id="edit_name" name="edit_name" value="<?php echo esc_attr($entry->name); ?>">
            </p>
            <p>
                <label for="edit_value">Value:</label>
                <input type="text" id="edit_value" name="edit_value" value="<?php echo esc_attr($entry->value); ?>">
            </p>
            <p>
                <input type="submit" value="Save Changes" class="button button-primary">
            </p>
        </form>
        <?php } ?>
    </div>
    <?php
}

// For backward compatibility or if you want to use it in both admin and front-end
function wpte_table_display_page() {
    ob_start();
    wpte_table_display(); // Call the function to display the table
    echo ob_get_clean();
}
?>
