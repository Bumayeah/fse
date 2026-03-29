<?php

function fse_register_avatar_block() {
    register_block_type( 'fse/avatar', array(
        'attributes' => array(
            'imageId' => array( 'type' => 'integer', 'default' => 0 ),
            'userId'  => array( 'type' => 'integer', 'default' => 0 ),
        ),
        'render_callback' => function( $attributes ) {
            $image_id = intval( $attributes['imageId'] );
            $user_id  = intval( $attributes['userId'] );

            if ( $image_id ) {
                $img_html = wp_get_attachment_image( $image_id, array( 512, 512 ), false, array(
                    'class'   => 'rounded-full bg-zinc-100 object-cover dark:bg-zinc-800 h-9 w-9',
                    'loading' => 'eager',
                    'alt'     => '',
                ) );
            } else {
                $img_html = sprintf(
                    '<img src="%s" alt="" class="rounded-full bg-zinc-100 object-cover dark:bg-zinc-800 h-9 w-9" loading="eager" decoding="async">',
                    esc_url( get_theme_file_uri( '/assets/img/jc.jpg' ) )
                );
            }

            return sprintf(
                '<div id="site-avatar" class="h-10 w-10 rounded-full bg-white/90 p-0.5 shadow-lg ring-1 shadow-zinc-800/5 ring-zinc-900/5 backdrop-blur-sm dark:bg-zinc-800/90 dark:ring-white/10">
                    <a aria-label="Home" class="pointer-events-auto" href="%s">%s</a>
                </div>',
                esc_url( home_url( '/' ) ),
                $img_html
            );
        },
    ) );
}
