<?php

/*
 * Plugin Name: WP_luch
 */



require_once __DIR__ . '/metaboxes.php';
require_once __DIR__ . '/cpt.php';
require_once __DIR__ . '/shortcode.php';




function load_luch_course_template( $template ) {
  global $post;

  if ( 'luch_course' === $post->post_type && locate_template( array( 'single-luch_course.php' ) ) !== $template ) {
      /*
       * This is a 'luch_course' post
       * AND a 'single luch_course template' is not found on
       * theme or child theme directories, so load it
       * from our plugin directory.
       */
      return plugin_dir_path( __FILE__ ) . 'single-luch_course.php';
  }

  return $template;
}

add_filter( 'single_template', 'load_luch_course_template' );