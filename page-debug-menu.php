<?php
/**
 * Template Name: Debug Menu Template
 */
get_header(); ?>

<div style="background: green; color: white; padding: 10px;">
  ✅ Debug Template ist aktiv
</div>

<div style="padding: 20px;">
  <h2>Navigationstest</h2>
  <nav class="main_nav" style="background: #222; padding: 1rem;">
    <p style="color: red; font-weight: bold;">Navigation geladen!</p>
    <?php
    if (has_nav_menu('main_menu')) {
      wp_nav_menu(array(
        'theme_location' => 'main_menu',
        'menu_class' => 'level_a',
        'container' => false
      ));
    } else {
      echo '<p style="color: orange;">⚠️ Kein Menü zugewiesen (main_menu)</p>';
    }
    ?>
  </nav>
</div>

<?php get_footer(); ?>
