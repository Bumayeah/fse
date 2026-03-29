<?php

function fse_register_skills_block() {
    register_block_type( 'fse/skills', array(
        'render_callback' => function( $attributes ) {
            $categories = get_terms( array(
                'taxonomy'   => 'skill_category',
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ) );

            if ( is_wp_error( $categories ) || empty( $categories ) ) {
                return '';
            }

            $output = '<div class="space-y-20">';

            foreach ( $categories as $category ) {
                $query = new WP_Query( array(
                    'post_type'      => 'skill',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'skill_category',
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

                    $items .= sprintf(
                        '<li class="group relative flex flex-col items-start">
                            <h3 class="text-base font-semibold tracking-tight text-zinc-800 dark:text-zinc-100">%s</h3>
                            <p class="relative z-10 mt-2 text-sm text-zinc-600 dark:text-zinc-400">%s</p>
                        </li>',
                        esc_html( get_the_title() ),
                        esc_html( get_the_excerpt() )
                    );
                }

                wp_reset_postdata();

                $output .= sprintf(
                    '<section aria-labelledby="category-%d" class="md:border-l md:border-zinc-100 md:pl-6 md:dark:border-zinc-700/40">
                        <div class="grid max-w-3xl grid-cols-1 items-baseline gap-y-8 md:grid-cols-4">
                            <h2 id="category-%d" class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">%s</h2>
                            <div class="md:col-span-3">
                                <ul role="list" class="space-y-16">%s</ul>
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
