<?php

/*
 * Plugin Name: WP_luch
 */



require_once __DIR__ . '/cpt.php';
add_action('init', 'luch_register_post_type_init');
