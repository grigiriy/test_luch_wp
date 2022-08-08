<?php
/* В работе использую carbon_fields, метабоксы сами по себе, толком, и не создавал.
Поэтому тут ктрл+в с камы, а файл откуда-то еще
*/



add_action('add_meta_boxes', 'courses_add_custom_box');
function courses_add_custom_box()
{
  $screens = array('luch_course');
  add_meta_box('hours_sectionid', 'hours', 'hours_meta_box_callback', $screens);
  add_meta_box('plan_sectionid', 'plan', 'plan_meta_box_callback', $screens);
  add_meta_box('price_sectionid', 'price', 'price_meta_box_callback', $screens);
}




function hours_meta_box_callback($post, $meta)
{
  $screens = $meta['args'];

  wp_nonce_field(plugin_basename(__FILE__), 'courses_noncename');
  $value = get_post_meta($post->ID, 'hours_meta_key', 1);

  echo '<label for="hours_meta_key">Кол-во часов обучения</label> ';
  echo '<input type="text" id="hours_meta_key" name="hours_meta_key" value="' . $value . '" size="25" />';
}


function plan_meta_box_callback($post, $meta)
{
  $screens = $meta['args'];

  wp_nonce_field(plugin_basename(__FILE__), 'courses_noncename');
  $value = get_post_meta($post->ID, 'plan_meta_key', 1);

  echo '<label for="plan_meta_key">Учебный план</label> ';
  echo '<input type="file" id="plan_meta_key" name="plan_meta_key" value="" size="25" />';
  if ( $value != '' ) { 
    echo '<div><p>Загружен: ' . $value['url'] . '</p></div>'; 
}
}


function price_meta_box_callback($post, $meta)
{
  $screens = $meta['args'];

  wp_nonce_field(plugin_basename(__FILE__), 'courses_noncename');
  $value = get_post_meta($post->ID, 'price_meta_key', 1);

  echo '<label for="price_meta_key">Стоимость</label> ';
  echo '<input type="text" id="price_meta_key" name="price_meta_key" value="' . $value . '" size="25" />';
}








add_action('save_post', 'courses_save_postdata');
function courses_save_postdata($post_id)
{
  if (
    !isset($_POST['hours_meta_key']) &&
    !isset($_POST['plan_meta_key']) &&
    !isset($_POST['price_meta_key'])
  )
    return;

  if (!wp_verify_nonce($_POST['courses_noncename'], plugin_basename(__FILE__)))
    return;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;

  if (!current_user_can('edit_post', $post_id))
    return;

  $hours_meta_key = sanitize_text_field($_POST['hours_meta_key']);
  $price_meta_key = sanitize_text_field($_POST['price_meta_key']);

  update_post_meta($post_id, 'hours_meta_key', $hours_meta_key);
  update_post_meta($post_id, 'price_meta_key', $price_meta_key);



  // Make sure the file array isn't empty
  if (!empty($_FILES['plan_meta_key']['name'])) {

    // Setup the array of supported file types.
    $supported_types = array('application/pdf','application/docx','application/doc','.doc','.docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    // Последний тип - "ТЗ" файл, который я тестил

    // Get the file type of the upload
    $arr_file_type = wp_check_filetype(basename($_FILES['plan_meta_key']['name']));
    $uploaded_type = $arr_file_type['type'];

    // Check if the type is supported. If not, throw an error.
    if (in_array($uploaded_type, $supported_types)) {

      // Use the WordPress API to upload the file
      $upload = wp_upload_bits($_FILES['plan_meta_key']['name'], null, file_get_contents($_FILES['plan_meta_key']['tmp_name']));

      if (isset($upload['error']) && $upload['error'] != 0) {
        wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
      } else {
        add_post_meta($post_id, 'plan_meta_key', $upload);
        update_post_meta($post_id, 'plan_meta_key', $upload);
      } // end if/else

    } else {
      wp_die("The file type that you've uploaded is not supported.");
    } // end if/else

  } // end if
}



function update_edit_form() {
  echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'update_edit_form');