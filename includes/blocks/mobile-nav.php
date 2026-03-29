<?php

function fse_register_mobile_nav_block() {
    register_block_type( 'fse/mobile-nav', array(
        'attributes' => array(
            'menuSlug' => array( 'type' => 'string', 'default' => 'primary' ),
        ),
        'render_callback' => function( $attributes ) {
            $menu_items = wp_get_nav_menu_items( $attributes['menuSlug'] );
            $items_html = '';

            if ( $menu_items ) {
                _wp_menu_item_classes_by_context( $menu_items );

                foreach ( $menu_items as $item ) {
                    $is_active = in_array( 'current-menu-item', $item->classes )
                        || in_array( 'current-menu-ancestor', $item->classes );

                    $color = $is_active
                        ? 'text-teal-500'
                        : 'text-zinc-800 dark:text-zinc-200';

                    $items_html .= sprintf(
                        '<li><a class="block py-2" href="%s">%s</a></li>',
                        esc_url( $item->url ),
                        esc_html( $item->title )
                    );
                }
            }

            return sprintf(
                '<div class="pointer-events-auto md:hidden">
                    <button
                        id="fse-mobile-menu-btn"
                        type="button"
                        aria-expanded="false"
                        aria-controls="fse-mobile-menu"
                        class="group flex items-center rounded-full bg-white/90 px-4 py-2 text-sm font-medium text-zinc-800 shadow-lg ring-1 shadow-zinc-800/5 ring-zinc-900/5 backdrop-blur-sm dark:bg-zinc-800/90 dark:text-zinc-200 dark:ring-white/10 dark:hover:ring-white/20"
                    >Menu<svg viewBox="0 0 8 6" aria-hidden="true" class="ml-3 h-auto w-2 stroke-zinc-500 group-hover:stroke-zinc-700 dark:group-hover:stroke-zinc-400"><path d="M1.75 1.75 4 4.25l2.25-2.5" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
                    <div id="fse-mobile-menu-backdrop" aria-hidden="true" class="hidden fixed inset-0 z-50 bg-zinc-800/40 backdrop-blur-xs dark:bg-black/80"></div>
                    <div
                        id="fse-mobile-menu"
                        role="dialog"
                        aria-modal="true"
                        class="hidden fixed inset-x-4 top-8 z-50 origin-top rounded-3xl bg-white p-8 ring-1 ring-zinc-900/5 dark:bg-zinc-900 dark:ring-zinc-800"
                    >
                        <div class="flex flex-row-reverse items-center justify-between">
                            <button
                                id="fse-mobile-menu-close"
                                type="button"
                                aria-label="Close menu"
                                class="-m-1 p-1"
                            ><svg viewBox="0 0 24 24" aria-hidden="true" class="h-6 w-6 text-zinc-500 dark:text-zinc-400"><path d="m17.25 6.75-10.5 10.5M6.75 6.75l10.5 10.5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></button>
                            <h2 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Navigation</h2>
                        </div>
                        <nav class="mt-6">
                            <ul class="-my-2 divide-y divide-zinc-100 text-base text-zinc-800 dark:divide-zinc-100/5 dark:text-zinc-300">%s</ul>
                        </nav>
                    </div>
                </div>',
                $items_html
            );
        },
    ) );
}
