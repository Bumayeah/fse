<?php

function fse_pagination_range( $current, $total, $each_side = 2 ) {
    $range = [];

    for ( $i = 1; $i <= $total; $i++ ) {
        if (
            $i === 1 || $i === $total ||
            ( $i >= $current - $each_side && $i <= $current + $each_side )
        ) {
            $range[] = $i;
        }
    }

    $pages    = [];
    $last_val = null;

    foreach ( $range as $page ) {
        if ( $last_val !== null && $page - $last_val > 1 ) {
            $pages[] = '...';
        }
        $pages[]  = $page;
        $last_val = $page;
    }

    return $pages;
}

function fse_register_blog_archive_block() {
    register_block_type( 'fse/blog-archive', array(
        'attributes' => array(
            'perPage' => array(
                'type'    => 'number',
                'default' => 10,
            ),
        ),
        'render_callback' => function( $attributes ) {
            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

            $query = new WP_Query( array(
                'post_type'      => 'post',
                'posts_per_page' => $attributes['perPage'],
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'paged'          => $paged,
            ) );

            $output  = '<div class="md:border-l md:border-zinc-100 md:pl-6 md:dark:border-zinc-700/40">';
            $output .= '<div class="flex max-w-3xl flex-col space-y-16">';

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();

                    $output .= sprintf(
                        '<article class="md:grid md:grid-cols-4 md:items-baseline">
                            <div class="md:col-span-3 group relative flex flex-col items-start">
                                <h2 class="text-base font-semibold tracking-tight text-zinc-800 dark:text-zinc-100">
                                    <div class="absolute -inset-x-4 -inset-y-6 z-0 scale-95 bg-zinc-50 opacity-0 transition group-hover:scale-100 group-hover:opacity-100 sm:-inset-x-6 sm:rounded-2xl dark:bg-zinc-800/50"></div>
                                    <a href="%1$s"><span class="absolute -inset-x-4 -inset-y-6 z-20 sm:-inset-x-6 sm:rounded-2xl"></span><span class="relative z-10">%2$s</span></a>
                                </h2>
                                <time class="md:hidden relative z-10 order-first mb-3 flex items-center text-sm text-zinc-400 dark:text-zinc-500 pl-3.5" datetime="%3$s">
                                    <span class="absolute inset-y-0 left-0 flex items-center" aria-hidden="true"><span class="h-4 w-0.5 rounded-full bg-zinc-200 dark:bg-zinc-500"></span></span>
                                    %4$s
                                </time>
                                <p class="relative z-10 mt-2 text-sm text-zinc-600 dark:text-zinc-400">%5$s</p>
                                <div aria-hidden="true" class="relative z-10 mt-4 flex items-center text-sm font-medium text-teal-500">
                                    Read article<svg viewBox="0 0 16 16" fill="none" aria-hidden="true" class="ml-1 h-4 w-4 stroke-current"><path d="M6.75 5.75 9.25 8l-2.5 2.25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                            </div>
                            <time class="mt-1 max-md:hidden relative z-10 order-first mb-3 flex items-center text-sm text-zinc-400 dark:text-zinc-500" datetime="%3$s">%4$s</time>
                        </article>',
                        esc_url( get_permalink() ),
                        esc_html( get_the_title() ),
                        esc_attr( get_the_date( 'Y-m-d' ) ),
                        esc_html( get_the_date( 'F j, Y' ) ),
                        esc_html( get_the_excerpt() )
                    );
                }

                wp_reset_postdata();
            }

            $output .= '</div>';
            $output .= '</div>';

            $total_pages = $query->max_num_pages;
            $total_posts = $query->found_posts;
            $per_page    = $attributes['perPage'];

            if ( $total_pages > 1 ) {
                $from = ( $paged - 1 ) * $per_page + 1;
                $to   = min( $paged * $per_page, $total_posts );

                $prev_svg = '<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"/></svg>';
                $next_svg = '<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"/></svg>';

                $output .= '<div class="flex items-center justify-between border-t border-zinc-100 dark:border-zinc-700/40 mt-16 px-4 py-3 sm:px-0">';

                // Mobile prev/next
                $output .= '<div class="flex flex-1 justify-between sm:hidden">';
                if ( $paged > 1 ) {
                    $output .= sprintf( '<a href="%s" class="relative inline-flex items-center rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800">Previous</a>', esc_url( get_pagenum_link( $paged - 1 ) ) );
                } else {
                    $output .= '<span class="relative inline-flex items-center rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 px-4 py-2 text-sm font-medium text-zinc-400 dark:text-zinc-500 opacity-50 cursor-not-allowed">Previous</span>';
                }
                if ( $paged < $total_pages ) {
                    $output .= sprintf( '<a href="%s" class="relative ml-3 inline-flex items-center rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800">Next</a>', esc_url( get_pagenum_link( $paged + 1 ) ) );
                } else {
                    $output .= '<span class="relative ml-3 inline-flex items-center rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 px-4 py-2 text-sm font-medium text-zinc-400 dark:text-zinc-500 opacity-50 cursor-not-allowed">Next</span>';
                }
                $output .= '</div>';

                // Desktop
                $output .= '<div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">';

                // Results count
                $output .= sprintf(
                    '<p class="text-sm text-zinc-600 dark:text-zinc-400">Showing <span class="font-medium">%d</span> to <span class="font-medium">%d</span> of <span class="font-medium">%d</span> results</p>',
                    $from, $to, $total_posts
                );

                // Numbered nav
                $output .= '<nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md">';

                $class_default  = 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-zinc-700 dark:text-zinc-200 inset-ring inset-ring-zinc-200 dark:inset-ring-zinc-700 hover:bg-zinc-50 dark:hover:bg-white/5 focus:z-20 focus:outline-offset-0 transition';
                $class_current  = 'relative z-10 inline-flex items-center bg-teal-500 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-500';
                $class_ellipsis = 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-zinc-400 dark:text-zinc-500 inset-ring inset-ring-zinc-200 dark:inset-ring-zinc-700';
                $class_arrow    = 'relative inline-flex items-center px-2 py-2 text-zinc-400 dark:text-zinc-500 inset-ring inset-ring-zinc-200 dark:inset-ring-zinc-700 hover:bg-zinc-50 dark:hover:bg-white/5 focus:z-20 focus:outline-offset-0 transition';

                // Prev arrow
                if ( $paged > 1 ) {
                    $output .= sprintf( '<a href="%s" class="%s rounded-l-md"><span class="sr-only">Previous</span>%s</a>', esc_url( get_pagenum_link( $paged - 1 ) ), $class_arrow, $prev_svg );
                } else {
                    $output .= sprintf( '<span class="%s rounded-l-md opacity-50 cursor-not-allowed"><span class="sr-only">Previous</span>%s</span>', $class_arrow, $prev_svg );
                }

                // Page numbers
                $pages = fse_pagination_range( $paged, $total_pages );
                foreach ( $pages as $page ) {
                    if ( $page === '...' ) {
                        $output .= sprintf( '<span class="%s">…</span>', $class_ellipsis );
                    } elseif ( $page === $paged ) {
                        $output .= sprintf( '<span aria-current="page" class="%s">%d</span>', $class_current, $page );
                    } else {
                        $output .= sprintf( '<a href="%s" class="%s">%d</a>', esc_url( get_pagenum_link( $page ) ), $class_default, $page );
                    }
                }

                // Next arrow
                if ( $paged < $total_pages ) {
                    $output .= sprintf( '<a href="%s" class="%s rounded-r-md"><span class="sr-only">Next</span>%s</a>', esc_url( get_pagenum_link( $paged + 1 ) ), $class_arrow, $next_svg );
                } else {
                    $output .= sprintf( '<span class="%s rounded-r-md opacity-50 cursor-not-allowed"><span class="sr-only">Next</span>%s</span>', $class_arrow, $next_svg );
                }

                $output .= '</nav>';
                $output .= '</div>';
                $output .= '</div>';
            }

            return $output;
        },
    ) );
}
