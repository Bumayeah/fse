<?php

function fse_register_skill_cpt() {
    register_taxonomy( 'skill_category', 'skill', array(
        'labels' => array(
            'name'              => 'Skill Categories',
            'singular_name'     => 'Skill Category',
            'add_new_item'      => 'Add New Category',
            'edit_item'         => 'Edit Category',
            'search_items'      => 'Search Categories',
            'not_found'         => 'No categories found',
        ),
        'public'            => false,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'hierarchical'      => false,
        'show_admin_column' => true,
    ) );

    register_post_type( 'skill', array(
        'labels' => array(
            'name'               => 'Skills',
            'singular_name'      => 'Skill',
            'add_new_item'       => 'Add New Skill',
            'edit_item'          => 'Edit Skill',
            'new_item'           => 'New Skill',
            'search_items'       => 'Search Skills',
            'not_found'          => 'No skills found',
            'not_found_in_trash' => 'No skills found in trash',
        ),
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'show_in_rest'  => true,
        'supports'      => array( 'title', 'excerpt' ),
        'taxonomies'    => array( 'skill_category' ),
        'menu_icon'     => 'dashicons-awards',
        'menu_position' => 6,
    ) );
}
