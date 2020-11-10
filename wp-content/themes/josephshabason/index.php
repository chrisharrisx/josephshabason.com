<?php 

$context = Timber::get_context();

if (is_category()) {
  $context['posts'] = Timber::get_posts();
  $context['is_category'] = true;
  $template = 'category.twig';
}
else {
  $context['post'] = new Timber\Post();
  $context['is_category'] = false;

  if (is_front_page()) {
    $template = 'front.twig';
  }
  else if (is_singular()) {
    $template = 'singular.twig';
  }
  else {
    $template = 'index.twig';
  }
}

Timber::render($template, $context);

?>

