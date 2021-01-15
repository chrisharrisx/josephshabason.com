<?php 

$context = Timber::get_context();

if (is_category()) {
  $category = get_queried_object();

  if ($category->category_nicename == 'film-tv') {
    $context['films'] = Timber::get_posts(array(
      'post_status' => 'publish',
      'category__in' => 10,
    ));
    $context['tv'] = Timber::get_posts(array(
      'post_status' => 'publish',
      'category__in' => 12,
    ));
    $context['ads'] = Timber::get_posts(array(
      'post_status' => 'publish',
      'category__in' => 13,
    ));
    $template = 'category-film-tv-ads.twig';
  }
  else {
    $context['posts'] = Timber::get_posts(array(
      'post_status' => 'publish',
      'category__in' => $category->term_id
    ));
    $template = 'category.twig';
  }
  
  $context['is_category'] = true;
}
else if (is_post_type_archive(array('news'))) {
  $context['posts'] = Timber::get_posts();
  $template = 'news.twig';
}
else if (is_post_type_archive(array('shows'))) {
  // $context['posts'] = Timber::get_posts();
  $context['posts'] = Timber::get_posts(array(
    'post_type' => 'shows',
    'post_status' => 'publish',
    'meta_key' => 'show_date',
    'orderby' => 'meta_value'
  ));
  $template = 'shows.twig';
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

