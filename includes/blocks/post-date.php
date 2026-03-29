<?php

function fse_register_post_date_block() {
    register_block_type( 'fse/post-date', array(
        'render_callback' => function( $attributes ) {
            return sprintf(
                '<time datetime="%s" class="order-first flex items-center text-base text-zinc-400 dark:text-zinc-500">
                    <span class="h-4 w-0.5 rounded-full bg-zinc-200 dark:bg-zinc-500" aria-hidden="true"></span>
                    <span class="ml-3">%s</span>
                </time>',
                esc_attr( get_the_date( 'Y-m-d' ) ),
                esc_html( get_the_date( 'F j, Y' ) )
            );
        },
    ) );
}
