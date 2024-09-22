<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register the "Online Events" post type
function online_event_plugin_register_post_type() {
    $labels = array(
        'name'               => _x( 'Online Events', 'post type general name' ),
        'singular_name'      => _x( 'Online Event', 'post type singular name' ),
        'menu_name'          => _x( 'Online Events', 'admin menu' ),
        'name_admin_bar'     => _x( 'Online Event', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'online event' ),
        'add_new_item'       => __( 'Add New Online Event' ),
        'new_item'           => __( 'New Online Event' ),
        'edit_item'          => __( 'Edit Online Event' ),
        'view_item'          => __( 'View Online Event' ),
        'all_items'          => __( 'All Online Events' ),
        'search_items'       => __( 'Search Online Events' ),
        'not_found'          => __( 'No online events found.' ),
        'not_found_in_trash' => __( 'No online events found in Trash.' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'online-events' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title' ),
        'menu_icon'          => 'dashicons-calendar-alt',
        'show_in_rest'       => false,
        'show_in_graphql'    => true,
        'graphql_single_name' => 'OnlineEvent',
        'graphql_plural_name' => 'OnlineEvents',
    );

    register_post_type( 'online-events', $args );
}
add_action( 'init', 'online_event_plugin_register_post_type' );

// Register custom fields for the "Online Events" post type
function online_event_plugin_register_custom_fields() {
    register_post_meta( 'online-events', 'online_event_date', array(
        'type'              => 'string',
        'description'       => 'Online Event Date',
        'single'            => true,
        'show_in_rest'      => true,
        'show_in_graphql'   => true,
        'graphql_name'      => 'onlineEventDate',
    ) );

    register_post_meta( 'online-events', 'online_event_description', array(
        'type'              => 'string',
        'description'       => 'Online Event Description',
        'single'            => true,
        'show_in_rest'      => true,
        'show_in_graphql'   => true,
        'graphql_name'      => 'onlineEventDescription',
    ) );
}
add_action( 'init', 'online_event_plugin_register_custom_fields' );

// Manually register custom fields for GraphQL schema
add_action( 'graphql_register_types', function() {
    register_graphql_field( 'OnlineEvent', 'onlineEventDate', [
        'type'        => 'String',
        'description' => 'The date of the online event',
        'resolve'     => function( $post ) {
            return get_post_meta( $post->ID, 'online_event_date', true );
        }
    ] );

    register_graphql_field( 'OnlineEvent', 'onlineEventDescription', [
        'type'        => 'String',
        'description' => 'The description of the online event',
        'resolve'     => function( $post ) {
            return get_post_meta( $post->ID, 'online_event_description', true );
        }
    ] );
});

// Customize the meta fields display
function online_event_plugin_display_meta_fields_after_title( $post ) {
    if ( 'online-events' === $post->post_type ) {
        // Default date to today if not set
        $online_event_date = get_post_meta( $post->ID, 'online_event_date', true );
        $online_event_date = !empty($online_event_date) ? $online_event_date : date('Y-m-d');

        $online_event_description = get_post_meta( $post->ID, 'online_event_description', true );

        ?>
        <div class="event-details-meta">
            <input type="date" id="online_event_date" name="online_event_date" value="<?php echo esc_attr( $online_event_date ); ?>" placeholder="Online Event Date" />
            <?php
            $settings = array(
                'textarea_name' => 'online_event_description',
                'textarea_rows' => 10,
                'media_buttons' => false,
                'teeny' => true,
                'quicktags' => false,
                'tinymce' => array(
                    'toolbar1' => 'bold,italic,underline,bullist,numlist,link,unlink',
                    'toolbar2' => '',
                    'toolbar3' => '',
                ),
            );
            wp_editor( htmlspecialchars_decode($online_event_description), 'online_event_description', $settings );
            ?>
        </div>
        <?php
    }
}
add_action( 'edit_form_after_title', 'online_event_plugin_display_meta_fields_after_title' );

// Save meta box data
function online_event_plugin_save_meta_box_data( $post_id ) {
    if ( isset( $_POST['online_event_date'] ) ) {
        update_post_meta( $post_id, 'online_event_date', sanitize_text_field($_POST['online_event_date']) );
    }
    if ( isset( $_POST['online_event_description'] ) ) {
        update_post_meta( $post_id, 'online_event_description', $_POST['online_event_description'] );
    }
}
add_action( 'save_post', 'online_event_plugin_save_meta_box_data' );