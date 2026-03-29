<?php

function fse_register_work_cpt() {
    register_post_type( 'work', array(
        'labels' => array(
            'name'               => 'Work',
            'singular_name'      => 'Work',
            'add_new_item'       => 'Add New Work',
            'edit_item'          => 'Edit Work',
            'new_item'           => 'New Work',
            'view_item'          => 'View Work',
            'search_items'       => 'Search Work',
            'not_found'          => 'No work found',
            'not_found_in_trash' => 'No work found in trash',
        ),
        'public'              => true,
        'publicly_queryable'  => false,
        'has_archive'         => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'supports'      => array( 'title', 'excerpt', 'thumbnail' ),
        'menu_icon'     => 'dashicons-portfolio',
        'menu_position' => 5,
    ) );

    register_post_meta( 'work', '_work_url', array(
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() { return current_user_can( 'edit_posts' ); },
    ) );

    register_post_meta( 'work', '_work_url_label', array(
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() { return current_user_can( 'edit_posts' ); },
    ) );
}
