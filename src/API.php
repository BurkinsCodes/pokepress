<?php

namespace PokePress;

class API {
    public static function get_pokemon_data( $pokemon_id ) {
        $response = wp_remote_get( "https://pokeapi.co/api/v2/pokemon/{$pokemon_id}" );

        if ( is_wp_error( $response ) ) {
            return null;
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        return $data;
    }
}
