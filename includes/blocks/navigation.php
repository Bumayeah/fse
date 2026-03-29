<?php

function fse_register_navigation_block() {
    register_block_type( 'fse/navigation', array(
        'attributes' => array(
            'menuSlug' => array(
                'type'    => 'string',
                'default' => 'primary',
            ),
            'variant' => array(
                'type'    => 'string',
                'default' => 'header',
            ),
        ),
        'render_callback' => function( $attributes ) {
            $menu_items = wp_get_nav_menu_items( $attributes['menuSlug'] );

            if ( ! $menu_items ) {
                return '';
            }

            _wp_menu_item_classes_by_context( $menu_items );

            $is_footer = $attributes['variant'] === 'footer';

            if ( $is_footer ) {
                $output = '<div class="flex flex-wrap justify-center gap-x-6 gap-y-1">';

                foreach ( $menu_items as $item ) {
                    $output .= sprintf(
                        '<a class="transition hover:text-teal-500 dark:hover:text-teal-400" href="%s">%s</a>',
                        esc_url( $item->url ),
                        esc_html( $item->title )
                    );
                }

                $output .= '</div>';
            } else {
                $items = '';

                foreach ( $menu_items as $item ) {
                    $is_active = in_array( 'current-menu-item', $item->classes )
                        || in_array( 'current-menu-ancestor', $item->classes );

                    $color     = $is_active ? 'text-teal-500 dark:text-teal-400' : 'hover:text-teal-500 dark:hover:text-teal-400';
                    $indicator = $is_active ? '<span class="absolute inset-x-1 -bottom-px h-px bg-linear-to-r from-teal-500/0 via-teal-500/40 to-teal-500/0 dark:from-teal-400/0 dark:via-teal-400/40 dark:to-teal-400/0"></span>' : '';

                    $items .= sprintf(
                        '<li><a class="relative block px-3 py-2 transition %s" href="%s">%s%s</a></li>',
                        $color,
                        esc_url( $item->url ),
                        esc_html( $item->title ),
                        $indicator
                    );
                }

                $output = sprintf(
                    '<nav class="pointer-events-auto hidden md:block"><ul class="flex rounded-full bg-white/90 px-3 text-sm font-medium text-zinc-800 shadow-lg ring-1 shadow-zinc-800/5 ring-zinc-900/5 backdrop-blur-sm dark:bg-zinc-800/90 dark:text-zinc-200 dark:ring-white/10">%s</ul></nav>',
                    $items
                );
            }

            return $output;
        },
    ) );
}
