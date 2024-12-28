<?php

namespace PokePress;

class Block {

    // Enqueue necessary scripts and styles
    public static function enqueue_assets() {
        // Enqueue the block editor JS
        wp_enqueue_script(
            'pokepress-block-js',
            plugins_url( 'assets/js/block.js', __FILE__ ),
            [ 'wp-blocks', 'wp-editor', 'wp-element', 'wp-components' ],
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/block.js' ),
            true
        );

        // Enqueue the block CSS
        wp_enqueue_style(
            'pokepress-block-style',
            plugins_url( 'assets/css/style.css', __FILE__ ),
            [],
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/css/style.css' )
        );
    }
}