<?php 

$context = Timber::get_context();

if (is_post_type_archive(array('news'))) {
  $context['posts'] = Timber::get_posts();
  $template = 'news.twig';
}
else if (is_post_type_archive(array('shows'))) {
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

  if (is_front_page()) {
    $template = 'front.twig';
    $context['is_category'] = false;
  }
  else if (is_singular()) {
    $categories = get_field('category_posts');
    $category_posts = array();

    if (!empty($categories)) {
      foreach($categories as $category) {
        $posts = Timber::get_posts(array(
          'post_status' => 'publish',
          'category__in' => $category['category']
        ));
        array_push($category_posts, array(
          'title' => $category['title'],
          'slug' => preg_replace('/[^a-zA-Z]/', '-', $category['title']), 
          'posts' => $posts
        ));
      }

      $context['categories'] = $category_posts;
      $context['is_category'] = true;
      $template = 'category.twig';
    }
    else {
      $template = array(
        $context['post']->slug . '.twig', 
        'singular.twig'
      );
      $context['is_category'] = false;
    }
  }
  else {
    $template = 'index.twig';
  }
}

Timber::render($template, $context);

?>

