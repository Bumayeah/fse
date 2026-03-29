<?php

function fse_register_photo_gallery_block() {
    register_block_type( 'fse/photo-gallery', array(
        'attributes' => array(
            'imageIds' => array(
                'type'    => 'array',
                'items'   => array( 'type' => 'integer' ),
                'default' => array(),
            ),
        ),
        'render_callback' => function( $attributes ) {
            $image_ids = $attributes['imageIds'];

            if ( empty( $image_ids ) ) {
                return '';
            }

            $rotations = array( 'rotate-2', '-rotate-2', 'rotate-2', 'rotate-2', '-rotate-2' );

            $parallax_factors = array( '0.12', '-0.09', '0.15', '-0.11', '0.08' );

            $output = '<div id="photo-gallery" class="mt-16 sm:mt-20"><div class="-my-4 flex justify-center gap-5 overflow-hidden py-4 sm:gap-8">';

            foreach ( $image_ids as $index => $id ) {
                $rotation = $rotations[ $index % count( $rotations ) ];
                $factor   = $parallax_factors[ $index % count( $parallax_factors ) ];
                $img      = wp_get_attachment_image( $id, 'large', false, array(
                    'class'        => 'absolute left-0 w-full h-[150%] -top-[25%] object-cover',
                    'loading'      => 'lazy',
                    'data-parallax' => $factor,
                ) );

                $output .= sprintf(
                    '<div class="relative w-44 flex-none overflow-hidden rounded-xl bg-zinc-100 sm:w-72 sm:rounded-2xl dark:bg-zinc-800 %s" data-gallery-card>
                        <figure>%s</figure>
                        <div class="aspect-9/10"></div>
                    </div>',
                    esc_attr( $rotation ),
                    $img
                );
            }

            $output .= '</div></div>';

            return $output;
        },
    ) );
}
