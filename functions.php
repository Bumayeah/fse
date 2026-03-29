<?php

// variables

// includes
include_once( get_theme_file_path( '/includes/front/enqueue.php' ) );
include_once( get_theme_file_path( '/includes/front/head.php' ) );
include_once( get_theme_file_path( '/includes/front/copyright.php' ) );

include_once( get_theme_file_path( '/includes/setup.php' ) );
include_once( get_theme_file_path( '/includes/blocks/articles.php' ) );
include_once( get_theme_file_path( '/includes/blocks/navigation.php' ) );
include_once( get_theme_file_path( '/includes/blocks/hero.php' ) );
include_once( get_theme_file_path( '/includes/blocks/photo-gallery.php' ) );
include_once( get_theme_file_path( '/includes/blocks/subscribe.php' ) );
include_once( get_theme_file_path( '/includes/blocks/work.php' ) );
include_once( get_theme_file_path( '/includes/blocks/avatar.php' ) );
include_once( get_theme_file_path( '/includes/blocks/theme-switcher.php' ) );
include_once( get_theme_file_path( '/includes/blocks/mobile-nav.php' ) );
include_once( get_theme_file_path( '/includes/blocks/blog-archive.php' ) );
include_once( get_theme_file_path( '/includes/blocks/back-link.php' ) );
include_once( get_theme_file_path( '/includes/blocks/portrait.php' ) );
include_once( get_theme_file_path( '/includes/blocks/post-date.php' ) );
include_once( get_theme_file_path( '/includes/blocks/work-items.php' ) );
include_once( get_theme_file_path( '/includes/blocks/front-work.php' ) );
include_once( get_theme_file_path( '/includes/blocks/work-link.php' ) );
include_once( get_theme_file_path( '/includes/blocks/skills.php' ) );
include_once( get_theme_file_path( '/includes/blocks/experience.php' ) );
include_once( get_theme_file_path( '/includes/cpt/skill.php' ) );
include_once( get_theme_file_path( '/includes/cpt/experience.php' ) );
include_once( get_theme_file_path( '/includes/cpt/work.php' ) );

// hooks
add_action( 'wp_head', 'fse_head', 5 );
add_action( 'wp_enqueue_scripts', 'fse_enqueue_style' );
add_action( 'init', 'fse_register_copyright_block' );
add_action( 'init', 'fse_register_articles_block' );
add_action( 'init', 'fse_register_navigation_block' );
add_action( 'init', 'fse_register_hero_block' );
add_action( 'init', 'fse_register_photo_gallery_block' );
add_action( 'init', 'fse_register_subscribe_block' );
add_action( 'init', 'fse_register_work_block' );
add_action( 'init', 'fse_register_avatar_block' );
add_action( 'init', 'fse_register_theme_switcher_block' );
add_action( 'init', 'fse_register_mobile_nav_block' );
add_action( 'init', 'fse_register_blog_archive_block' );
add_action( 'init', 'fse_register_back_link_block' );
add_action( 'init', 'fse_register_portrait_block' );
add_action( 'init', 'fse_register_post_date_block' );
add_action( 'init', 'fse_register_work_items_block' );
add_action( 'init', 'fse_register_front_work_block' );
add_action( 'init', 'fse_register_work_link_block' );
add_action( 'init', 'fse_register_skills_block' );
add_action( 'init', 'fse_register_experience_block' );
add_action( 'init', 'fse_register_skill_cpt' );
add_action( 'init', 'fse_register_experience_cpt' );
add_action( 'add_meta_boxes', 'fse_experience_meta_box' );
add_action( 'save_post_experience', 'fse_save_experience_meta' );
add_action( 'init', 'fse_register_work_cpt' );
add_action( 'after_setup_theme', 'fse_setup_theme' );
add_filter( 'language_attributes', function( $output ) {
    return $output . ' class="h-full antialiased dark"';
} );
add_filter( 'body_class', function( $classes ) {
    return array_merge( $classes, [ 'h-full', 'bg-zinc-50', 'dark:bg-black' ] );
} );

add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style(
        'fse_css_editor',
        get_theme_file_uri('/css/main.css'),
        array(),
        filemtime(get_theme_file_path('/css/main.css'))
    );
    wp_enqueue_style(
        'fse_tw_editor',
        get_theme_file_uri('/css/tailwind.output.css'),
        array(),
        filemtime(get_theme_file_path('/css/tailwind.output.css'))
    );
});