<?php

function fse_register_projects_block() {
    register_block_type( 'fse/projects', array(
        'attributes' => array(
            'perPage' => array(
                'type'    => 'number',
                'default' => 5,
            ),
        ),
        'render_callback' => function( $attributes ) {
            $query = new WP_Query( array(
                'post_type'      => 'post',
                'posts_per_page' => $attributes['perPage'],
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ) );

            if ( ! $query->have_posts() ) {
                return '';
            }

            $output = '<div class="flex flex-col gap-16">';

            while ( $query->have_posts() ) {
                $query->the_post();

                $output .= sprintf(
                    '<article class="group relative flex flex-col items-start">
                        <h2 class="text-base font-semibold tracking-tight text-zinc-800 dark:text-zinc-100">
                            <div class="absolute -inset-x-4 -inset-y-6 z-0 scale-95 bg-zinc-50 opacity-0 transition group-hover:scale-100 group-hover:opacity-100 sm:-inset-x-6 sm:rounded-2xl dark:bg-zinc-800/50"></div>
                            <a href="%s"><span class="absolute -inset-x-4 -inset-y-6 z-20 sm:-inset-x-6 sm:rounded-2xl"></span><span class="relative z-10">%s</span></a>
                        </h2>
                        <time class="relative z-10 order-first mb-3 flex items-center text-sm text-zinc-400 dark:text-zinc-500 pl-3.5" datetime="%s">
                            <span class="absolute inset-y-0 left-0 flex items-center" aria-hidden="true"><span class="h-4 w-0.5 rounded-full bg-zinc-200 dark:bg-zinc-500"></span></span>
                            %s
                        </time>
                        <p class="relative z-10 mt-2 text-sm text-zinc-600 dark:text-zinc-400">%s</p>
                        <div aria-hidden="true" class="relative z-10 mt-4 flex items-center text-sm font-medium text-teal-500">
                            Read project<svg viewBox="0 0 16 16" fill="none" aria-hidden="true" class="ml-1 h-4 w-4 stroke-current"><path d="M6.75 5.75 9.25 8l-2.5 2.25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </article>',
                    esc_url( get_permalink() ),
                    esc_html( get_the_title() ),
                    esc_attr( get_the_date( 'Y-m-d' ) ),
                    esc_html( get_the_date( 'F j, Y' ) ),
                    esc_html( get_the_excerpt() )
                );
            }

            wp_reset_postdata();

            $output .= '</div>';

            return $output;
        },
    ) );
}
