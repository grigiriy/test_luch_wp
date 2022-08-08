<?php
function luch_register_post_type_init()
{
    $labels = array(
      'name' => 'Курсы повышения квалификации',
      'singular_name' => 'Курс повышения квалификации',
      'add_new' => 'Добавить курс',
      'add_new_item' => 'Добавить новый курс',
      'edit_item' => 'Редактировать курс',
      'new_item' => 'Новый курс',
      'all_items' => 'Все курсы',
      'view_item' => 'Просмотр курсов на сайте',
      'search_items' => 'Искать курс',
      'not_found' => 'Курсов не найдено.',
      'not_found_in_trash' => 'В корзине нет курсов.',
      'menu_name' => 'Курсы повышения квалификации'
    );
    $args = array(
      'labels' => $labels,
      'public' => true,
      'show_ui' => true,
      'has_archive' => false,
      'show_in_rest' => false,
      'menu_position' => 50,
      'menu_icon' => 'dashicons-welcome-learn-more',
      'supports' => array(
        'title',
        'page-attributes',
      )
    );
    register_post_type ( 'luch_course', $args );



} //function close    

add_action('init', 'luch_register_post_type_init');