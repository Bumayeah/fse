<?php

function fse_register_work_link_block() {
    register_block_type( 'fse/work-link', array(
        'render_callback' => function( $attributes ) {
            $work_url   = get_post_meta( get_the_ID(), '_work_url', true );
            $url_label  = get_post_meta( get_the_ID(), '_work_url_label', true );

            if ( ! $work_url ) {
                return '';
            }

            if ( ! $url_label ) {
                $url_label = wp_parse_url( $work_url, PHP_URL_HOST );
            }

            return sprintf(
                '<a href="%s" class="order-first flex items-center text-base text-zinc-400 dark:text-zinc-500 hover:text-teal-500 transition gap-2">
                    <span class="h-4 w-0.5 rounded-full bg-zinc-200 dark:bg-zinc-500" aria-hidden="true"></span>
                    <span>%s</span>
                </a>',
                esc_url( $work_url ),
                esc_html( $url_label )
            );
        },
    ) );
}
