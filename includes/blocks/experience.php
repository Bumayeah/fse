<?php

function fse_register_experience_block() {
    register_block_type( 'fse/experience', array(
        'render_callback' => function( $attributes ) {
            $categories = get_terms( array(
                'taxonomy'   => 'experience_category',
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ) );

            if ( is_wp_error( $categories ) || empty( $categories ) ) {
                return '';
            }

            $category_order = array( 'eudonet' => 0, 'stb' => 1, 's2b' => 2, 'dvv' => 3, 'capital id' => 4 );
            usort( $categories, function( $a, $b ) use ( $category_order ) {
                $a_pos = isset( $category_order[ strtolower( $a->name ) ] ) ? $category_order[ strtolower( $a->name ) ] : 999;
                $b_pos = isset( $category_order[ strtolower( $b->name ) ] ) ? $category_order[ strtolower( $b->name ) ] : 999;
                return $a_pos - $b_pos;
            } );

            $arrow_icon = '<svg viewBox="0 0 16 16" fill="none" aria-hidden="true" class="ml-1 h-4 w-4 stroke-current"><path d="M6.75 5.75 9.25 8l-2.5 2.25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>';

            $output = '<div class="space-y-20">';

            foreach ( $categories as $category ) {
                $query = new WP_Query( array(
                    'post_type'      => 'experience',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'experience_category',
                            'field'    => 'term_id',
                            'terms'    => $category->term_id,
                        ),
                    ),
                ) );

                if ( ! $query->have_posts() ) {
                    continue;
                }

                $items = '';

                while ( $query->have_posts() ) {
                    $query->the_post();

                    $period    = get_post_meta( get_the_ID(), '_experience_period', true );
                    $url       = get_post_meta( get_the_ID(), '_experience_url', true );
                    $url_label = get_post_meta( get_the_ID(), '_experience_url_label', true );

                    $period_html = $period
                        ? sprintf(
                            '<p class="relative z-10 order-first mb-3 flex items-center text-sm text-zinc-400 dark:text-zinc-500 pl-3.5">
                                <span class="absolute inset-y-0 left-0 flex items-center" aria-hidden="true">
                                    <span class="h-4 w-0.5 rounded-full bg-zinc-200 dark:bg-zinc-500"></span>
                                </span>
                                %s
                            </p>',
                            esc_html( $period )
                        )
                        : '';

                    if ( $url ) {
                        $title_html = sprintf(
                            '<h3 class="text-base font-semibold tracking-tight text-zinc-800 dark:text-zinc-100">
                                <div class="absolute -inset-x-4 -inset-y-6 z-0 scale-95 bg-zinc-50 opacity-0 transition group-hover:scale-100 group-hover:opacity-100 sm:-inset-x-6 sm:rounded-2xl dark:bg-zinc-800/50"></div>
                                <a href="%s"><span class="absolute -inset-x-4 -inset-y-6 z-20 sm:-inset-x-6 sm:rounded-2xl"></span><span class="relative z-10">%s</span></a>
                            </h3>',
                            esc_url( $url ),
                            esc_html( get_the_title() )
                        );

                        $link_html = $url_label
                            ? sprintf(
                                '<div aria-hidden="true" class="relative z-10 mt-4 flex items-center text-sm font-medium text-teal-500">%s%s</div>',
                                esc_html( $url_label ),
                                $arrow_icon
                            )
                            : '';
                    } else {
                        $title_html = sprintf(
                            '<h3 class="text-base font-semibold tracking-tight text-zinc-800 dark:text-zinc-100">
                                <span class="relative z-10">%s</span>
                            </h3>',
                            esc_html( get_the_title() )
                        );
                        $link_html = '';
                    }

                    $items .= sprintf(
                        '<article class="group relative flex flex-col items-start">
                            %s
                            %s
                            <p class="relative z-10 mt-2 text-sm text-zinc-600 dark:text-zinc-400">%s</p>
                            %s
                        </article>',
                        $title_html,
                        $period_html,
                        esc_html( get_the_excerpt() ),
                        $link_html
                    );
                }

                wp_reset_postdata();

                $output .= sprintf(
                    '<section aria-labelledby="category-%d" class="md:border-l md:border-zinc-100 md:pl-6 md:dark:border-zinc-700/40">
                        <div class="grid max-w-3xl grid-cols-1 items-baseline gap-y-8 md:grid-cols-4">
                            <h2 id="category-%d" class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">%s</h2>
                            <div class="md:col-span-3">
                                <div class="space-y-16">%s</div>
                            </div>
                        </div>
                    </section>',
                    $category->term_id,
                    $category->term_id,
                    esc_html( $category->name ),
                    $items
                );
            }

            $output .= '</div>';

            return $output;
        },
    ) );
}
