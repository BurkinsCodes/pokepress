<?php
/**
 * Plugin Name: PokePress
 * Description: A WordPress plugin that displays Pokémon info using the PokeAPI.
 * Version: 1.0
 * Author: Dylan Burkins
 * License: GPL2
 */

defined( 'ABSPATH' ) || exit;
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
PokePress\PokePress::init();
