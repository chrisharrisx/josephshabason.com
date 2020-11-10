<?php

function theme_support() {
  add_theme_support('post-thumbnails');
  add_theme_support('custom-background', array('default-color' => '020202'));
  add_theme_support('title-tag');
  add_theme_support('align-wide');
  add_theme_support('responsive-embeds');
  add_theme_support('customize-selective-refresh-widgets');
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style',
    )
  );

  set_post_thumbnail_size(1200, 9999);
  load_theme_textdomain('josephshabason');

  global $content_width;

  if (!isset($content_width)) {
    $content_width = 580;
  }

  if (is_customize_preview()) {
    // require get_template_directory() . '/inc/starter-content.php';
    // add_theme_support('starter-content', twentytwenty_get_starter_content());
  }
}
add_action('after_setup_theme', 'theme_support');

function register_styles() {
  /* ASAP, headings / EUROPA, body font */
  wp_enqueue_style('typekit', 'https://use.typekit.net/ufa7toe.css', null, null, 'screen');
  wp_enqueue_style('icofont', '/dist/icofont/icofont.css', null, null, 'screen');
  
  /* Enqueue stylesheet with content hash, so that updates to styles will bust browser cache */
  $CSSfiles = new DirectoryIterator(get_stylesheet_directory() . '/dist/styles');

  foreach ($CSSfiles as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
      $fullName = basename($file);
      $name = substr(basename($fullName), 0, strpos(basename($fullName), '.'));
      
      wp_enqueue_style($name, get_template_directory_uri() . '/dist/styles/' . $fullName, null, null, 'screen');
    }
  }
}
add_action('wp_enqueue_scripts', 'register_styles');

function register_scripts() {
  wp_enqueue_script('index', get_template_directory_uri() . '/dist/main.js', array('jquery'), null, false);
  // wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/227f9a8ad2.js', array(), null, false);

  wp_enqueue_script('acf', '/wp-content/plugins/advanced-custom-fields/assets/js/acf-input.min.js', array('jquery'), null, false);
}
add_action('wp_enqueue_scripts', 'register_scripts');

function add_to_context($context) {
    $context['headerMenu'] = new \Timber\Menu('Header');
    return $context;
}
add_filter('timber/context', 'add_to_context');

function add_font_awesome_5_cdn_attributes($html, $handle) {
  if ($handle === 'font-awesome') {
    return str_replace("media='all'", "media='all' crossorigin='anonymous'", $html);
  }
  return $html;
}
add_filter('style_loader_tag', 'add_font_awesome_5_cdn_attributes', 10, 2);

function file_and_ext_webp($types, $file, $filename, $mimes) {
  if (false !== strpos( $filename, '.webp') ) {
    $types['ext'] = 'webp';
    $types['type'] = 'image/webp';
  }
  return $types;
}
add_filter('wp_check_filetype_and_ext', 'file_and_ext_webp', 10, 4);

function mime_types_webp($mimes) {
  $mimes['webp'] = 'image/webp';
  return $mimes;
}
add_filter('upload_mimes', 'mime_types_webp');

?>