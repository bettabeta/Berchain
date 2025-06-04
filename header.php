<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <title><?php echo wp_get_document_title(); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id="wrap">
  <header class="header-wrapper">
  <div class="wrap1720">
    <a href="<?php echo home_url(); ?>" id="logo">
      <?php if ($logo = get_field('header_logo','option')): ?>
        <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']?:'Logo'); ?>">
      <?php endif; ?>
    </a>

    <button class="burger-menu">
      <span></span><span></span><span></span>
    </button>

    <nav class="desktop-nav">
      <?php wp_nav_menu([
        'theme_location'=>'main_menu',
        'container'=>false,
        'menu_class'=>'desktop-menu'
      ]); ?>
    </nav>

    <nav class="mobile-menu-container">
      <?php wp_nav_menu([
        'theme_location'=>'main_menu',
        'container'=>false,
        'menu_class'=>'mobile-menu'
      ]); ?>
    </nav>
  </div>
</header>

<?php
// Show shared-top on all pages except blog index and single posts
if (!is_home() && !is_singular('post')) {
    get_template_part('components/shared-top');
}
?>
