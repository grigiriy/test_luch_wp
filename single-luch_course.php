<?php
/*
  Template Name: Template luch_course
*/

/*

Возможно, стоило вынести в отдельный темплейт-парт, чтобы убрать дублирование, но уже не успел
Также, убрал здесь ссылку на запись

*/

?>

<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php
  while (have_posts()) :
    the_post();
  ?>


    <div>
      <h2><?= $post->post_title; ?></h2>

      <?php if (get_post_meta($post->ID, 'hours_meta_key', 1)) { ?>
        <p>Часов: <?= get_post_meta($post->ID, 'hours_meta_key', 1); ?></p>
      <?php } ?>

      <?php if (get_post_meta($post->ID, 'plan_meta_key', 1)) { ?>
        <p><a href="<?= get_post_meta($post->ID, 'plan_meta_key', 1)['url']; ?>" download>Учебный план</a></p>
      <?php } ?>
    </div>

  <?php endwhile; ?>

<?php endif; ?>


<?php
get_footer();
?>