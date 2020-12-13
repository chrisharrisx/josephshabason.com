<?php 

$context = Timber::get_context();

if (is_category()) {
  $category = get_queried_object();

  $context['posts'] = Timber::get_posts(array(
    'post_status' => 'publish',
    'category__in' => $category->term_id
  ));
  $context['is_category'] = true;
  $template = 'category.twig';
}
else if (is_post_type_archive(array('news', 'tours'))) {
  $context['posts'] = Timber::get_posts();
  $template = $wp_query->query['post_type'] . '.twig';
}
else {
  $context['post'] = new Timber\Post();
  $context['is_category'] = false;

  if (is_front_page()) {
    $template = 'front.twig';
  }
  else if (is_singular()) {
    $template = array(
      $context['post']->slug . '.twig', 
      'singular.twig'
    );
  }
  else {
    $template = 'index.twig';
  }
}

Timber::render($template, $context);

?>

