<?php

namespace PokePress;

class PokePress {
    public static function init() {
        add_action( 'init', [ __CLASS__, 'register_block' ] );
    }

    public static function register_block() {
        Block::enqueue_assets();
    
        register_block_type( 'pokepress/block', [
            'editor_script'   => 'pokepress-block-js',
            'editor_style'    => 'pokepress-block-style',
            'render_callback' => [ __CLASS__, 'render_block' ],
        ] );
    }    

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
