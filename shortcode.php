<?php

function get_course_info($atts){

  $data = shortcode_atts( [
		'id' => '',
	], $atts );

  $id = $atts['id'];

  // return gettype($id);

  if( is_numeric($id) && is_int($id + 0) ){
      $course = get_post($id);

      if(!$course)  {
        wp_die('shortcode error: get_course - Нет поста с таким ID!');
      }

      if(get_post_type($id) !== 'luch_course'){
        wp_die('shortcode error: get_course - ID не от курса!');
      }
      


      $html = '<div>';
      $html .= '<h2>'.$course->post_title.'</h2>';
      $html .= '<p>Часов: '.get_post_meta($id, 'hours_meta_key',1).'</p>';
      $html .= '<p><a href="'.get_post_meta($id, 'plan_meta_key',1)['url'].'" download >Учебный план</a></p>';
      $html .= '<p><a href="'.get_post_permalink($id).'" >Перейти к курсу</a></p>';
      $html .= '</div>';

      return $html;

    } else {
      wp_die('shortcode error: get_course - ID не Int!');
    }
}
add_shortcode('get_course', 'get_course_info');



