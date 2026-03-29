<?php

function fse_register_experience_cpt() {
    register_taxonomy( 'experience_category', 'experience', array(
        'labels' => array(
            'name'          => 'Experience Categories',
            'singular_name' => 'Experience Category',
            'add_new_item'  => 'Add New Category',
            'edit_item'     => 'Edit Category',
            'search_items'  => 'Search Categories',
            'not_found'     => 'No categories found',
        ),
        'public'            => false,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'hierarchical'      => false,
        'show_admin_column' => true,
    ) );

    register_post_type( 'experience', array(
        'labels' => array(
            'name'               => 'Experience',
            'singular_name'      => 'Experience',
            'add_new_item'       => 'Add New Experience',
            'edit_item'          => 'Edit Experience',
            'new_item'           => 'New Experience',
            'search_items'       => 'Search Experience',
            'not_found'          => 'No experience found',
            'not_found_in_trash' => 'No experience found in trash',
        ),
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'show_in_rest'  => true,
        'supports'      => array( 'title', 'excerpt' ),
        'taxonomies'    => array( 'experience_category' ),
        'menu_icon'     => 'dashicons-businessman',
        'menu_position' => 7,
    ) );

    foreach ( array( '_experience_period', '_experience_url', '_experience_url_label' ) as $meta_key ) {
        register_post_meta( 'experience', $meta_key, array(
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function() { return current_user_can( 'edit_posts' ); },
        ) );
    }
}

function fse_experience_meta_box() {
    add_meta_box(
        'fse_experience_details',
        'Experience Details',
        'fse_render_experience_meta_box',
        'experience',
        'normal',
        'high'
    );
}

function fse_render_experience_meta_box( $post ) {
    wp_nonce_field( 'fse_experience_meta', 'fse_experience_nonce' );

    $period    = get_post_meta( $post->ID, '_experience_period', true );
    $url       = get_post_meta( $post->ID, '_experience_url', true );
    $url_label = get_post_meta( $post->ID, '_experience_url_label', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="experience_period">Periode</label></th>
            <td>
                <input type="text" id="experience_period" name="experience_period"
                    value="<?php echo esc_attr( $period ); ?>" class="regular-text"
                    placeholder="bv. Planetaria, 2019 – heden" />
            </td>
        </tr>
        <tr>
            <th><label for="experience_url">Link URL</label></th>
            <td>
                <input type="url" id="experience_url" name="experience_url"
                    value="<?php echo esc_attr( $url ); ?>" class="regular-text"
                    placeholder="https://" />
            </td>
        </tr>
        <tr>
            <th><label for="experience_url_label">Link label</label></th>
            <td>
                <input type="text" id="experience_url_label" name="experience_url_label"
                    value="<?php echo esc_attr( $url_label ); ?>" class="regular-text"
                    placeholder="bv. Bekijk project" />
            </td>
        </tr>
    </table>
    <?php
}

function fse_save_experience_meta( $post_id ) {
    if ( ! isset( $_POST['fse_experience_nonce'] ) ||
         ! wp_verify_nonce( $_POST['fse_experience_nonce'], 'fse_experience_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'experience_period'    => '_experience_period',
        'experience_url'       => '_experience_url',
        'experience_url_label' => '_experience_url_label',
    );

    foreach ( $fields as $post_key => $meta_key ) {
        if ( isset( $_POST[ $post_key ] ) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $post_key ] ) );
        }
    }
}
