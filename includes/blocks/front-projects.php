<?php

function fse_register_front_projects_block() {
    register_block_type( 'fse/front-projects', array(
        'attributes' => array(
            'title'   => array( 'type' => 'string', 'default' => 'Projects' ),
            'perPage' => array( 'type' => 'number', 'default' => 3 ),
        ),
        'render_callback' => function( $attributes ) {
            $query = new WP_Query( array(
                'post_type'      => 'project',
                'posts_per_page' => $attributes['perPage'],
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'ASC',
            ) );

            if ( ! $query->have_posts() ) {
                return '';
            }

            $items = '';

            while ( $query->have_posts() ) {
                $query->the_post();

                $project_url = get_post_meta( get_the_ID(), '_project_url', true );
                $logo        = get_the_post_thumbnail( get_the_ID(), array( 28, 28 ), array(
                    'class'   => 'h-7 w-7 object-contain',
                    'loading' => 'lazy',
                ) );

                $logo_html = $logo
                    ? sprintf(
                        '<div class="relative mt-1 flex h-10 w-10 flex-none items-center justify-center rounded-full shadow-md ring-1 shadow-zinc-800/5 ring-zinc-900/5 dark:border dark:border-zinc-700/50 dark:bg-zinc-800 dark:ring-0">%s</div>',
                        $logo
                    )
                    : '';

                $title_html = $project_url
                    ? sprintf( '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>', esc_url( $project_url ), esc_html( get_the_title() ) )
                    : esc_html( get_the_title() );

                $items .= sprintf(
                    '<li class="flex gap-4">
                        %s
                        <dl class="flex flex-auto flex-wrap gap-x-2">
                            <dt class="sr-only">Project</dt>
                            <dd class="w-full flex-none text-sm font-medium text-zinc-900 dark:text-zinc-100">%s</dd>
                            <dt class="sr-only">Description</dt>
                            <dd class="text-xs text-zinc-500 dark:text-zinc-400">%s</dd>
                        </dl>
                    </li>',
                    $logo_html,
                    $title_html,
                    esc_html( get_the_excerpt() )
                );
            }

            wp_reset_postdata();

            return sprintf(
                '<div class="rounded-2xl border border-zinc-100 p-6 dark:border-zinc-700/40">
                    <h2 class="flex text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="h-6 w-6 flex-none">
                            <path d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" class="stroke-zinc-400 dark:stroke-zinc-500"></path>
                        </svg>
                        <span class="ml-3">%s</span>
                    </h2>
                    <ol class="mt-6 space-y-4">%s</ol>
                </div>',
                esc_html( $attributes['title'] ),
                $items
            );
        },
    ) );
}
