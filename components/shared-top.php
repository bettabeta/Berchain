<?php
/**
 * Shared Top Section Template (for homepage and inner pages)
 */

global $post;
$post_id = isset($post) && isset($post->ID) ? $post->ID : null;

// Custom title/description support
$custom_title = '';
$custom_description = '';
if (isset($args) && is_array($args)) {
    $custom_title = $args['custom_title'] ?? '';
    $custom_description = $args['custom_description'] ?? '';
}

// Get header background
$bg = get_field('home_top_bg');
$bg_url = ($bg && isset($bg['sizes']['large']))
    ? esc_url($bg['sizes']['large'])
    : get_template_directory_uri() . '/img/home-default.jpg';

// Use custom title/desc if set, else fallback
$title = $custom_title ?: (get_field('home_top_title') ?: get_the_title());
$description = $custom_description ?: get_field('home_top_description');

$label = get_field('page_header_button_label');
$button = get_field('page_header_button');
$icon = get_field('page_header_button_icon');
$class = get_field('page_header_button_class');
?>

<div class="home-top-section">
  <div class="wrap1720">
    <div class="bg" data-bg style="--bg-image: url('<?php echo $bg_url; ?>');">
      <div class="bg-overlay"></div>
      <div class="header-box flex v-center">
        <div class="home-top-info">
          <?php if ($title) : ?>
            <div class="title-block">
              <h1><?php echo esc_html($title); ?></h1>
            </div>
          <?php endif; ?>
          
          <?php if ($description) : ?>
            <div class="info-block">
              <?php echo wp_kses_post($description); ?>
            </div>
          <?php endif; ?>

          <?php if ($button && $label): ?>
            <a href="<?php echo esc_url($button['url']); ?>" class="btn">
              <?php if ($icon): ?><i class="<?php echo esc_attr($icon); ?>"></i><?php endif; ?>
              <?php echo esc_html($label); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
