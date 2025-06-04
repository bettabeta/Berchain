<?php
/* Template Name: Front Page */
get_header();
global $post;
?>

<?php
// The header section is now included via header.php → components/shared-top.php
?>

<?php get_template_part('ilya'); ?>

<?php if (get_field('title_right') || get_field('image_bottom') || have_rows('cards')) : ?>
  <div class="connecting-blockchain">
    <div class="wrap-large wide-block">
      <div class="wrap flex">
        <div class="left" data-aos="fade-right">
          <?php if (get_field('title_right')) : ?>
            <h2><?php echo get_field('title_right'); ?></h2>
          <?php endif; ?>
          <?php if ($intro = get_field('berchain_intro_text')): ?>
            <div class="berchain-intro-text">
              <?php echo wpautop($intro); ?>
            </div>
          <?php endif; ?>
          <?php if (get_field('image_bottom')) : ?>
            <?php $image = get_field('image_bottom'); ?>
            <?php $size = 'large'; ?>
            <figure class="image">
              <img src="<?php echo $image['sizes'][$size]; ?>"
                   width="<?php echo $image['sizes'][$size . '-width']; ?>"
                   height="<?php echo $image['sizes'][$size . '-height']; ?>"
                   alt="<?php echo $image['alt'] ? $image['alt'] : $image['title']; ?>"/>
            </figure>
          <?php endif; ?>
        </div>
        <?php if (have_rows('cards')) : ?>
          <div class="right">
            <?php 
            $duration = 500;
            while (have_rows('cards')) : the_row(); ?>
              <div class="item" data-aos="fade-left" data-aos-duration="<?php echo $duration += 500; ?>">
                <div class="text" style="padding-left: 65px;">
                  <?php echo wp_kses_post(get_sub_field('text_card')); ?>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php get_template_part('components/join', 'section'); ?>
<?php // get_template_part('components/events', 'section'); ?>
<?php get_template_part('components/ecosystem-section'); ?>


<div class="partners">
  <div class="wrap">
    <?php if (get_field('partners_title')) : ?>
      <h2 class="title" data-aos="fade-right">
        <?php echo esc_html(get_field('partners_title')); ?>
      </h2>
    <?php endif; ?>

    <?php if ($partners = get_field('partners')) : ?>
      <div class="partners-logo">
        <?php $duration = 500;
        foreach ($partners as $item) :
          $image = $item['logo'];
          $link = $item['link'];
          if ($image && $link): 
            $size = 'large';
            $url = $link['url'];
            $target = $link['target'] ?? '_self'; ?>
            
            <a href="<?php echo esc_url($url); ?>" class="partner-logo"
               target="<?php echo esc_attr($target); ?>"
               data-aos="fade-down" data-aos-duration="<?php echo $duration += 500; ?>">
              <img src="<?php echo esc_url($image['sizes'][$size]); ?>"
                   alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>">
            </a>

          <?php endif;
        endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php get_template_part('components/member-slider'); ?>
<?php get_footer(); ?>
