<?php

namespace PokePress;

class Block {
    public static function enqueue_assets() {
        wp_register_script(
            'pokepress-block-js',
            plugins_url( '../assets/js/block.js', __FILE__ ),
            [ 'wp-blocks', 'wp-editor', 'wp-element', 'wp-components' ],
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/block.js' ),
            true
        );
    
        wp_register_style(
            'pokepress-block-style',
            plugins_url( '../assets/css/style.css', __FILE__ ),
            [],
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/css/style.css' )
        );
    }
}
