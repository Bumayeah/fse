<?php

function fse_setup_theme() {
    add_theme_support( 'editor-styles' );
    add_theme_support( 'post-thumbnails' );

    add_editor_style(
        [
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap',
            'css/main.css',
            'css/tailwind.output.css'
        ]
    );

    register_nav_menus( [
        'primary' => __( 'Primary Menu' ),
    ] );

    fse_create_primary_menu();
}

function fse_create_primary_menu() {
    if ( wp_get_nav_menu_object( 'primary' ) ) {
        return;
    }

    $menu_id = wp_create_nav_menu( 'primary' );

    $items = [
        [ 'title' => 'About',    'url' => '/about' ],
        [ 'title' => 'Projects', 'url' => '/projects' ],
        [ 'title' => 'Work', 'url' => '/work' ],
        [ 'title' => 'Speaking', 'url' => '/speaking' ],
        [ 'title' => 'Uses',     'url' => '/uses' ],
    ];

    foreach ( $items as $item ) {
        wp_update_nav_menu_item( $menu_id, 0, [
            'menu-item-title'  => $item['title'],
            'menu-item-url'    => $item['url'],
            'menu-item-status' => 'publish',
            'menu-item-type'   => 'custom',
        ] );
    }
}