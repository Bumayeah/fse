<?php

function fse_register_back_link_block() {
    register_block_type( 'fse/back-link', array(
        'attributes' => array(
            'label' => array(
                'type'    => 'string',
                'default' => 'Go back',
            ),
            'href' => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
        'render_callback' => function( $attributes ) {
            if ( ! empty( $attributes['href'] ) ) {
                $archive_url = $attributes['href'];
            } else {
                $post_type   = get_post_type();
                $archive_url = get_post_type_archive_link( $post_type );
                if ( ! $archive_url ) {
                    $archive_url = home_url( '/' );
                }
            }

            return sprintf(
                '<a href="%s" aria-label="%s" class="group mb-8 flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-md ring-1 shadow-zinc-800/5 ring-zinc-900/5 transition lg:absolute lg:-left-5 lg:-mt-2 lg:mb-0 xl:-top-1.5 xl:left-0 xl:mt-0 dark:border dark:border-zinc-700/50 dark:bg-zinc-800 dark:ring-0 dark:ring-white/10 dark:hover:border-zinc-700 dark:hover:ring-white/20">
                    <svg viewBox="0 0 16 16" fill="none" aria-hidden="true" class="h-4 w-4 stroke-zinc-500 transition group-hover:stroke-zinc-700 dark:stroke-zinc-500 dark:group-hover:stroke-zinc-400">
                        <path d="M7.25 11.25 3.75 8m0 0 3.5-3.25M3.75 8h8.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>',
                esc_url( $archive_url ),
                esc_attr( $attributes['label'] )
            );
        },
    ) );
}
