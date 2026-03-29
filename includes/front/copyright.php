<?php

function fse_register_copyright_block() {
    register_block_type('fse/dynamic-copyright', array(
        'render_callback' => function() {
            $year = date('Y');
            $site_title = get_bloginfo('name');

            return sprintf('&copy; %s %s', $year, esc_html($site_title));
        },
    ));
}