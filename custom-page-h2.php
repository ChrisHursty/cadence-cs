<?php

function custom_page_h2_block_init() {
    register_block_type( 'codewp/custom-page-h2', array(
        'editor_script'   => 'custom-page-h2-editor-script',
        'render_callback' => 'custom_page_h2_block_render',
    ) );
}

function custom_page_h2_block_render( $attributes ) {
    $content = isset( $attributes['content'] ) ? $attributes['content'] : '';

    // Add the necessary CSS classes
    $output = '<div class="custom-page-h2">';
    $output .= '<h2>' . esc_html( $content ) . '</h2>';
    $output .= '</div>';

    return $output;
}

add_action( 'init', 'custom_page_h2_block_init' );