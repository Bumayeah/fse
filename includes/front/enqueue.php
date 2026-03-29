<?php

function fse_enqueue_style() {
    wp_register_style( 
        'fse_fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap',
        array(),
        null
    );
    
    wp_register_style(
        'fse_css',
        get_theme_file_uri('/css/main.css'),
        array(),
        filemtime(get_theme_file_path('/css/main.css'))
    );

    wp_register_style(
        'fse_tw',
        get_theme_file_uri('/css/tailwind.output.css'),
        array(),
        filemtime(get_theme_file_path('/css/tailwind.output.css'))
    );

    wp_enqueue_style( 'fse_fonts' );
    wp_enqueue_style( 'fse_css' );
    wp_enqueue_style( 'fse_tw' );

    wp_enqueue_script(
        'fse_bundle',
        get_theme_file_uri( '/js/dist/bundle.js' ),
        array(),
        filemtime( get_theme_file_path( '/js/dist/bundle.js' ) ),
        true
    );
}