<?php

function fse_register_work_block() {
    register_block_type( 'fse/work', array(
        'attributes' => array(
            'title'    => array( 'type' => 'string', 'default' => 'Work' ),
            'cvUrl'    => array( 'type' => 'string', 'default' => '' ),
            'cvLabel'  => array( 'type' => 'string', 'default' => 'Download CV' ),
            'jobs'     => array(
                'type'    => 'array',
                'default' => array(),
                'items'   => array(
                    'type'       => 'object',
                    'properties' => array(
                        'company'   => array( 'type' => 'string' ),
                        'role'      => array( 'type' => 'string' ),
                        'logoId'    => array( 'type' => 'integer' ),
                        'startYear' => array( 'type' => 'string' ),
                        'endYear'   => array( 'type' => 'string' ),
                    ),
                ),
            ),
        ),
        'render_callback' => function( $attributes ) {
            $jobs_html = '';
            foreach ( $attributes['jobs'] as $job ) {
                $company    = isset( $job['company'] ) ? $job['company'] : '';
                $role       = isset( $job['role'] ) ? $job['role'] : '';
                $logo_id    = isset( $job['logoId'] ) ? intval( $job['logoId'] ) : 0;
                $start_year = isset( $job['startYear'] ) ? $job['startYear'] : '';
                $end_year   = isset( $job['endYear'] ) ? $job['endYear'] : '';

                $end_label    = $end_year ? $end_year : 'Present';
                $end_datetime = $end_year ? $end_year : date( 'Y' );
                $aria_label   = sprintf( '%s until %s', esc_attr( $start_year ), esc_attr( $end_label ) );

                $logo_html = '';
                if ( $logo_id ) {
                    $logo_html = wp_get_attachment_image( $logo_id, array( 28, 28 ), false, array(
                        'class'   => 'h-7 w-7 object-contain',
                        'loading' => 'lazy',
                    ) );
                }

                $jobs_html .= sprintf(
                    '<li class="flex gap-4">
                        <div class="relative mt-1 flex h-10 w-10 flex-none items-center justify-center rounded-full shadow-md ring-1 shadow-zinc-800/5 ring-zinc-900/5 dark:border dark:border-zinc-700/50 dark:bg-zinc-800 dark:ring-0">
                            %s
                        </div>
                        <dl class="flex flex-auto flex-wrap gap-x-2">
                            <dt class="sr-only">Company</dt>
                            <dd class="w-full flex-none text-sm font-medium text-zinc-900 dark:text-zinc-100">%s</dd>
                            <dt class="sr-only">Role</dt>
                            <dd class="text-xs text-zinc-500 dark:text-zinc-400">%s</dd>
                            <dt class="sr-only">Date</dt>
                            <dd class="ml-auto text-xs text-zinc-400 dark:text-zinc-500" aria-label="%s">
                                <time datetime="%s">%s</time>
                                <span aria-hidden="true">—</span>
                                <time datetime="%s">%s</time>
                            </dd>
                        </dl>
                    </li>',
                    $logo_html,
                    esc_html( $company ),
                    esc_html( $role ),
                    $aria_label,
                    esc_attr( $start_year ),
                    esc_html( $start_year ),
                    esc_attr( $end_datetime ),
                    esc_html( $end_label )
                );
            }

            $cv_link = '';
            if ( ! empty( $attributes['cvUrl'] ) ) {
                $cv_link = sprintf(
                    '<a class="inline-flex items-center gap-2 justify-center rounded-md py-2 px-3 text-sm outline-offset-2 transition active:transition-none bg-zinc-50 font-medium text-zinc-900 hover:bg-zinc-100 active:bg-zinc-100 active:text-zinc-900/60 dark:bg-zinc-800/50 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-zinc-50 dark:active:bg-zinc-800/50 dark:active:text-zinc-50/70 group mt-6 w-full" href="%s">%s<svg viewBox="0 0 16 16" fill="none" aria-hidden="true" class="h-4 w-4 stroke-zinc-400 transition group-active:stroke-zinc-600 dark:group-hover:stroke-zinc-50 dark:group-active:stroke-zinc-50"><path d="M4.75 8.75 8 12.25m0 0 3.25-3.5M8 12.25v-8.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>',
                    esc_url( $attributes['cvUrl'] ),
                    esc_html( $attributes['cvLabel'] )
                );
            }

            return sprintf(
                '<div class="rounded-2xl border border-zinc-100 p-6 dark:border-zinc-700/40">
                    <h2 class="flex text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="h-6 w-6 flex-none">
                            <path d="M2.75 9.75a3 3 0 0 1 3-3h12.5a3 3 0 0 1 3 3v8.5a3 3 0 0 1-3 3H5.75a3 3 0 0 1-3-3v-8.5Z" class="fill-zinc-100 stroke-zinc-400 dark:fill-zinc-100/10 dark:stroke-zinc-500"></path>
                            <path d="M3 14.25h6.249c.484 0 .952-.002 1.316.319l.777.682a.996.996 0 0 0 1.316 0l.777-.682c.364-.32.832-.319 1.316-.319H21M8.75 6.5V4.75a2 2 0 0 1 2-2h2.5a2 2 0 0 1 2 2V6.5" class="stroke-zinc-400 dark:stroke-zinc-500"></path>
                        </svg>
                        <span class="ml-3">%s</span>
                    </h2>
                    <ol class="mt-6 space-y-4">%s</ol>
                    %s
                </div>',
                esc_html( $attributes['title'] ),
                $jobs_html,
                $cv_link
            );
        },
    ) );
}
