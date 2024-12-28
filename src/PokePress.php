<?php

namespace PokePress;

class PokePress {

    // Initialize the plugin
    public static function init() {
        // Register block
        add_action( 'init', [ __CLASS__, 'register_block' ] );
    }

    // Register Block
    public static function register_block() {
        // Register Block Script
        wp_register_script(
            'pokepress-block-js',
            plugins_url( 'assets/js/block.js', __FILE__ ),
            [ 'wp-blocks', 'wp-editor', 'wp-element', 'wp-components' ],
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/block.js' )
        );

        // Register Block Style
        wp_register_style(
            'pokepress-block-style',
            plugins_url( 'assets/css/style.css', __FILE__ ),
            [],
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/css/style.css' )
        );

        // Register Block Type
        register_block_type( 'pokepress/block', [
            'editor_script' => 'pokepress-block-js',
            'editor_style'  => 'pokepress-block-style',
            'render_callback' => [ __CLASS__, 'render_block' ],
        ] );
    }

    // Render block callback
    public static function render_block( $attributes ) {
        $pokemon = isset( $attributes['pokemonData'] ) ? $attributes['pokemonData'] : null;

        if ( ! $pokemon ) {
            return '';
        }

        ob_start();
        ?>
        <div class="pokemon-info">
            <h3><?php echo esc_html( $pokemon['name'] ); ?></h3>
            <img src="<?php echo esc_url( $pokemon['sprites']['front_default'] ); ?>" alt="<?php echo esc_attr( $pokemon['name'] ); ?>" />
            <ul>
                <li>Height: <?php echo esc_html( $pokemon['height'] ); ?></li>
                <li>Weight: <?php echo esc_html( $pokemon['weight'] ); ?></li>
                <li>Types: <?php echo esc_html( implode( ', ', array_map( fn( $type ) => $type['type']['name'], $pokemon['types'] ) ) ); ?></li>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
}
